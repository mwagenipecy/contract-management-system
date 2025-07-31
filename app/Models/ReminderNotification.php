<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReminderNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'reminder_item_id',
        'employee_id',
        'notification_type',
        'method',
        'days_before',
        'scheduled_at',
        'sent_at',
        'status',
        'message',
        'metadata',
        'external_reference',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function reminderItem()
    {
        return $this->belongsTo(ReminderItem::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function markAsSent($externalReference = null, $metadata = null)
    {
        $this->update([
            'status' => 'sent',
            'sent_at' => now(),
            'external_reference' => $externalReference,
            'metadata' => $metadata,
        ]);
    }
}
