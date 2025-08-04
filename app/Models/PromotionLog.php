<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PromotionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'promotion_id',
        'type',
        'recipient',
        'message',
        'status',
        'error_message',
        'response_data',
        'sent_at',
        'delivered_at',
        'read_at'
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'delivered_at' => 'datetime',
        'read_at' => 'datetime',
        'response_data' => 'array'
    ];

    /**
     * Get the promotion that owns the log
     */
    public function promotion(): BelongsTo
    {
        return $this->belongsTo(Promotion::class);
    }

    /**
     * Get the employee associated with this log (by phone/email)
     */
    public function employee()
    {
        if ($this->type === 'sms') {
            return $this->belongsTo(Employee::class, 'recipient', 'phone');
        } elseif ($this->type === 'email') {
            return $this->belongsTo(Employee::class, 'recipient', 'email');
        }
        return null;
    }

    /**
     * Scope to get successful logs
     */
    public function scopeSuccessful($query)
    {
        return $query->where('status', 'sent');
    }

    /**
     * Scope to get failed logs
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Scope to get logs by type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope to get SMS logs
     */
    public function scopeSms($query)
    {
        return $query->where('type', 'sms');
    }

    /**
     * Scope to get email logs
     */
    public function scopeEmail($query)
    {
        return $query->where('type', 'email');
    }

    /**
     * Scope to get logs within date range
     */
    public function scopeWithinDays($query, $days)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Check if message was delivered
     */
    public function getIsDeliveredAttribute(): bool
    {
        return !is_null($this->delivered_at);
    }

    /**
     * Check if message was read
     */
    public function getIsReadAttribute(): bool
    {
        return !is_null($this->read_at);
    }

    /**
     * Get delivery time in seconds
     */
    public function getDeliveryTimeAttribute(): ?int
    {
        if ($this->sent_at && $this->delivered_at) {
            return $this->sent_at->diffInSeconds($this->delivered_at);
        }
        return null;
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status) {
            'sent' => 'green',
            'delivered' => 'blue',
            'read' => 'purple',
            'failed' => 'red',
            'pending' => 'yellow',
            default => 'gray'
        };
    }

    /**
     * Get formatted recipient
     */
    public function getFormattedRecipientAttribute(): string
    {
        if ($this->type === 'sms') {
            // Format phone number for display
            return $this->formatPhoneNumber($this->recipient);
        }
        return $this->recipient;
    }

    /**
     * Format phone number for display
     */
    private function formatPhoneNumber($phone): string
    {
        if (preg_match('/^255(\d{9})$/', $phone, $matches)) {
            return '+255 ' . substr($matches[1], 0, 3) . ' ' . substr($matches[1], 3, 3) . ' ' . substr($matches[1], 6);
        }
        return $phone;
    }

    /**
     * Get short error message
     */
    public function getShortErrorMessageAttribute(): string
    {
        if (!$this->error_message) {
            return '';
        }
        return strlen($this->error_message) > 50 
            ? substr($this->error_message, 0, 50) . '...'
            : $this->error_message;
    }
}