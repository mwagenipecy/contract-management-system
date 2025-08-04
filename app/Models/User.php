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
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

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



    // public function emailOtps()
    // {
    //     return $this->hasMany(EmailOtp::class);
    // }

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



    // public function createdContracts()
    // {
    //     return $this->hasMany(Contract::class, 'created_by');
    // }

    public function approvedContracts()
    {
        return $this->hasMany(Contract::class, 'approved_by');
    }

    public function createdPenalties()
    {
        return $this->hasMany(Penalty::class, 'created_by');
    }




    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'status',
        'employee_id',
        'department_id',
        'position',
        'last_login_at',
        'last_login_ip',
        'created_by',
        'updated_by',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the department that owns the user
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the user who created this user
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this user
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get users created by this user
     */
    public function createdUsers()
    {
        return $this->hasMany(User::class, 'created_by');
    }

    /**
     * Get users updated by this user
     */
    public function updatedUsers()
    {
        return $this->hasMany(User::class, 'updated_by');
    }

    /**
     * Get the promotions created by this user
     */
    public function createdPromotions()
    {
        return $this->hasMany(Promotion::class, 'created_by');
    }

    /**
     * Get the reminder items created by this user
     */
    public function createdReminders()
    {
        return $this->hasMany(ReminderItem::class, 'created_by');
    }

    /**
     * Get the reminder items assigned by this user
     */
    public function assignedReminders()
    {
        return $this->hasMany(ReminderItem::class, 'assigned_by');
    }

    /**
     * Get the contracts created by this user
     */
    public function createdContracts()
    {
        return $this->hasMany(Contract::class, 'created_by');
    }

    /**
     * Get the email OTPs for this user
     */
    public function emailOtps()
    {
        return $this->hasMany(EmailOtp::class, 'email', 'email');
    }

    /**
     * Scope to filter users by role
     */
    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Scope to filter users by status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to get active users
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to get inactive users
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Scope to get suspended users
     */
    public function scopeSuspended($query)
    {
        return $query->where('status', 'suspended');
    }

    /**
     * Scope to get admins
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope to get managers
     */
    public function scopeManagers($query)
    {
        return $query->where('role', 'manager');
    }

    /**
     * Scope to get HR users
     */
    public function scopeHr($query)
    {
        return $query->where('role', 'hr');
    }

    /**
     * Scope to search users
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
              ->orWhere('email', 'like', '%' . $search . '%')
            //   ->orWhere('employee_id', 'like', '%' . $search . '%')
              ->orWhere('phone', 'like', '%' . $search . '%');
        });
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is manager
     */
    public function isManager(): bool
    {
        return $this->role === 'manager';
    }

    /**
     * Check if user is HR
     */
    public function isHr(): bool
    {
        return $this->role === 'hr';
    }

    /**
     * Check if user is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if user is inactive
     */
    public function isInactive(): bool
    {
        return $this->status === 'inactive';
    }

    /**
     * Check if user is suspended
     */
    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }

    /**
     * Get user's initials
     */
    public function getInitialsAttribute(): string
    {
        $names = explode(' ', $this->name);
        $initials = '';
        
        foreach ($names as $name) {
            if (!empty($name)) {
                $initials .= strtoupper($name[0]);
            }
        }
        
        return substr($initials, 0, 2);
    }

    /**
     * Get user's full name
     */
    public function getFullNameAttribute(): string
    {
        return $this->name;
    }

    /**
     * Get user's display name (name with role)
     */
    public function getDisplayNameAttribute(): string
    {
        $roleLabels = [
            'admin' => 'Administrator',
            'manager' => 'Manager',
            'hr' => 'HR Manager',
            'user' => 'User'
        ];
        
        $roleLabel = $roleLabels[$this->role] ?? ucfirst($this->role);
        return $this->name . ' (' . $roleLabel . ')';
    }

    /**
     * Get role badge color
     */
    public function getRoleBadgeColorAttribute(): string
    {
        return match($this->role) {
            'admin' => 'purple',
            'manager' => 'blue',
            'hr' => 'green',
            'user' => 'gray',
            default => 'gray'
        };
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status) {
            'active' => 'green',
            'inactive' => 'gray',
            'suspended' => 'red',
            default => 'gray'
        };
    }

    /**
     * Check if user can manage other users
     */
    public function canManageUsers(): bool
    {
        return in_array($this->role, ['admin', 'hr']);
    }

    /**
     * Check if user can view reports
     */
    public function canViewReports(): bool
    {
        return in_array($this->role, ['admin', 'manager', 'hr']);
    }

    /**
     * Check if user can manage departments
     */
    public function canManageDepartments(): bool
    {
        return in_array($this->role, ['admin', 'hr']);
    }

    /**
     * Check if user can send promotions
     */
    public function canSendPromotions(): bool
    {
        return in_array($this->role, ['admin', 'manager', 'hr']);
    }

    /**
     * Check if user can manage contracts
     */
    public function canManageContracts(): bool
    {
        return in_array($this->role, ['admin', 'hr']);
    }

    /**
     * Get the user's permissions based on role
     */
    public function getPermissionsAttribute(): array
    {
        $permissions = [];
        
        switch ($this->role) {
            case 'admin':
                $permissions = [
                    'manage_users',
                    'manage_departments',
                    'manage_contracts',
                    'send_promotions',
                    'view_reports',
                    'manage_reminders',
                    'system_settings'
                ];
                break;
                
            case 'hr':
                $permissions = [
                    'manage_users',
                    'manage_departments',
                    'manage_contracts',
                    'send_promotions',
                    'view_reports',
                    'manage_reminders'
                ];
                break;
                
            case 'manager':
                $permissions = [
                    'send_promotions',
                    'view_reports',
                    'manage_reminders'
                ];
                break;
                
            case 'user':
                $permissions = [
                    'view_own_data'
                ];
                break;
        }
        
        return $permissions;
    }

    /**
     * Check if user has specific permission
     */
    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->permissions);
    }

    /**
     * Get formatted last login
     */
    public function getFormattedLastLoginAttribute(): string
    {
        if (!$this->last_login_at) {
            return 'Never';
        }
        
        return $this->last_login_at->format('M d, Y \a\t g:i A');
    }

    /**
     * Update last login information
     */
    public function updateLastLogin(): void
    {
        $this->update([
            'last_login_at' => now(),
            'last_login_ip' => request()->ip()
        ]);
    }

    /**
     * Get user statistics
     */
    public static function getStats(): array
    {
        return [
            'total' => self::count(),
            'active' => self::active()->count(),
            'inactive' => self::inactive()->count(),
            'suspended' => self::suspended()->count(),
            'admins' => self::admins()->count(),
            'managers' => self::managers()->count(),
            'hr' => self::hr()->count(),
            'users' => self::role('user')->count(),
            'verified' => self::whereNotNull('email_verified_at')->count(),
            'unverified' => self::whereNull('email_verified_at')->count(),
        ];
    }


    


}
