<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Promotion;
use App\Http\Integration\Beem\BeemSMSController;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Log;

class PromotionNotification extends Notification // implements ShouldQueue
{
    use Queueable;

    protected $promotion;
    protected $channel;

    /**
     * Create a new notification instance.
     */
    public function __construct(Promotion $promotion, $channel = 'email')
    {
        $this->promotion = $promotion;
        $this->channel = $channel;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        $channels = [];
        
        if ($this->channel === 'email' && $notifiable->email) {
            $channels[] = 'mail';
        }
        
        if ($this->channel === 'sms' && $notifiable->phone) {
            $channels[] = 'beem';
        }
        
        Log::info('Notification channels determined', [
            'promotion_id' => $this->promotion->id,
            'requested_channel' => $this->channel,
            'selected_channels' => $channels,
            'notifiable_id' => $notifiable->id,
            'has_email' => !empty($notifiable->email),
            'has_phone' => !empty($notifiable->phone)
        ]);
        
        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        Log::info('Preparing email notification', [
            'promotion_id' => $this->promotion->id,
            'recipient' => $notifiable->email,
            'subject' => $this->getEmailSubject()
        ]);

        try {
            $message = (new MailMessage)
                ->subject($this->getEmailSubject())
                ->greeting($this->getGreeting($notifiable))
                ->line(new HtmlString(nl2br(e($this->promotion->content))));

            // Add priority styling
            if ($this->promotion->priority === 'urgent') {
                $message->level('error');
            } elseif ($this->promotion->priority === 'high') {
                $message->level('warning');
            }

            // Add attachments if any
            if ($this->promotion->attachments) {
                foreach ($this->promotion->attachments as $attachment) {
                    $filePath = storage_path('app/public/' . $attachment['path']);
                    if (file_exists($filePath)) {
                        $message->attach($filePath, [
                            'as' => $attachment['name'],
                            'mime' => $attachment['mime_type'] ?? 'application/octet-stream',
                        ]);
                        Log::info('Email attachment added', ['file' => $attachment['name']]);
                    } else {
                        Log::warning('Email attachment file not found', ['path' => $filePath]);
                    }
                }
            }

            // Add action button if needed
            if ($this->promotion->type === 'promotion') {
                $message->action('View Details', url('/promotions/' . $this->promotion->id));
            }

            $message->line('Thank you for your attention!')
                    ->salutation('Best regards, ' . config('app.name') . ' Team');

            Log::info('Email notification prepared successfully');
            return $message;

        } catch (\Exception $e) {
            Log::error('Error preparing email notification', [
                'error' => $e->getMessage(),
                'promotion_id' => $this->promotion->id,
                'recipient' => $notifiable->email
            ]);
            throw $e;
        }
    }

    /**
     * Get the Beem SMS representation of the notification.
     */
    public function toBeem($notifiable)
    {
        $message = $this->getSMSContent();
        $phone = $notifiable->phone;
        $client_id = $notifiable->id ?? uniqid();

        Log::info('Preparing Beem SMS notification', [
            'promotion_id' => $this->promotion->id,
            'recipient' => $phone,
            'client_id' => $client_id,
            'message_length' => strlen($message)
        ]);

        try {
            // Send SMS using BeemSMSController
            $result = BeemSMSController::send($phone, $message, $client_id, $this->promotion->id);
            
            if ($result['success']) {
                Log::info('Beem SMS sent successfully', [
                    'promotion_id' => $this->promotion->id,
                    'recipient' => $phone,
                    'result' => $result
                ]);
            } else {
                Log::error('Beem SMS failed', [
                    'promotion_id' => $this->promotion->id,
                    'recipient' => $phone,
                    'error' => $result['error'] ?? 'Unknown error',
                    'result' => $result
                ]);
                
                // Throw an exception to mark the notification as failed
                throw new \Exception('SMS sending failed: ' . ($result['error'] ?? 'Unknown error'));
            }
            
            return $result;
            
        } catch (\Exception $e) {
            Log::error('Exception in Beem SMS notification', [
                'promotion_id' => $this->promotion->id,
                'recipient' => $phone,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Re-throw the exception to mark the notification as failed
            throw $e;
        }
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return [
            'promotion_id' => $this->promotion->id,
            'title' => $this->promotion->title,
            'type' => $this->promotion->type,
            'priority' => $this->promotion->priority,
            'content' => $this->promotion->content,
            'sent_at' => now(),
        ];
    }

    /**
     * Get email subject based on promotion type and priority
     */
    protected function getEmailSubject(): string
    {
        $prefix = '';
        
        switch ($this->promotion->priority) {
            case 'urgent':
                $prefix = '[URGENT] ';
                break;
            case 'high':
                $prefix = '[HIGH PRIORITY] ';
                break;
        }

        $typePrefix = '';
        switch ($this->promotion->type) {
            case 'alert':
                $typePrefix = '🚨 Alert: ';
                break;
            case 'celebration':
                $typePrefix = '🎉 ';
                break;
            case 'promotion':
                $typePrefix = '📢 ';
                break;
            case 'update':
                $typePrefix = '📋 Update: ';
                break;
            default:
                $typePrefix = '📰 ';
                break;
        }

        return $prefix . $typePrefix . $this->promotion->title;
    }

    /**
     * Get personalized greeting
     */
    protected function getGreeting($notifiable): string
    {
        $greeting = 'Hello' . ($notifiable->name ? ' ' . $notifiable->name : '') . '!';
        
        switch ($this->promotion->type) {
            case 'celebration':
                return '🎉 ' . $greeting;
            case 'alert':
                return '🚨 ' . $greeting;
            case 'promotion':
                return '📢 ' . $greeting;
            default:
                return $greeting;
        }
    }

    /**
     * Get SMS content (truncated for SMS limits)
     */
    protected function getSMSContent(): string
    {
        $prefix = '';
        
        if ($this->promotion->priority === 'urgent') {
            $prefix = '[URGENT] ';
        }

        $content = $prefix . $this->promotion->title . ': ';
        $appName = ' - ' . config('app.name');
        $remainingLength = 160 - strlen($content) - strlen($appName);
        
        $body = strip_tags($this->promotion->content);
        if (strlen($body) > $remainingLength) {
            $body = substr($body, 0, $remainingLength - 3) . '...';
        }
        
        return $content . $body . $appName;
    }

    /**
     * Determine if notification should be queued
     */
    public function shouldQueue($notifiable): bool
    {
        return false; // Disable queueing for now to debug issues
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception)
    {
        Log::error('Promotion notification job failed', [
            'promotion_id' => $this->promotion->id,
            'channel' => $this->channel,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]);
    }
}