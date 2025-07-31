<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Promotion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'type',
        'priority',
        'status',
        'start_date',
        'end_date',
        'scheduled_at',
        'sent_at',
        'recipient_type',
        'selected_employees',
        'selected_departments',
        'total_recipients',
        'actual_recipients',
        'delivery_methods',
        'attachments',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
        'selected_employees' => 'array',
        'selected_departments' => 'array',
        'delivery_methods' => 'array',
        'attachments' => 'array',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function deliveries()
    {
        return $this->hasMany(PromotionDelivery::class);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'promotion_deliveries')
                    ->withPivot(['method', 'status', 'sent_at', 'failure_reason'])
                    ->withTimestamps();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled')
                    ->where('scheduled_at', '<=', now());
    }

    public function scopeDue($query)
    {
        return $query->where('status', 'scheduled')
                    ->where('scheduled_at', '<=', now());
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $colors = [
            'draft' => 'gray',
            'scheduled' => 'yellow',
            'sent' => 'green',
            'cancelled' => 'red',
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
            'high' => 'orange',
            'urgent' => 'red',
        ];

        return [
            'text' => ucfirst($this->priority),
            'color' => $colors[$this->priority] ?? 'gray',
        ];
    }

    public function getTypeBadgeAttribute()
    {
        $colors = [
            'promotion' => 'green',
            'announcement' => 'blue',
            'update' => 'yellow',
            'alert' => 'red',
            'celebration' => 'purple',
        ];

        return [
            'text' => ucfirst($this->type),
            'color' => $colors[$this->type] ?? 'blue',
        ];
    }

    public function getDeliveryStatsAttribute()
    {
        $stats = [
            'total' => $this->deliveries()->count(),
            'sent' => $this->deliveries()->where('status', 'sent')->count(),
            'failed' => $this->deliveries()->where('status', 'failed')->count(),
            'pending' => $this->deliveries()->where('status', 'pending')->count(),
        ];

        $stats['success_rate'] = $stats['total'] > 0 ? round(($stats['sent'] / $stats['total']) * 100, 1) : 0;

        return $stats;
    }

    // Methods
    public function getRecipients()
    {
        switch ($this->recipient_type) {
            case 'selected_employees':
                return Employee::whereIn('id', $this->selected_employees ?? [])->get();
            case 'departments':
                return Employee::whereIn('department_id', $this->selected_departments ?? [])->get();
            default:
                return Employee::active()->get();
        }
    }

    public function scheduleDeliveries()
    {
        $recipients = $this->getRecipients();
        
        foreach ($recipients as $employee) {
            foreach ($this->delivery_methods as $method) {
                if ($method === 'email' && $employee->email) {
                    $this->deliveries()->create([
                        'employee_id' => $employee->id,
                        'method' => 'email',
                        'status' => 'pending',
                    ]);
                } elseif ($method === 'sms' && $employee->phone) {
                    $this->deliveries()->create([
                        'employee_id' => $employee->id,
                        'method' => 'sms',
                        'status' => 'pending',
                    ]);
                }
            }
        }

        $this->update(['total_recipients' => $this->deliveries()->count()]);
    }

    public function send()
    {
        if ($this->status === 'sent') {
            return false;
        }

        $this->scheduleDeliveries();
        
        $successCount = 0;
        foreach ($this->deliveries()->where('status', 'pending')->get() as $delivery) {
            try {
                if ($delivery->method === 'email') {
                    $this->sendEmail($delivery);
                } elseif ($delivery->method === 'sms') {
                    $this->sendSMS($delivery);
                }
                
                $delivery->update([
                    'status' => 'sent',
                    'sent_at' => now(),
                ]);
                $successCount++;
            } catch (\Exception $e) {
                $delivery->update([
                    'status' => 'failed',
                    'failure_reason' => $e->getMessage(),
                ]);
            }
        }

        $this->update([
            'status' => 'sent',
            'sent_at' => now(),
            'actual_recipients' => $successCount,
        ]);

        return true;
    }

    private function sendEmail($delivery)
    {
        \Mail::to($delivery->employee->email)->send(new \App\Mail\PromotionMail($this, $delivery->employee));
    }

    private function sendSMS($delivery)
    {
        // SMS implementation would depend on your SMS service provider
        // Example for Twilio or similar service
        $message = $this->getSMSContent();
        
        // Your SMS service implementation here
        // Example: \SMS::send($delivery->employee->phone, $message);
        
        // For now, we'll just log it
        \Log::info("SMS sent to {$delivery->employee->phone}: {$message}");
    }

    private function getSMSContent()
    {
        $content = strip_tags($this->content);
        $maxLength = 160 - strlen($this->title) - 10; // Reserve space for title and formatting
        
        if (strlen($content) > $maxLength) {
            $content = substr($content, 0, $maxLength - 3) . '...';
        }
        
        return "{$this->title}: {$content}";
    }

    public function duplicate()
    {
        $duplicate = $this->replicate();
        $duplicate->title = $this->title . ' (Copy)';
        $duplicate->status = 'draft';
        $duplicate->sent_at = null;
        $duplicate->actual_recipients = null;
        $duplicate->scheduled_at = null;
        $duplicate->created_by = auth()->id();
        $duplicate->save();

        return $duplicate;
    }

    public function cancel()
    {
        if ($this->status === 'scheduled') {
            $this->update(['status' => 'cancelled']);
            $this->deliveries()->where('status', 'pending')->update(['status' => 'cancelled']);
            return true;
        }
        return false;
    }

    public function reschedule($newDateTime)
    {
        if ($this->status === 'scheduled') {
            $this->update([
                'scheduled_at' => $newDateTime,
                'status' => 'scheduled'
            ]);
            return true;
        }
        return false;
    }

    // Static methods
    public static function getTypeOptions()
    {
        return [
            'promotion' => 'Promotion',
            'announcement' => 'Announcement',
            'update' => 'Update',
            'alert' => 'Alert',
            'celebration' => 'Celebration',
        ];
    }

    public static function getPriorityOptions()
    {
        return [
            'low' => 'Low',
            'medium' => 'Medium',
            'high' => 'High',
            'urgent' => 'Urgent',
        ];
    }

    public static function getStatusOptions()
    {
        return [
            'draft' => 'Draft',
            'scheduled' => 'Scheduled',
            'sent' => 'Sent',
            'cancelled' => 'Cancelled',
        ];
    }
}