<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'name',
        'email',
        'phone',
        'position',
        'department',
        'hire_date',
        'status',
        'address',
        'emergency_contact_name',
        'emergency_contact_phone',
    ];

    protected $casts = [
        'hire_date' => 'date',
    ];

    // Relationships
    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function activeContract()
    {
        return $this->hasOne(Contract::class)->where('status', 'active');
    }

    public function penalties()
    {
        return $this->hasMany(Penalty::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeWithActiveContract($query)
    {
        return $query->whereHas('contracts', function ($q) {
            $q->where('status', 'active');
        });
    }

    public function scopeExpiringContracts($query, $days = 30)
    {
        return $query->whereHas('contracts', function ($q) use ($days) {
            $q->where('status', 'active')
              ->where('end_date', '<=', Carbon::now()->addDays($days))
              ->where('end_date', '>=', Carbon::now());
        });
    }

    // Accessors
    // public function getFullNameAttribute()
    // {
    //     return $this->name;
    // }

    public function getStatusBadgeAttribute()
    {
        $colors = [
            'active' => 'green',
            'inactive' => 'gray',
            'terminated' => 'red',
        ];

        return [
            'text' => ucfirst($this->status),
            'color' => $colors[$this->status] ?? 'gray',
        ];
    }

    // Methods
    public function hasActiveContract()
    {
        return $this->contracts()->where('status', 'active')->exists();
    }

    public function getCurrentContract()
    {
        return $this->contracts()->where('status', 'active')->first();
    }

    public function getContractExpiryDays()
    {
        $activeContract = $this->getCurrentContract();
        if (!$activeContract) {
            return null;
        }

        return Carbon::now()->diffInDays($activeContract->end_date, false);
    }

    public function getTotalPenalties()
    {
        return $this->penalties()->where('status', 'unpaid')->sum('amount');
    }



    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function promotionDeliveries()
    {
        return $this->hasMany(PromotionDelivery::class);
    }

    // Scopes
    // public function scopeActive($query)
    // {
    //     return $query->where('is_active', true);
    // }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function scopeByDepartment($query, $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    public function scopeWithValidEmail($query)
    {
        return $query->whereNotNull('email')
                    ->where('email', '!=', '');
    }

    public function scopeWithValidPhone($query)
    {
        return $query->whereNotNull('phone')
                    ->where('phone', '!=', '');
    }

    // Accessors
    public function getFullNameAttribute(): string
    {
        return $this->name;
    }

    public function getStatusAttribute(): string
    {
        return $this->is_active ? 'Active' : 'Inactive';
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return $this->is_active ? 'green' : 'red';
    }

    public function getFormattedPhoneAttribute(): string
    {
        if (!$this->phone) {
            return '';
        }

        // Format phone number (assuming international format)
        $phone = preg_replace('/[^0-9+]/', '', $this->phone);
        
        if (strlen($phone) === 10) {
            return '(' . substr($phone, 0, 3) . ') ' . substr($phone, 3, 3) . '-' . substr($phone, 6);
        }
        
        return $this->phone;
    }

    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->name);
        $initials = '';
        
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper($word[0]);
            }
        }
        
        return substr($initials, 0, 2);
    }

    public function getYearsOfServiceAttribute(): int
    {
        if (!$this->hire_date) {
            return 0;
        }

        return $this->hire_date->diffInYears(now());
    }

    // Helper methods
    public function hasValidEmail(): bool
    {
        return !empty($this->email) && filter_var($this->email, FILTER_VALIDATE_EMAIL);
    }

    public function hasValidPhone(): bool
    {
        return !empty($this->phone) && preg_match('/^[\+]?[0-9\s\-\(\)]+$/', $this->phone);
    }

    public function canReceiveEmails(): bool
    {
        return $this->is_active && $this->hasValidEmail();
    }

    public function canReceiveSMS(): bool
    {
        return $this->is_active && $this->hasValidPhone();
    }

    public function activate(): void
    {
        $this->update(['is_active' => true]);
    }

    public function deactivate(): void
    {
        $this->update(['is_active' => false]);
    }

    public function getPromotionDeliveryStats(): array
    {
        $deliveries = $this->promotionDeliveries;
        
        return [
            'total' => $deliveries->count(),
            'sent' => $deliveries->where('status', 'sent')->count(),
            'failed' => $deliveries->where('status', 'failed')->count(),
            'pending' => $deliveries->where('status', 'pending')->count(),
        ];
    }

    public function getLastPromotionReceived()
    {
        return $this->promotionDeliveries()
                   ->with('promotion')
                   ->where('status', 'sent')
                   ->latest('sent_at')
                   ->first();
    }

    // FIXED: Notification routing methods
    /**
     * Route notifications for the mail channel.
     */
    public function routeNotificationForMail($notification = null)
    {
        return $this->email;
    }

    /**
     * Route notifications for the Nexmo SMS channel.
     */
    public function routeNotificationForNexmo($notification = null)
    {
        return $this->phone;
    }

    /**
     * Route notifications for the Twilio SMS channel.
     */
    public function routeNotificationForTwilio($notification = null)
    {
        return $this->phone;
    }

    /**
     * Route notifications for custom SMS channels.
     */
    public function routeNotificationForSms($notification = null)
    {
        return $this->phone;
    }

    /**
     * Route notifications for Beem SMS channel (Tanzania).
     */
    public function routeNotificationForBeem($notification = null)
    {
        return $this->phone;
    }

    /**
     * Route notifications for AfricasTalking SMS channel.
     */
    public function routeNotificationForAfricasTalking($notification = null)
    {
        return $this->phone;
    }

    /**
     * Generic route notification method for any channel.
     */
    public function routeNotificationFor($driver, $notification = null)
    {
        switch ($driver) {
            case 'mail':
                return $this->email;
            case 'nexmo':
            case 'twilio':
            case 'sms':
            case 'beem':
            case 'africas_talking':
                return $this->phone;
            default:
                return null;
        }
    }

    // Boot method for model events
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($employee) {
            // Auto-generate employee ID if not provided
            if (empty($employee->employee_id)) {
                $employee->employee_id = 'EMP' . str_pad(
                    (static::max('id') ?? 0) + 1, 
                    4, 
                    '0', 
                    STR_PAD_LEFT
                );
            }
        });

        static::deleting(function ($employee) {
            // Don't allow deletion if employee has promotion deliveries
            if ($employee->promotionDeliveries()->exists()) {
                throw new \Exception('Cannot delete employee with promotion delivery history');
            }
        });
    }



}