<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractRenewal extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'old_end_date',
        'new_end_date',
        'old_salary',
        'new_salary',
        'renewal_date',
        'renewal_notes',
        'created_by',
    ];

    protected $casts = [
        'old_end_date' => 'date',
        'new_end_date' => 'date',
        'renewal_date' => 'date',
        'old_salary' => 'decimal:2',
        'new_salary' => 'decimal:2',
    ];

    // Relationships
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Accessors
    public function getSalaryIncreaseAttribute()
    {
        return $this->new_salary - $this->old_salary;
    }

    public function getSalaryIncreasePercentageAttribute()
    {
        if ($this->old_salary > 0) {
            return (($this->new_salary - $this->old_salary) / $this->old_salary) * 100;
        }
        return 0;
    }

    public function getExtensionDaysAttribute()
    {
        return $this->old_end_date->diffInDays($this->new_end_date);
    }

    public function getExtensionYearsAttribute()
    {
        return round($this->extension_days / 365, 1);
    }

    // Methods
    public function hasSalaryIncrease()
    {
        return $this->new_salary > $this->old_salary;
    }

    public function hasSalaryDecrease()
    {
        return $this->new_salary < $this->old_salary;
    }

    public function isSignificantIncrease($threshold = 10)
    {
        return $this->salary_increase_percentage >= $threshold;
    }
}