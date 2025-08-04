<?php

namespace App\Console\Commands;

use App\Models\Promotion;
use App\Models\Employee;
use App\Models\PromotionDelivery;
use App\Notifications\PromotionNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SendScheduledPromotions extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'promotions:send-scheduled 
                            {--dry-run : Show what would be sent without actually sending}
                            {--limit=50 : Maximum number of promotions to process}';

    /**
     * The console command description.
     */
    protected $description = 'Send scheduled promotions that are due';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $limit = (int) $this->option('limit');

        $this->info('Starting scheduled promotions processing...');
        
        if ($dryRun) {
            $this->warn('Running in DRY RUN mode - no emails/SMS will be sent');
        }

        try {
            $promotions = $this->getScheduledPromotions($limit);
            
            if ($promotions->isEmpty()) {
                $this->info('No scheduled promotions found to send.');
                return self::SUCCESS;
            }

            $this->info("Found {$promotions->count()} scheduled promotion(s) to process.");

            $processed = 0;
            $successful = 0;
            $failed = 0;

            foreach ($promotions as $promotion) {
                $this->newLine();
                $this->info("Processing: {$promotion->title} (ID: {$promotion->id})");
                
                try {
                    if ($dryRun) {
                        $this->showDryRunInfo($promotion);
                    } else {
                        $result = $this->sendPromotion($promotion);
                        
                        if ($result['success']) {
                            $successful++;
                            $this->info("✅ Sent successfully to {$result['sent_count']} recipients");
                            
                            if ($result['failed_count'] > 0) {
                                $this->warn("⚠️  {$result['failed_count']} deliveries failed");
                            }
                        } else {
                            $failed++;
                            $this->error("❌ Failed to send: {$result['error']}");
                        }
                    }
                    
                    $processed++;
                    
                } catch (\Exception $e) {
                    $failed++;
                    $this->error("❌ Error processing promotion {$promotion->id}: {$e->getMessage()}");
                    
                    Log::error('Error processing scheduled promotion', [
                        'promotion_id' => $promotion->id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            }

            $this->newLine();
            $this->info("Processing complete!");
            $this->table(
                ['Metric', 'Count'],
                [
                    ['Processed', $processed],
                    ['Successful', $successful],
                    ['Failed', $failed],
                ]
            );

            return self::SUCCESS;

        } catch (\Exception $e) {
            $this->error("Fatal error: {$e->getMessage()}");
            Log::error('Fatal error in scheduled promotions command', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return self::FAILURE;
        }
    }

    /**
     * Get promotions that are scheduled and ready to send
     */
    private function getScheduledPromotions(int $limit): \Illuminate\Database\Eloquent\Collection
    {
        return Promotion::readyToSend()
            ->with(['createdBy'])
            ->orderBy('scheduled_at')
            ->limit($limit)
            ->get();
    }

    /**
     * Show what would be sent in dry run mode
     */
    private function showDryRunInfo(Promotion $promotion): void
    {
        $recipients = $this->getRecipientsForPromotion($promotion);
        
        $this->table(
            ['Field', 'Value'],
            [
                ['Title', $promotion->title],
                ['Type', ucfirst($promotion->type)],
                ['Priority', ucfirst($promotion->priority)],
                ['Scheduled At', $promotion->scheduled_at->format('Y-m-d H:i:s')],
                ['Recipients', $recipients->count()],
                ['Delivery Methods', implode(', ', $promotion->delivery_methods)],
                ['Created By', $promotion->createdBy->name ?? 'Unknown'],
            ]
        );

        // Show delivery breakdown
        $deliveryStats = [];
        foreach ($promotion->delivery_methods as $method) {
            if ($method === 'email') {
                $count = $recipients->whereNotNull('email')->where('email', '!=', '')->count();
                $deliveryStats[] = ['Email', $count];
            } elseif ($method === 'sms') {
                $count = $recipients->whereNotNull('phone')->where('phone', '!=', '')->count();
                $deliveryStats[] = ['SMS', $count];
            }
        }

        if (!empty($deliveryStats)) {
            $this->table(['Method', 'Recipients'], $deliveryStats);
        }
    }

    /**
     * Send a promotion
     */
    private function sendPromotion(Promotion $promotion): array
    {
        DB::beginTransaction();
        
        try {
            $recipients = $this->getRecipientsForPromotion($promotion);
            $sentCount = 0;
            $failedCount = 0;
            
            $progressBar = $this->output->createProgressBar($recipients->count() * count($promotion->delivery_methods));
            $progressBar->start();

            foreach ($recipients as $employee) {
                foreach ($promotion->delivery_methods as $method) {
                    try {
                        // Create delivery record
                        $delivery = PromotionDelivery::create([
                            'promotion_id' => $promotion->id,
                            'employee_id' => $employee->id,
                            'method' => $method,
                            'status' => 'pending'
                        ]);

                        // Send notification
                        $success = $this->sendNotification($promotion, $employee, $method);
                        
                        if ($success) {
                            $delivery->markAsSent();
                            $sentCount++;
                        } else {
                            $delivery->markAsFailed('Unknown error during sending');
                            $failedCount++;
                        }
                        
                    } catch (\Exception $e) {
                        $failedCount++;
                        
                        if (isset($delivery)) {
                            $delivery->markAsFailed($e->getMessage());
                        }
                        
                        Log::warning('Failed to send notification', [
                            'promotion_id' => $promotion->id,
                            'employee_id' => $employee->id,
                            'method' => $method,
                            'error' => $e->getMessage()
                        ]);
                    }
                    
                    $progressBar->advance();
                }
            }

            $progressBar->finish();
            $this->newLine();

            // Update promotion status
            $promotion->update([
                'status' => 'sent',
                'sent_at' => now(),
                'actual_recipients' => $sentCount,
            ]);

            DB::commit();
            
            Log::info('Scheduled promotion sent successfully', [
                'promotion_id' => $promotion->id,
                'title' => $promotion->title,
                'sent_count' => $sentCount,
                'failed_count' => $failedCount,
            ]);

            return [
                'success' => true,
                'sent_count' => $sentCount,
                'failed_count' => $failedCount,
            ];

        } catch (\Exception $e) {
            DB::rollback();
            
            Log::error('Error sending scheduled promotion', [
                'promotion_id' => $promotion->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get recipients for a promotion
     */
    private function getRecipientsForPromotion(Promotion $promotion): \Illuminate\Database\Eloquent\Collection
    {
        switch ($promotion->recipient_type) {
            case 'selected_employees':
                return Employee::whereIn('id', $promotion->selected_employees)
                    ->active()
                    ->get();
                    
            case 'departments':
                return Employee::whereIn('department_id', $promotion->selected_departments)
                    ->active()
                    ->get();
                    
            default:
                return Employee::active()->get();
        }
    }

    /**
     * Send notification to employee
     */
    private function sendNotification(Promotion $promotion, Employee $employee, string $method): bool
    {
        try {
            switch ($method) {
                case 'email':
                    if (!$employee->hasValidEmail()) {
                        throw new \Exception('Employee has no valid email address');
                    }
                    break;
                    
                case 'sms':
                    if (!$employee->hasValidPhone()) {
                        throw new \Exception('Employee has no valid phone number');
                    }
                    break;
                    
                default:
                    throw new \Exception("Unsupported delivery method: {$method}");
            }

            Notification::send($employee, new PromotionNotification($promotion, $method));
            
            return true;
            
        } catch (\Exception $e) {
            Log::error("Failed to send {$method} notification", [
                'promotion_id' => $promotion->id,
                'employee_id' => $employee->id,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }
}

// Add this to your App\Console\Kernel.php schedule method:
/*
protected function schedule(Schedule $schedule)
{
    // Run every 15 minutes to check for scheduled promotions
    $schedule->command('promotions:send-scheduled')
             ->everyFifteenMinutes()
             ->withoutOverlapping()
             ->runInBackground();
    
    // Run with dry-run daily at 8 AM for monitoring
    $schedule->command('promotions:send-scheduled --dry-run')
             ->dailyAt('08:00')
             ->runInBackground();
}
*/