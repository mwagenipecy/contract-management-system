<?php


namespace App\Services;

use App\Models\Otp;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use Exception;

class OtpService
{
    public function sendOtp($email, $userName = null)
    {
        try {
            $otp = Otp::generateOtp($email);
            
            Mail::to($email)->send(new OtpMail($otp->otp, $userName));
            
            return [
                'success' => true,
                'message' => 'OTP sent successfully',
                'expires_at' => $otp->expires_at
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to send OTP: ' . $e->getMessage()
            ];
        }
    }

    public function verifyOtp($email, $otpCode)
    {
        if (Otp::verifyOtp($email, $otpCode)) {
            return [
                'success' => true,
                'message' => 'OTP verified successfully'
            ];
        }

        return [
            'success' => false,
            'message' => 'Invalid or expired OTP'
        ];
    }
}

