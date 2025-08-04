<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use App\Models\User;

class UserAccountCreated extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $password;
    public $loginUrl;
    public $passwordResetUrl;
    
    // Queue configuration - these properties are inherited from Queueable trait
    public $tries = 3;
    public $timeout = 120;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, string $password)
    {
        $this->user = $user;
        $this->password = $password;
        $this->loginUrl = route('login');
        
        // Set the queue name using the onQueue method
        $this->onQueue('emails');
        
        // Generate a secure password reset URL that expires in 24 hours
        $this->passwordResetUrl = URL::temporarySignedRoute(
            'password.reset.form',
            now()->addHours(24),
            ['token' => app('auth.password')->createToken($user)]
        );
        
        // Set queue delay if configured
        if (config('mail.queue.delay')) {
            $this->delay(now()->addSeconds(config('mail.queue.delay')));
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $fromAddress = config('mail.from.address') ?? config('mail.default_from');
        $fromName = config('mail.from.name') ?? config('app.name');
        $replyToAddress = config('mail.reply_to.address') ?? $fromAddress;
        $replyToName = config('mail.reply_to.name') ?? $fromName;

        return new Envelope(
            subject: __('Welcome to :app - Your Account Details', ['app' => config('app.name')]),
            from: new Address($fromAddress, $fromName),
            replyTo: [new Address($replyToAddress, $replyToName)],
            tags: ['user-registration', 'account-created'],
            metadata: [
                'user_id' => $this->user->id,
                'user_email' => $this->user->email,
                'created_at' => now()->toISOString(),
            ]
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            html: 'emails.user-account-created',
            text: 'emails.user-account-created-text',
            with: [
                'user' => $this->user,
                'password' => $this->password,
                'loginUrl' => $this->loginUrl,
                'passwordResetUrl' => $this->passwordResetUrl,
                'appName' => config('app.name'),
                'appUrl' => config('app.url'),
                'supportEmail' => config('mail.support.address') ?? config('mail.from.address'),
                'supportPhone' => config('mail.support.phone'),
                'companyAddress' => config('mail.company.address'),
                'privacyPolicyUrl' => route('privacy-policy'),
                'termsOfServiceUrl' => route('terms-of-service'),
                'unsubscribeUrl' => route('unsubscribe', ['token' => $this->generateUnsubscribeToken()]),
                'logoUrl' => asset('images/logo-email.png'),
                'socialLinks' => [
                    'facebook' => config('social.facebook_url'),
                    'twitter' => config('social.twitter_url'),
                    'linkedin' => config('social.linkedin_url'),
                ],
                'emailPreferencesUrl' => route('email-preferences', ['user' => $this->user->id]),
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
        $attachments = [];
        
        // Add welcome guide if configured
        if (config('mail.attachments.welcome_guide') && file_exists(storage_path('app/public/welcome-guide.pdf'))) {
            $attachments[] = \Illuminate\Mail\Mailables\Attachment::fromStorage('public/welcome-guide.pdf')
                ->as('Welcome Guide.pdf')
                ->withMime('application/pdf');
        }
        
        return $attachments;
    }

    /**
     * Generate unsubscribe token for the user
     */
    private function generateUnsubscribeToken(): string
    {
        return hash_hmac('sha256', $this->user->email . $this->user->id, config('app.key'));
    }

    /**
     * Configure the message before sending
     */
    public function build()
    {
        // Set priority if configured
        if (config('mail.priority.user_registration')) {
            $this->priority(config('mail.priority.user_registration'));
        }

        // Add custom headers if configured
        if ($customHeaders = config('mail.custom_headers')) {
            foreach ($customHeaders as $header => $value) {
                $this->withSwiftMessage(function ($message) use ($header, $value) {
                    $message->getHeaders()->addTextHeader($header, $value);
                });
            }
        }

        return $this;
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        // Log the failure
        \Log::error('Failed to send user account creation email', [
            'user_id' => $this->user->id,
            'user_email' => $this->user->email,
            'exception' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);

        // Optionally notify administrators
        if (config('mail.notify_admin_on_failure')) {
            // You could dispatch another job or send a notification here
        }
    }
}