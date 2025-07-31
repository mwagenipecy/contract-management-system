<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ReminderCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'color',
        'reminder_type',
        'required_fields',
        'optional_fields',
        'default_notification_periods',
        'notification_methods',
        'has_start_end_dates',
        'is_renewable',
        'is_recurring',
        'requires_approval',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'required_fields' => 'array',
        'optional_fields' => 'array',
        'default_notification_periods' => 'array',
        'notification_methods' => 'array',
        'has_start_end_dates' => 'boolean',
        'is_renewable' => 'boolean',
        'is_recurring' => 'boolean',
        'requires_approval' => 'boolean',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function items()
    {
        return $this->hasMany(ReminderItem::class, 'category_id');
    }

    public function activeItems()
    {
        return $this->hasMany(ReminderItem::class, 'category_id')->where('status', 'active');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('reminder_type', $type);
    }

    // Methods
    public function getFieldConfiguration()
    {
        $baseFields = ['title', 'description', 'due_date', 'priority'];
        
        if ($this->has_start_end_dates) {
            $baseFields = array_merge($baseFields, ['start_date', 'end_date']);
        }
        
        if ($this->reminder_type === 'event') {
            $baseFields = array_merge($baseFields, ['event_date']);
        }
        
        return [
            'required' => array_merge($baseFields, $this->required_fields ?? []),
            'optional' => $this->optional_fields ?? [],
        ];
    }

    public function getNotificationMethods()
    {
        return $this->notification_methods ?? ['email', 'system'];
    }



    public function scopeOrdered($query)
{
    return $query->orderBy('created_at', 'asc');
}

}