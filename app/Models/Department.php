<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'manager_id',
        'budget',
        'status'
    ];

    protected $casts = [
        'budget' => 'decimal:2'
    ];

    /**
     * Get the employees for the department
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    /**
     * Get active employees for the department
     */
    public function activeEmployees(): HasMany
    {
        return $this->hasMany(Employee::class)->where('status', 'active');
    }

    /**
     * Get the contracts through employees
     */
    public function contracts()
    {
        return $this->hasManyThrough(Contract::class, Employee::class);
    }

    /**
     * Get the reminders through employees
     */
    public function reminders()
    {
        return $this->hasManyThrough(ReminderItem::class, Employee::class);
    }

    /**
     * Get the manager of the department
     */
    public function manager()
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    /**
     * Get the penalties through employees
     */
    public function penalties()
    {
        return $this->hasManyThrough(Penalty::class, Employee::class);
    }

    /**
     * Scope to get active departments
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Get employees count attribute
     */
    public function getEmployeesCountAttribute(): int
    {
        return $this->employees()->count();
    }

    /**
     * Get active employees count attribute
     */
    public function getActiveEmployeesCountAttribute(): int
    {
        return $this->activeEmployees()->count();
    }

    /**
     * Get contracts count attribute
     */
    public function getContractsCountAttribute(): int
    {
        return $this->contracts()->count();
    }

    /**
     * Get reminders count attribute
     */
    public function getRemindersCountAttribute(): int
    {
        return $this->reminders()->count();
    }
}