<?php

// 1. Create the Beem SMS Channel: app/Channels/BeemSmsChannel.php
namespace App\Broadcasting;

use Illuminate\Notifications\Notification;
use App\Http\Integration\Beem\BeemSMSController;
use Illuminate\Support\Facades\Log;

class BeemSmsChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return mixed
     */
    public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notification, 'toBeem')) {
            Log::error('Notification does not have toBeem method', [
                'notification' => get_class($notification)
            ]);
            return false;
        }

        try {
            // Get the SMS content from the notification
            $smsData = $notification->toBeem($notifiable);
            
            Log::info('Processing Beem SMS via channel', [
                'recipient' => $notifiable->phone,
                'notifiable_id' => $notifiable->id,
                'sms_data' => $smsData
            ]);

            // The toBeem method in your notification already handles the sending
            // So we just need to return the result
            return $smsData;
            
        } catch (\Exception $e) {
            Log::error('Error in Beem SMS channel', [
                'error' => $e->getMessage(),
                'recipient' => $notifiable->phone ?? 'unknown',
                'trace' => $e->getTraceAsString()
            ]);
            
            throw $e;
        }
    }
}