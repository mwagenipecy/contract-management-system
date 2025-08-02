<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmployeeWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $employeeName;
    protected $emailSubject;
    protected $emailData;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $subject, $data = [])
    {
        $this->employeeName = $name;
        $this->emailSubject = $subject;
        $this->emailData = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->emailSubject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.employee-welcome',
            with: [
                'name' => $this->employeeName,
                'employee' => $this->emailData['employee'] ?? null,
                'welcome_message' => $this->emailData['welcome_message'] ?? '',
                'start_date' => $this->emailData['start_date'] ?? null,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}