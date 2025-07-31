<?php

namespace App\Livewire\Reminders;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ReminderItem;
use App\Models\ReminderCategory;
use App\Models\Employee;
use Carbon\Carbon;

class Dashboard extends Component
{
    use WithPagination;

    public $selectedView = 'overview';
    public $selectedCategory = '';
    public $selectedPriority = '';
    public $selectedType = '';
    public $search = '';
    public $dateRange = 'next_30_days';
    public $customStartDate = '';
    public $customEndDate = '';
    public $assignedToMe = false;

    // Quick action states
    public $showQuickCompleteModal = false;
    public $showQuickRenewModal = false;
    public $showBulkActionsModal = false;
    public $completingItem = null;
    public $renewingItem = null;
    public $completionNotes = '';
    public $renewalEndDate = '';
    public $renewalAmount = '';
    public $renewalNotes = '';
    public $selectedItems = [];
    public $selectAll = false;

    protected $queryString = [
        'selectedView' => ['except' => 'overview'],
        'selectedCategory' => ['except' => ''],
        'selectedPriority' => ['except' => ''],
        'selectedType' => ['except' => ''],
        'search' => ['except' => ''],
        'dateRange' => ['except' => 'next_30_days'],
        'assignedToMe' => ['except' => false],
    ];

    public function mount()
    {
        $this->customStartDate = Carbon::now()->format('Y-m-d');
        $this->customEndDate = Carbon::now()->addDays(30)->format('Y-m-d');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectedCategory()
    {
        $this->resetPage();
    }

    public function updatedSelectedPriority()
    {
        $this->resetPage();
    }

    public function updatedSelectedType()
    {
        $this->resetPage();
    }

    public function updatedSelectedView()
    {
        $this->resetPage();
        $this->selectedItems = [];
        $this->selectAll = false;
    }

    public function updatedAssignedToMe()
    {
        $this->resetPage();
    }

    public function updatedSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedItems = $this->items->pluck('id')->toArray();
        } else {
            $this->selectedItems = [];
        }
    }

    public function setView($view)
    {
        $this->selectedView = $view;
        $this->resetPage();
    }

    public function setDateRange($range)
    {
        $this->dateRange = $range;
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->selectedCategory = '';
        $this->selectedPriority = '';
        $this->selectedType = '';
        $this->search = '';
        $this->assignedToMe = false;
        $this->dateRange = 'next_30_days';
        $this->selectedItems = [];
        $this->selectAll = false;
        $this->resetPage();
    }

    public function openQuickComplete($itemId)
    {
        $this->completingItem = ReminderItem::with(['category', 'assignedEmployees'])->findOrFail($itemId);
        $this->completionNotes = '';
        $this->showQuickCompleteModal = true;
    }

    public function closeQuickCompleteModal()
    {
        $this->showQuickCompleteModal = false;
        $this->completingItem = null;
        $this->completionNotes = '';
    }

    public function quickComplete()
    {
        if ($this->completingItem) {
            $this->completingItem->markCompleted(auth()->id(), $this->completionNotes);
            
            session()->flash('message', 'Item marked as completed successfully!');
            $this->closeQuickCompleteModal();
        }
    }

    public function openQuickRenew($itemId)
    {
        $this->renewingItem = ReminderItem::with(['category', 'assignedEmployees'])->findOrFail($itemId);
        
        // Set default renewal date based on category type
        if ($this->renewingItem->category->has_start_end_dates) {
            $this->renewalEndDate = Carbon::parse($this->renewingItem->end_date)->addYear()->format('Y-m-d');
        } else {
            $this->renewalEndDate = Carbon::parse($this->renewingItem->due_date)->addYear()->format('Y-m-d');
        }
        
        $this->renewalAmount = $this->renewingItem->amount;
        $this->renewalNotes = '';
        $this->showQuickRenewModal = true;
    }

    public function closeQuickRenewModal()
    {
        $this->showQuickRenewModal = false;
        $this->renewingItem = null;
        $this->renewalEndDate = '';
        $this->renewalAmount = '';
        $this->renewalNotes = '';
    }

    public function quickRenew()
    {
        $this->validate([
            'renewalEndDate' => 'required|date|after:today',
            'renewalAmount' => 'nullable|numeric|min:0',
        ]);

        if ($this->renewingItem) {
            $this->renewingItem->renew(
                $this->renewalEndDate,
                $this->renewalAmount,
                $this->renewalNotes,
                null,
                auth()->id()
            );
            
            session()->flash('message', 'Item renewed successfully!');
            $this->closeQuickRenewModal();
        }
    }

    public function snoozeItem($itemId, $days = 7)
    {
        $item = ReminderItem::findOrFail($itemId);
        
        // Update the appropriate date based on reminder type
        if ($item->category->has_start_end_dates) {
            $newDate = $item->end_date->addDays($days);
            $item->update(['end_date' => $newDate, 'due_date' => $newDate]);
        } elseif ($item->category->reminder_type === 'event') {
            $newDate = $item->event_date->addDays($days);
            $item->update(['event_date' => $newDate, 'due_date' => $newDate]);
        } else {
            $newDate = $item->due_date->addDays($days);
            $item->update(['due_date' => $newDate]);
        }
        
        // Reschedule notifications
        $item->notifications()->where('status', 'pending')->delete();
        $item->scheduleNotifications();
        
        session()->flash('message', "Item snoozed for {$days} days!");
    }

    public function approveItem($itemId)
    {
        $item = ReminderItem::findOrFail($itemId);
        
        if ($item->status === 'pending_approval') {
            $item->update([
                'status' => 'active',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);
            
            session()->flash('message', 'Item approved successfully!');
        }
    }

    public function bulkComplete()
    {
        if (!empty($this->selectedItems)) {
            ReminderItem::whereIn('id', $this->selectedItems)
                ->update([
                    'status' => 'completed',
                    'completed_at' => now(),
                ]);
            
            $count = count($this->selectedItems);
            $this->selectedItems = [];
            $this->selectAll = false;
            session()->flash('message', "{$count} items marked as completed.");
        }
    }

    public function bulkSnooze($days = 7)
    {
        if (!empty($this->selectedItems)) {
            $items = ReminderItem::whereIn('id', $this->selectedItems)->get();
            
            foreach ($items as $item) {
                $this->snoozeItem($item->id, $days);
            }
            
            $count = count($this->selectedItems);
            $this->selectedItems = [];
            $this->selectAll = false;
            session()->flash('message', "{$count} items snoozed for {$days} days.");
        }
    }

    public function getStatsProperty()
    {
        $baseQuery = ReminderItem::query();
        
        if ($this->assignedToMe) {
            $user = auth()->user();
            $employee = Employee::where('email', $user->email)->first();
            if ($employee) {
                $baseQuery->forEmployee($employee->id);
            }
        }

        return [
            'total' => (clone $baseQuery)->where('status', 'active')->count(),
            'overdue' => (clone $baseQuery)->overdue()->count(),
            'due_today' => (clone $baseQuery)->where('status', 'active')
                ->whereDate('due_date', Carbon::today())
                ->count(),
            'upcoming_week' => (clone $baseQuery)->upcoming(7)->count(),
            'upcoming_month' => (clone $baseQuery)->upcoming(30)->count(),
            'high_priority' => (clone $baseQuery)->where('status', 'active')
                ->whereIn('priority', ['high', 'critical'])->count(),
            'pending_approval' => (clone $baseQuery)->where('status', 'pending_approval')->count(),
            'completed_this_month' => (clone $baseQuery)->where('status', 'completed')
                ->whereMonth('completed_at', Carbon::now()->month)
                ->whereYear('completed_at', Carbon::now()->year)
                ->count(),
            'renewal_due' => (clone $baseQuery)->where('status', 'active')
                ->whereHas('category', function($q) {
                    $q->where('is_renewable', true);
                })
                ->where('due_date', '<=', Carbon::now()->addDays(60))
                ->count(),
        ];
    }

    public function getCategoriesProperty()
    {
        return ReminderCategory::active()
            ->withCount([
                'activeItems',
                'items as overdue_count' => function($query) {
                    $query->overdue();
                },
                'items as upcoming_count' => function($query) {
                    $query->upcoming(30);
                }
            ])
           // ->ordered()
            ->get();
    }

    public function getItemsProperty()
    {
        $query = ReminderItem::with(['category', 'assignedEmployees', 'createdBy'])
            ->when($this->search, function ($q) {
                $q->where(function ($subQuery) {
                    $subQuery->where('title', 'like', '%' . $this->search . '%')
                            ->orWhere('description', 'like', '%' . $this->search . '%')
                            ->orWhere('vendor_supplier', 'like', '%' . $this->search . '%')
                            ->orWhere('reference_number', 'like', '%' . $this->search . '%')
                            ->orWhereHas('assignedEmployees', function($eq) {
                                $eq->where('name', 'like', '%' . $this->search . '%');
                            });
                });
            })
            ->when($this->selectedCategory, function ($q) {
                $q->where('category_id', $this->selectedCategory);
            })
            ->when($this->selectedPriority, function ($q) {
                $q->where('priority', $this->selectedPriority);
            })
            ->when($this->selectedType, function ($q) {
                $q->whereHas('category', function($cq) {
                    $cq->where('reminder_type', $this->selectedType);
                });
            })
            ->when($this->assignedToMe, function ($q) {
                $user = auth()->user();
                $employee = Employee::where('email', $user->email)->first();
                if ($employee) {
                    $q->forEmployee($employee->id);
                }
            });

        // Apply view filters
        switch ($this->selectedView) {
            case 'overdue':
                $query->overdue()->orderBy('due_date');
                break;
            case 'upcoming':
                $query->upcoming($this->getDateRangeDays())
                      ->orderBy('due_date');
                break;
            case 'completed':
                $query->where('status', 'completed')
                      ->orderBy('completed_at', 'desc');
                break;
            case 'pending_approval':
                $query->where('status', 'pending_approval')
                      ->orderBy('created_at', 'desc');
                break;
            case 'overview':
            default:
                $query->where('status', 'active')
                      ->orderByRaw("CASE 
                          WHEN due_date < CURDATE() THEN 1 
                          WHEN due_date = CURDATE() THEN 2 
                          WHEN due_date <= DATE_ADD(CURDATE(), INTERVAL 7 DAY) THEN 3 
                          ELSE 4 END")
                      ->orderByRaw("CASE priority 
                          WHEN 'critical' THEN 1 
                          WHEN 'high' THEN 2 
                          WHEN 'medium' THEN 3 
                          WHEN 'low' THEN 4 END")
                      ->orderBy('due_date');
                break;
        }

        // Apply date range for upcoming items
        if ($this->selectedView === 'upcoming') {
            $dateRange = $this->getDateRange();
            if ($dateRange) {
                $query->whereBetween('due_date', $dateRange);
            }
        }

        return $query->paginate(20);
    }

    private function getDateRange()
    {
        switch ($this->dateRange) {
            case 'today':
                return [Carbon::today(), Carbon::today()];
            case 'next_7_days':
                return [Carbon::now(), Carbon::now()->addDays(7)];
            case 'next_30_days':
                return [Carbon::now(), Carbon::now()->addDays(30)];
            case 'custom':
                if ($this->customStartDate && $this->customEndDate) {
                    return [Carbon::parse($this->customStartDate), Carbon::parse($this->customEndDate)];
                }
                break;
        }
        return null;
    }

    private function getDateRangeDays()
    {
        switch ($this->dateRange) {
            case 'today':
                return 0;
            case 'next_7_days':
                return 7;
            case 'next_30_days':
                return 30;
            case 'custom':
                if ($this->customStartDate && $this->customEndDate) {
                    return Carbon::parse($this->customStartDate)->diffInDays(Carbon::parse($this->customEndDate));
                }
                return 30;
        }
        return 30;
    }

    public function getUpcomingEventsProperty()
    {
        $baseQuery = ReminderItem::with(['category', 'assignedEmployees'])
            ->where('status', 'active')
            ->where('due_date', '>=', Carbon::now())
            ->where('due_date', '<=', Carbon::now()->addDays(7));
            
        if ($this->assignedToMe) {
            $user = auth()->user();
            $employee = Employee::where('email', $user->email)->first();
            if ($employee) {
                $baseQuery->forEmployee($employee->id);
            }
        }

        return $baseQuery->orderBy('due_date')
            ->orderByRaw("CASE priority WHEN 'critical' THEN 1 WHEN 'high' THEN 2 WHEN 'medium' THEN 3 WHEN 'low' THEN 4 END")
            ->limit(8)
            ->get();
    }

    public function getReminderTypesProperty()
    {
        return [
            'license' => 'Licenses & Permits',
            'event' => 'Events & Activities', 
            'contract' => 'Contracts',
            'task' => 'Tasks',
            'maintenance' => 'Maintenance',
            'financial' => 'Financial',
            'training' => 'Training',
            'welfare' => 'Staff Welfare',
        ];
    }

    public function render()
    {
        return view('livewire.reminders.dashboard', [
            'stats' => $this->stats,
            'categories' => $this->categories,
            'items' => $this->items,
            'upcomingEvents' => $this->upcomingEvents,
            'reminderTypes' => $this->reminderTypes,
        ]);
    }
}