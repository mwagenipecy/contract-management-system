<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReminderAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'reminder_item_id',
        'employee_id',
        'role',
        'receives_notifications',
        'notification_methods',
    ];

    protected $casts = [
        'receives_notifications' => 'boolean',
        'notification_methods' => 'array',
    ];

    public function reminderItem()
    {
        return $this->belongsTo(ReminderItem::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
