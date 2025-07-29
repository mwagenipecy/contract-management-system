<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class EmailOtp extends Model
{
    protected $fillable = [
        'user_id',
        'email',
        'otp_hash',
        'expires_at',
        'is_used',
        'attempts',
        'ip_address'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_used' => 'boolean'
    ];

    protected $hidden = ['otp_hash'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isExpired(): bool
    {
        return $this->expires_at < Carbon::now();
    }

    public function isValid(): bool
    {
        return !$this->is_used && !$this->isExpired() && $this->attempts < 3;
    }

    public static function generateForUser(User $user, string $ipAddress = null): array
    {
        // Delete existing OTPs for this user
        static::where('user_id', $user->id)->delete();

        // Generate 6-digit OTP
        $otpCode = sprintf('%06d', random_int(100000, 999999));

        // Create OTP record
        $otp = static::create([
            'user_id' => $user->id,
            'email' => $user->email,
            'otp_hash' => Hash::make($otpCode),
            'expires_at' => Carbon::now()->addMinutes(10),
            'ip_address' => $ipAddress
        ]);

        return [$otp, $otpCode]; // Return both model and plain code
    }

    public function verify(string $code): bool
    {
        if (!$this->isValid()) {
            return false;
        }

        $this->increment('attempts');

        if (Hash::check($code, $this->otp_hash)) {
            $this->update(['is_used' => true]);
            return true;
        }

        return false;
    }
}