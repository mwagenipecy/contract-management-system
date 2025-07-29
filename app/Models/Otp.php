<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Otp extends Model
{
    protected $fillable = ['email', 'otp', 'expires_at', 'is_used'];
    
    protected $casts = [
        'expires_at' => 'datetime',
        'is_used' => 'boolean'
    ];

    public function isExpired()
    {
        return $this->expires_at < Carbon::now();
    }

    public function isValid()
    {
        return !$this->is_used && !$this->isExpired();
    }

    public static function generateOtp($email)
    {
        // Delete any existing OTPs for this email
        self::where('email', $email)->delete();
        
        // Generate 6-digit OTP
        $otpCode = sprintf('%06d', random_int(100000, 999999));
        
        return self::create([
            'email' => $email,
            'otp' => $otpCode,
            'expires_at' => Carbon::now()->addMinutes(10), // 10 minutes expiry
        ]);
    }

    public static function verifyOtp($email, $otpCode)
    {
        $otp = self::where('email', $email)
                  ->where('otp', $otpCode)
                  ->where('is_used', false)
                  ->first();

        if (!$otp || $otp->isExpired()) {
            return false;
        }

        $otp->update(['is_used' => true]);
        return true;
    }
}
