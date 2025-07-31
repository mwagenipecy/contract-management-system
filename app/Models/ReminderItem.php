<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class ReminderItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'event_date',
        'due_date',
        'renewal_date',
        'status',
        'priority',
        'assigned_employees',
        'notification_recipients',
        'notification_periods',
        'notification_methods',
        'amount',
        'currency',
        'vendor_supplier',
        'reference_number',
        'custom_fields',
        'documents',
        'notes',
        'completion_notes',
        'created_by',
        'approved_by',
        'approved_at',
        'completed_at',
        'last_notification_sent',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'event_date' => 'date',
        'due_date' => 'date',
        'renewal_date' => 'date',
        'assigned_employees' => 'array',
        'notification_recipients' => 'array',
        'notification_periods' => 'array',
        'notification_methods' => 'array',
        'custom_fields' => 'array',
        'documents' => 'array',
        'approved_at' => 'datetime',
        'completed_at' => 'datetime',
        'last_notification_sent' => 'datetime',
        'amount' => 'decimal:2',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(ReminderCategory::class, 'category_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function assignments()
    {
        return $this->hasMany(ReminderAssignment::class);
    }

    public function assignedEmployees()
    {
        return $this->belongsToMany(Employee::class, 'reminder_assignments');
    }

    public function notifications()
    {
        return $this->hasMany(ReminderNotification::class);
    }

    public function renewals()
    {
        return $this->hasMany(ReminderRenewal::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'active')
                    ->where('due_date', '<', Carbon::now());
    }

    public function scopeUpcoming($query, $days = 30)
    {
        return $query->where('status', 'active')
                    ->where('due_date', '>=', Carbon::now())
                    ->where('due_date', '<=', Carbon::now()->addDays($days));
    }

    public function scopeByType($query, $type)
    {
        return $query->whereHas('category', function($q) use ($type) {
            $q->where('reminder_type', $type);
        });
    }

    public function scopeForEmployee($query, $employeeId)
    {
        return $query->whereHas('assignments', function($q) use ($employeeId) {
            $q->where('employee_id', $employeeId);
        });
    }

    // Accessors
    public function getEffectiveDueDateAttribute()
    {
        // For events, use event_date; for licenses/contracts, use end_date; otherwise use due_date
        if ($this->category->reminder_type === 'event' && $this->event_date) {
            return $this->event_date;
        }
        
        if ($this->category->has_start_end_dates && $this->end_date) {
            return $this->end_date;
        }
        
        return $this->due_date;
    }

    public function getDaysUntilDueAttribute()
    {
        return Carbon::now()->diffInDays($this->effective_due_date, false);
    }

    public function getStatusBadgeAttribute()
    {
        $colors = [
            'active' => $this->isOverdue() ? 'red' : ($this->isDueSoon() ? 'yellow' : 'green'),
            'completed' => 'gray',
            'overdue' => 'red',
            'cancelled' => 'gray',
            'pending_approval' => 'blue',
        ];

        $text = $this->status;
        if ($this->status === 'active' && $this->isOverdue()) {
            $text = 'overdue';
        } elseif ($this->status === 'active' && $this->isDueSoon()) {
            $text = 'due soon';
        }

        return [
            'text' => ucfirst(str_replace('_', ' ', $text)),
            'color' => $colors[$this->status] ?? 'gray',
        ];
    }

    public function getFormattedAmountAttribute()
    {
        if (!$this->amount) return null;
        return $this->currency . ' ' . number_format($this->amount, 2);
    }

    // Methods
    public function isOverdue()
    {
        return $this->status === 'active' && $this->effective_due_date < Carbon::now();
    }

    public function isDueSoon($days = 7)
    {
        return $this->status === 'active' && 
               $this->effective_due_date <= Carbon::now()->addDays($days) && 
               $this->effective_due_date >= Carbon::now();
    }

    public function getNotificationPeriods()
    {
        return $this->notification_periods ?? $this->category->default_notification_periods ?? [30, 7, 1];
    }

    public function getNotificationMethods()
    {
        return $this->notification_methods ?? $this->category->getNotificationMethods();
    }

    public function assignEmployee($employeeId, $role = 'responsible', $notificationMethods = ['email'])
    {
        return $this->assignments()->updateOrCreate(
            ['employee_id' => $employeeId, 'role' => $role],
            [
                'receives_notifications' => true,
                'notification_methods' => $notificationMethods,
            ]
        );
    }

    public function scheduleNotifications()
    {
        $notificationPeriods = $this->getNotificationPeriods();
        $methods = $this->getNotificationMethods();
        
        // Get all assigned employees who should receive notifications
        $recipients = $this->assignments()
            ->where('receives_notifications', true)
            ->with('employee')
            ->get();

        foreach ($notificationPeriods as $daysBefore) {
            $scheduledAt = $this->effective_due_date->copy()->subDays($daysBefore);
            
            if ($scheduledAt->isFuture()) {
                foreach ($recipients as $assignment) {
                    $employeeMethods = $assignment->notification_methods ?? $methods;
                    
                    foreach ($employeeMethods as $method) {
                        $this->notifications()->create([
                            'employee_id' => $assignment->employee_id,
                            'notification_type' => 'reminder',
                            'method' => $method,
                            'days_before' => $daysBefore,
                            'scheduled_at' => $scheduledAt,
                            'message' => $this->generateNotificationMessage($daysBefore),
                        ]);
                    }
                }
            }
        }
    }

    public function markCompleted($completedBy = null, $notes = null)
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
            'completion_notes' => $notes,
        ]);

        // Cancel pending notifications
        $this->notifications()->where('status', 'pending')->update(['status' => 'cancelled']);

        // If renewable, create next occurrence
        if ($this->category->is_renewable && $this->renewal_date) {
            $this->createRenewalItem();
        }
    }

    public function renew($newEndDate, $amount = null, $notes = null, $documents = null, $renewedBy = null)
    {
        // Create renewal record
        $this->renewals()->create([
            'previous_start_date' => $this->start_date,
            'previous_end_date' => $this->end_date ?? $this->due_date,
            'new_start_date' => $this->end_date ?? $this->due_date,
            'new_end_date' => $newEndDate,
            'renewal_amount' => $amount,
            'renewal_notes' => $notes,
            'renewal_documents' => $documents,
            'renewed_by' => $renewedBy ?? auth()->id(),
            'renewed_at' => now(),
        ]);

        // Update the item
        $updateData = [
            'status' => 'active',
            'completed_at' => null,
        ];

        if ($this->category->has_start_end_dates) {
            $updateData['start_date'] = $this->end_date ?? $this->due_date;
            $updateData['end_date'] = $newEndDate;
        }
        
        $updateData['due_date'] = $newEndDate;
        
        if ($amount) {
            $updateData['amount'] = $amount;
        }

        $this->update($updateData);

        // Clear old notifications and schedule new ones
        $this->notifications()->where('status', 'pending')->delete();
        $this->scheduleNotifications();
    }

    private function generateNotificationMessage($daysBefore)
    {
        $itemType = $this->category->reminder_type;
        $action = $this->category->is_renewable ? 'renewal' : 'attention';
        
        if ($daysBefore === 0) {
            return "{$this->title} {$action} is due today!";
        } elseif ($daysBefore === 1) {
            return "{$this->title} {$action} is due tomorrow!";
        } else {
            return "{$this->title} {$action} is due in {$daysBefore} days.";
        }
    }

    private function createRenewalItem()
    {
        // Logic to create next occurrence for recurring items
        if (!$this->renewal_date) return;

        $nextItem = $this->replicate();
        $nextItem->start_date = $this->renewal_date;
        $nextItem->due_date = $this->renewal_date;
        $nextItem->status = 'active';
        $nextItem->completed_at = null;
        $nextItem->completion_notes = null;
        $nextItem->save();

        // Copy assignments
        foreach ($this->assignments as $assignment) {
            $nextItem->assignments()->create($assignment->toArray());
        }

        $nextItem->scheduleNotifications();
    }


    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}