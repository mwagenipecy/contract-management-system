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
    public function getFullNameAttribute()
    {
        return $this->name;
    }

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
}