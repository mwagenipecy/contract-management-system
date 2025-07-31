<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use App\Models\Promotion;
use App\Models\Employee;

class PromotionMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $promotion;
    public $employee;

    public function __construct(Promotion $promotion, Employee $employee)
    {
        $this->promotion = $promotion;
        $this->employee = $employee;
    }

    public function envelope(): Envelope
    {
        $priority = match($this->promotion->priority) {
            'urgent' => 'high',
            'high' => 'high',
            'medium' => 'normal',
            'low' => 'low',
            default => 'normal'
        };

        return new Envelope(
             $this->promotion->title,
           $priority,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.promotion',
            with: [
                'promotion' => $this->promotion,
                'employee' => $this->employee,
                'unsubscribeUrl' => route('promotions.unsubscribe', [
                    'employee' => $this->employee->id,
                    'token' => encrypt($this->employee->email)
                ]),
            ],
        );
    }

    public function attachments(): array
    {
        $attachments = [];
        
        if ($this->promotion->attachments) {
            foreach ($this->promotion->attachments as $attachment) {
                $attachments[] = Attachment::fromStorage($attachment['path'])
                    ->as($attachment['name'])
                    ->withMime($attachment['mime_type']);
            }
        }
        
        return $attachments;
    }
}