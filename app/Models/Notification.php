<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'contract_id',
        'type',
        'title',
        'message',
        'channels',
        'priority',
        'status',
        'scheduled_at',
        'sent_at',
        'read_at',
        'delivery_status',
        'failure_reason',
    ];

    protected $casts = [
        'channels' => 'array',
        'delivery_status' => 'array',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
        'read_at' => 'datetime',
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

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    public function scopeRead($query)
    {
        return $query->where('status', 'read');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeUnread($query)
    {
        return $query->where('status', 'sent');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeHighPriority($query)
    {
        return $query->where('priority', 'high');
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $colors = [
            'pending' => 'yellow',
            'sent' => 'gray',
            'read' => 'green',
            'failed' => 'red',
        ];

        return [
            'text' => ucfirst($this->status),
            'color' => $colors[$this->status] ?? 'gray',
        ];
    }

    public function getPriorityBadgeAttribute()
    {
        $colors = [
            'low' => 'green',
            'medium' => 'yellow',
            'high' => 'red',
        ];

        return [
            'text' => ucfirst($this->priority),
            'color' => $colors[$this->priority] ?? 'gray',
        ];
    }

    // Methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isSent()
    {
        return $this->status === 'sent';
    }

    public function isRead()
    {
        return $this->status === 'read';
    }

    public function isFailed()
    {
        return $this->status === 'failed';
    }

    public function markAsSent()
    {
        $this->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);
    }

    public function markAsRead()
    {
        $this->update([
            'status' => 'read',
            'read_at' => now(),
        ]);
    }

    public function markAsFailed($reason = null)
    {
        $this->update([
            'status' => 'failed',
            'failure_reason' => $reason,
        ]);
    }

    public function resend()
    {
        $this->update([
            'status' => 'pending',
            'sent_at' => null,
            'failure_reason' => null,
        ]);
    }
}