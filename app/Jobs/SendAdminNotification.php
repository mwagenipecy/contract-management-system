<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class SendAdminNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $admin;
    protected $notificationType;
    protected $subject;
    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct(User $admin, $notificationType, $subject, $data = [])
    {
        $this->admin = $admin;
        $this->notificationType = $notificationType;
        $this->subject = $subject;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Send Email notification to admin
            dispatch(new SendEmailNotification(
                $this->admin->email,
                $this->admin->name,
                $this->subject,
                array_merge($this->data, [
                    'admin' => $this->admin,
                    'notification_type' => $this->notificationType,
                ])
            ));

            Log::info("Admin notification sent successfully", [
                'admin_id' => $this->admin->id,
                'type' => $this->notificationType
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to send admin notification: " . $e->getMessage(), [
                'admin_id' => $this->admin->id,
                'type' => $this->notificationType
            ]);
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("Admin notification job failed: " . $exception->getMessage(), [
            'admin_id' => $this->admin->id,
            'type' => $this->notificationType
        ]);
    }
}