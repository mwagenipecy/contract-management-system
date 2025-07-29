<?php


namespace App\Services;

use App\Models\User;
use App\Models\EmailOtp;
use App\Mail\TwoFactorEmailOtp;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class TwoFactorEmailService
{
    public function sendOtp(User $user, string $ipAddress = null): array
    {
        try {
            // Rate limiting
            $cacheKey = "2fa_email_send_{$user->id}";
            $attempts = Cache::get($cacheKey, 0);
            
            if ($attempts >= 3) {
                return [
                    'success' => false,
                    'message' => 'Too many OTP requests. Please try again in 15 minutes.'
                ];
            }

            [$otp, $otpCode] = EmailOtp::generateForUser($user, $ipAddress);

            // Send email
            Mail::to($user->email)->send(new TwoFactorEmailOtp($user, $otpCode, $ipAddress));

            // Increment attempts
            Cache::put($cacheKey, $attempts + 1, now()->addMinutes(15));

            Log::info('2FA Email OTP sent', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip_address' => $ipAddress
            ]);

            return [
                'success' => true,
                'message' => 'Verification code sent to your email',
                'expires_at' => $otp->expires_at
            ];

        } catch (\Exception $e) {
            Log::error('Failed to send 2FA Email OTP', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to send verification code'
            ];
        }
    }

    public function verifyOtp(User $user, string $code): bool
    {
        $otp = $user->emailOtps()
                   ->where('is_used', false)
                   ->where('expires_at', '>', now())
                   ->first();

        if (!$otp) {
            return false;
        }

        return $otp->verify($code);
    }
}

