<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Contract extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'contract_number',
        'contract_type',
        'start_date',
        'end_date',
        'salary',
        'currency',
        'status',
        'terms_and_conditions',
        'renewal_notice_period',
        'auto_renewal',
        'created_by',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'approved_at' => 'datetime',
        'auto_renewal' => 'boolean',
        'salary' => 'decimal:2',
    ];

    // Relationships
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function penalties()
    {
        return $this->hasMany(Penalty::class);
    }

    public function renewals()
    {
        return $this->hasMany(ContractRenewal::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeExpiring($query, $days = 30)
    {
        return $query->where('status', 'active')
                    ->where('end_date', '<=', Carbon::now()->addDays($days))
                    ->where('end_date', '>=', Carbon::now());
    }

    public function scopeExpired($query)
    {
        return $query->where('end_date', '<', Carbon::now())
                    ->whereIn('status', ['active', 'expired']);
    }

    public function scopePendingRenewal($query)
    {
        return $query->where('status', 'pending_renewal');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('contract_type', $type);
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $colors = [
            'active' => 'green',
            'expired' => 'red',
            'pending_renewal' => 'yellow',
            'terminated' => 'gray',
            'draft' => 'blue',
        ];

        return [
            'text' => ucfirst(str_replace('_', ' ', $this->status)),
            'color' => $colors[$this->status] ?? 'gray',
        ];
    }

    public function getDaysUntilExpiryAttribute()
    {
        return Carbon::now()->diffInDays($this->end_date, false);
    }

    public function getFormattedSalaryAttribute()
    {
        return $this->currency . ' ' . number_format($this->salary, 2);
    }

    public function getDurationAttribute()
    {
        return $this->start_date->diffInDays($this->end_date);
    }

    public function getDurationInYearsAttribute()
    {
        return round($this->duration / 365, 1);
    }

    // Methods
    public function isExpired()
    {
        return $this->end_date < Carbon::now();
    }

    public function isExpiringSoon($days = 30)
    {
        return $this->end_date <= Carbon::now()->addDays($days) && 
               $this->end_date >= Carbon::now();
    }

    public function canBeRenewed()
    {
        return in_array($this->status, ['active', 'expired']);
    }

    public function getDaysOverdue()
    {
        if (!$this->isExpired()) {
            return 0;
        }

        return Carbon::now()->diffInDays($this->end_date);
    }

    public function calculatePenalty($penaltyRate = 50, $type = 'daily')
    {
        if (!$this->isExpired()) {
            return 0;
        }

        $daysOverdue = $this->getDaysOverdue();
        
        if ($type === 'daily') {
            return $daysOverdue * $penaltyRate;
        } elseif ($type === 'fixed') {
            return $penaltyRate;
        }

        return 0;
    }

    public function renew($newEndDate, $newSalary = null, $terms = null)
    {
        // Create renewal record
        $renewal = $this->renewals()->create([
            'old_end_date' => $this->end_date,
            'new_end_date' => $newEndDate,
            'old_salary' => $this->salary,
            'new_salary' => $newSalary ?? $this->salary,
            'renewal_date' => Carbon::now(),
            'created_by' => auth()->id(),
        ]);

        // Update contract
        $this->update([
            'end_date' => $newEndDate,
            'salary' => $newSalary ?? $this->salary,
            'status' => 'active',
            'terms_and_conditions' => $terms ?? $this->terms_and_conditions,
        ]);

        return $renewal;
    }

    public function terminate($reason = null, $terminationDate = null)
    {
        $this->update([
            'status' => 'terminated',
            'termination_reason' => $reason,
            'termination_date' => $terminationDate ?? Carbon::now(),
        ]);
    }
}