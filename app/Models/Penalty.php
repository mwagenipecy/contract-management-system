<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penalty extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'contract_id',
        'amount',
        'currency',
        'type',
        'reason',
        'applied_date',
        'days_overdue',
        'status',
        'paid_date',
        'paid_amount',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'applied_date' => 'date',
        'paid_date' => 'date',
        'amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];

    // Relationships
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeWaived($query)
    {
        return $query->where('status', 'waived');
    }

    public function scopeUnpaid($query)
    {
        return $query->where('status', 'pending');
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $colors = [
            'pending' => 'red',
            'paid' => 'green',
            'waived' => 'gray',
        ];

        return [
            'text' => ucfirst($this->status),
            'color' => $colors[$this->status] ?? 'gray',
        ];
    }

    public function getFormattedAmountAttribute()
    {
        return $this->currency . ' ' . number_format($this->amount, 2);
    }

    // Methods
    public function isPaid()
    {
        return $this->status === 'paid';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isWaived()
    {
        return $this->status === 'waived';
    }

    public function markAsPaid($amount = null, $notes = null)
    {
        $this->update([
            'status' => 'paid',
            'paid_date' => now(),
            'paid_amount' => $amount ?? $this->amount,
            'notes' => $notes,
        ]);
    }

    public function waive($notes = null)
    {
        $this->update([
            'status' => 'waived',
            'notes' => $notes ?? 'Penalty waived',
        ]);
    }
}