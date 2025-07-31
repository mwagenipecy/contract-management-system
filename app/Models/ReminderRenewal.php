<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReminderRenewal extends Model
{
    use HasFactory;

    protected $fillable = [
        'reminder_item_id',
        'previous_start_date',
        'previous_end_date',
        'new_start_date',
        'new_end_date',
        'renewal_amount',
        'renewal_reference',
        'renewal_notes',
        'renewal_documents',
        'renewed_by',
        'renewed_at',
    ];

    protected $casts = [
        'previous_start_date' => 'date',
        'previous_end_date' => 'date',
        'new_start_date' => 'date',
        'new_end_date' => 'date',
        'renewal_amount' => 'decimal:2',
        'renewal_documents' => 'array',
        'renewed_at' => 'datetime',
    ];

    public function reminderItem()
    {
        return $this->belongsTo(ReminderItem::class);
    }

    public function renewedBy()
    {
        return $this->belongsTo(User::class, 'renewed_by');
    }
}