<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;


 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }



    public function emailOtps()
    {
        return $this->hasMany(EmailOtp::class);
    }

    public function hasEnabledTwoFactorEmail(): bool
    {
        return $this->two_factor_email_enabled;
    }

    public function enableTwoFactorEmail(): void
    {
        $this->forceFill([
            'two_factor_email_enabled' => true,
            'two_factor_email_enabled_at' => now(),
        ])->save();
    }

    public function disableTwoFactorEmail(): void
    {
        $this->forceFill([
            'two_factor_email_enabled' => false,
            'two_factor_email_enabled_at' => null,
        ])->save();

        // Clean up any existing OTPs
        $this->emailOtps()->delete();
    }

    public function requiresTwoFactorEmail(): bool
    {
        return $this->hasEnabledTwoFactorEmail();
    }



    public function createdContracts()
    {
        return $this->hasMany(Contract::class, 'created_by');
    }

    public function approvedContracts()
    {
        return $this->hasMany(Contract::class, 'approved_by');
    }

    public function createdPenalties()
    {
        return $this->hasMany(Penalty::class, 'created_by');
    }

    


}
