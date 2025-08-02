<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\EmployeeWelcomeMail;

class SendEmailNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $name;
    protected $subject;
    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct($email, $name, $subject, $data = [])
    {
        $this->email = $email;
        $this->name = $name;
        $this->subject = $subject;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Mail::to($this->email)->send(
                new EmployeeWelcomeMail($this->name, $this->subject, $this->data)
            );

            Log::info("Welcome email sent successfully to {$this->email}");

        } catch (\Exception $e) {
            Log::error("Failed to send email to {$this->email}: " . $e->getMessage());
            
            // Optionally retry or handle the failure
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("Email notification job failed: " . $exception->getMessage());
    }
}