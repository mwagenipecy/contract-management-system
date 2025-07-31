<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReminderHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'reminder_item_id',
        'previous_due_date',
        'new_due_date',
        'amount_paid',
        'notes',
        'documents',
        'completed_by',
        'completed_at',
    ];

    protected $casts = [
        'previous_due_date' => 'date',
        'new_due_date' => 'date',
        'amount_paid' => 'decimal:2',
        'documents' => 'array',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function reminderItem()
    {
        return $this->belongsTo(ReminderItem::class);
    }

    public function completedBy()
    {
        return $this->belongsTo(User::class, 'completed_by');
    }
}