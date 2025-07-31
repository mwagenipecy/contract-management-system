<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionDelivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'promotion_id',
        'employee_id',
        'method',
        'status',
        'sent_at',
        'failure_reason',
        'metadata',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'metadata' => 'array',
    ];

    // Relationships
    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Scopes
    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByMethod($query, $method)
    {
        return $query->where('method', $method);
    }

    // Methods
    public function markAsOpened()
    {
        $metadata = $this->metadata ?? [];
        $metadata['opened_at'] = now();
        $metadata['opened'] = true;
        
        $this->update(['metadata' => $metadata]);
    }

    public function markAsClicked($url = null)
    {
        $metadata = $this->metadata ?? [];
        $metadata['clicked_at'] = now();
        $metadata['clicked'] = true;
        if ($url) {
            $metadata['clicked_url'] = $url;
        }
        
        $this->update(['metadata' => $metadata]);
    }

    public function getStatusBadgeAttribute()
    {
        $colors = [
            'pending' => 'yellow',
            'sent' => 'green',
            'failed' => 'red',
            'bounced' => 'orange',
            'cancelled' => 'gray',
        ];

        return [
            'text' => ucfirst($this->status),
            'color' => $colors[$this->status] ?? 'gray',
        ];
    }
}