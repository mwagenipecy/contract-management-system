<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\Employee;

class SendEmployeeNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $employee;
    protected $notificationType;
    protected $subject;
    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct(Employee $employee, $notificationType, $subject, $data = [])
    {
        $this->employee = $employee;
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
            // Send SMS notification
            if ($this->employee->phone) {
                $smsMessage = $this->getSmsMessage();
                dispatch(new SendSmsNotification($this->employee->phone, $smsMessage));
            }

            // Send Email notification
            if ($this->employee->email) {
                dispatch(new SendEmailNotification(
                    $this->employee->email,
                    $this->employee->name,
                    $this->subject,
                    array_merge($this->data, [
                        'employee' => $this->employee,
                        'notification_type' => $this->notificationType,
                    ])
                ));
            }

            Log::info("Employee notification sent successfully", [
                'employee_id' => $this->employee->id,
                'type' => $this->notificationType
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to send employee notification: " . $e->getMessage(), [
                'employee_id' => $this->employee->id,
                'type' => $this->notificationType
            ]);
            throw $e;
        }
    }

    /**
     * Get SMS message based on notification type
     */
    private function getSmsMessage(): string
    {
        switch ($this->notificationType) {
            case 'contract_created':
                $contract = $this->data['contract'];
                return "Hi {$this->employee->name}, your new contract #{$contract->contract_number} has been created. Start date: {$contract->start_date}. Check your email for details.";

            case 'contract_renewal_reminder':
                $contract = $this->data['contract'];
                $days = $this->data['days_until_expiry'];
                return "Hi {$this->employee->name}, your contract #{$contract->contract_number} expires in {$days} days on {$contract->end_date}. Please contact HR for renewal.";

            case 'contract_expired':
                $contract = $this->data['contract'];
                return "Hi {$this->employee->name}, your contract #{$contract->contract_number} has expired. Please contact HR immediately.";

            case 'salary_updated':
                return "Hi {$this->employee->name}, your salary has been updated. Check your email for details.";

            case 'performance_review':
                return "Hi {$this->employee->name}, your performance review is scheduled. Check your email for details.";

            case 'leave_approved':
                return "Hi {$this->employee->name}, your leave request has been approved. Check your email for details.";

            case 'leave_rejected':
                return "Hi {$this->employee->name}, your leave request has been rejected. Check your email for details.";

            case 'birthday_reminder':
                return "Happy Birthday, {$this->employee->name}! 🎉 Wishing you a wonderful day from all of us!";

            case 'work_anniversary':
                $years = $this->data['years'] ?? 1;
                return "Congratulations {$this->employee->name}! Today marks {$years} year(s) with us. Thank you for your dedication!";

            case 'policy_update':
                return "Hi {$this->employee->name}, important company policy updates have been published. Please check your email for details.";

            case 'meeting_reminder':
                $meeting = $this->data['meeting'] ?? 'scheduled meeting';
                return "Hi {$this->employee->name}, reminder: You have a {$meeting} coming up. Check your email for details.";

            default:
                return "Hi {$this->employee->name}, you have a new notification from HR. Please check your email for details.";
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("Employee notification job failed: " . $exception->getMessage(), [
            'employee_id' => $this->employee->id,
            'type' => $this->notificationType
        ]);
    }
}