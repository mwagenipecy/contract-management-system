<?php

namespace App\Livewire\Calendar;

use Livewire\Component;
use App\Models\Contract;
use App\Models\Employee;
use App\Models\ReminderItem;
use App\Models\ReminderCategory;
use Carbon\Carbon;

class Enhanced extends Component
{
    public $currentDate;
    public $selectedDate;
    public $viewMode = 'month'; // month, week, day
    public $showEventModal = false;
    public $selectedEvents = [];
    
    // Calendar navigation
    public $currentMonth;
    public $currentYear;
    public $daysInMonth;
    public $firstDayOfMonth;
    public $calendarDays = [];
    
    // Week/Day view properties
    public $weekDays = [];
    public $weekStartDate;
    public $weekEndDate;
    public $selectedDateObject;
    public $dayEvents;
    
    // Event filters - Enhanced with reminder types
    public $showContractExpirations = true;
    public $showContractRenewals = true;
    public $showContractNotifications = true;
    public $showEmployeeEvents = false;
    public $showReminders = true;
    public $selectedReminderCategories = [];
    
    // Event types - Enhanced with reminder categories
    public $eventTypes = [
        'contract_expiry' => ['color' => 'red', 'icon' => 'exclamation-triangle', 'label' => 'Contract Expiry'],
        'renewal_due' => ['color' => 'yellow', 'icon' => 'refresh', 'label' => 'Renewal Due'],
        'notification_scheduled' => ['color' => 'blue', 'icon' => 'bell', 'label' => 'Notification'],
        'employee_birthday' => ['color' => 'green', 'icon' => 'cake', 'label' => 'Birthday'],
        'reminder_due' => ['color' => 'purple', 'icon' => 'clock', 'label' => 'Reminder'],
        'reminder_overdue' => ['color' => 'red', 'icon' => 'exclamation', 'label' => 'Overdue'],
    ];

    public function mount()
    {
        $this->currentDate = Carbon::now();
        $this->selectedDate = $this->currentDate->format('Y-m-d');
        $this->selectedDateObject = $this->currentDate->copy();
        $this->currentMonth = $this->currentDate->month;
        $this->currentYear = $this->currentDate->year;
        
        // Initialize reminder categories
        $this->selectedReminderCategories = ReminderCategory::active()->pluck('id')->toArray();
        
        $this->generateCalendar();
    }

    // Year Navigation
    public function previousYear()
    {
        $this->currentDate = $this->currentDate->subYear();
        $this->currentMonth = $this->currentDate->month;
        $this->currentYear = $this->currentDate->year;
        $this->generateCalendar();
    }

    public function nextYear()
    {
        $this->currentDate = $this->currentDate->addYear();
        $this->currentMonth = $this->currentDate->month;
        $this->currentYear = $this->currentDate->year;
        $this->generateCalendar();
    }

    // Month Navigation
    public function previousMonth()
    {
        $this->currentDate = $this->currentDate->subMonth();
        $this->currentMonth = $this->currentDate->month;
        $this->currentYear = $this->currentDate->year;
        $this->generateCalendar();
    }

    public function nextMonth()
    {
        $this->currentDate = $this->currentDate->addMonth();
        $this->currentMonth = $this->currentDate->month;
        $this->currentYear = $this->currentDate->year;
        $this->generateCalendar();
    }

    // Week Navigation
    public function previousWeek()
    {
        $this->selectedDateObject = $this->selectedDateObject->subWeek();
        $this->selectedDate = $this->selectedDateObject->format('Y-m-d');
        $this->updateCurrentDateFromSelected();
        $this->generateCalendar();
    }

    public function nextWeek()
    {
        $this->selectedDateObject = $this->selectedDateObject->addWeek();
        $this->selectedDate = $this->selectedDateObject->format('Y-m-d');
        $this->updateCurrentDateFromSelected();
        $this->generateCalendar();
    }

    // Day Navigation
    public function previousDay()
    {
        $this->selectedDateObject = $this->selectedDateObject->subDay();
        $this->selectedDate = $this->selectedDateObject->format('Y-m-d');
        $this->updateCurrentDateFromSelected();
        $this->generateCalendar();
    }

    public function nextDay()
    {
        $this->selectedDateObject = $this->selectedDateObject->addDay();
        $this->selectedDate = $this->selectedDateObject->format('Y-m-d');
        $this->updateCurrentDateFromSelected();
        $this->generateCalendar();
    }

    public function goToToday()
    {
        $this->currentDate = Carbon::now();
        $this->selectedDateObject = Carbon::now();
        $this->selectedDate = $this->currentDate->format('Y-m-d');
        $this->currentMonth = $this->currentDate->month;
        $this->currentYear = $this->currentDate->year;
        $this->generateCalendar();
    }

    public function setViewMode($mode)
    {
        $this->viewMode = $mode;
        $this->generateCalendar();
    }

    public function selectDate($date)
    {
        $this->selectedDate = $date;
        $this->selectedDateObject = Carbon::parse($date);
        $this->selectedEvents = $this->getEventsForDate($date);
        
        if ($this->viewMode === 'day') {
            $this->generateCalendar(); // Refresh day view
        } else {
            $this->showEventModal = true;
        }
    }

    public function closeEventModal()
    {
        $this->showEventModal = false;
        $this->selectedEvents = [];
    }

    public function toggleReminderCategory($categoryId)
    {
        if (in_array($categoryId, $this->selectedReminderCategories)) {
            $this->selectedReminderCategories = array_diff($this->selectedReminderCategories, [$categoryId]);
        } else {
            $this->selectedReminderCategories[] = $categoryId;
        }
        $this->generateCalendar();
    }

    private function updateCurrentDateFromSelected()
    {
        $this->currentDate = $this->selectedDateObject->copy();
        $this->currentMonth = $this->currentDate->month;
        $this->currentYear = $this->currentDate->year;
    }

    private function generateCalendar()
    {
        switch ($this->viewMode) {
            case 'month':
                $this->generateMonthView();
                break;
            case 'week':
                $this->generateWeekView();
                break;
            case 'day':
                $this->generateDayView();
                break;
        }
    }

    private function generateMonthView()
    {
        $startOfMonth = Carbon::create($this->currentYear, $this->currentMonth, 1);
        $endOfMonth = $startOfMonth->copy()->endOfMonth();
        
        $this->daysInMonth = $endOfMonth->day;
        $this->firstDayOfMonth = $startOfMonth->dayOfWeek;
        
        // Generate calendar grid (6 weeks = 42 days)
        $this->calendarDays = [];
        $currentDate = $startOfMonth->copy()->startOfWeek();
        
        for ($week = 0; $week < 6; $week++) {
            $weekDays = [];
            for ($day = 0; $day < 7; $day++) {
                $date = $currentDate->copy();
                $weekDays[] = [
                    'date' => $date,
                    'dateString' => $date->format('Y-m-d'),
                    'day' => $date->day,
                    'isCurrentMonth' => $date->month == $this->currentMonth,
                    'isToday' => $date->isToday(),
                    'isSelected' => $date->format('Y-m-d') === $this->selectedDate,
                    'events' => $this->getEventsForDate($date->format('Y-m-d'))
                ];
                $currentDate->addDay();
            }
            $this->calendarDays[] = $weekDays;
        }
    }

    private function generateWeekView()
    {
        $this->weekStartDate = $this->selectedDateObject->copy()->startOfWeek();
        $this->weekEndDate = $this->selectedDateObject->copy()->endOfWeek();
        
        $this->weekDays = [];
        $currentDate = $this->weekStartDate->copy();
        
        for ($i = 0; $i < 7; $i++) {
            $this->weekDays[] = [
                'date' => $currentDate->copy(),
                'dateString' => $currentDate->format('Y-m-d'),
                'day' => $currentDate->day,
                'dayName' => $currentDate->format('D'),
                'isToday' => $currentDate->isToday(),
                'events' => $this->getEventsForDate($currentDate->format('Y-m-d'))
            ];
            $currentDate->addDay();
        }
    }

    private function generateDayView()
    {
        $this->dayEvents = $this->getEventsForDate($this->selectedDate);
    }

    private function getEventsForDate($date)
    {
        $events = collect();
        $targetDate = Carbon::parse($date);

        // Contract Events (existing logic)
        if ($this->showContractExpirations) {
            $expiringContracts = Contract::with('employee')
                ->where('status', 'active')
                ->whereDate('end_date', $date)
                ->get();

            foreach ($expiringContracts as $contract) {
                $events->push([
                    'id' => 'contract_expiry_' . $contract->id,
                    'type' => 'contract_expiry',
                    'title' => 'Contract Expires',
                    'description' => $contract->employee->name . ' - ' . $contract->contract_number,
                    'time' => 'All Day',
                    'hour' => 9, // Default hour for display
                    'contract' => $contract,
                    'priority' => 'high',
                    'url' => route('contracts.show', $contract),
                    'actions' => [
                        ['label' => 'View Contract', 'url' => route('contracts.show', $contract)],
                        ['label' => 'Renew Contract', 'url' => route('contracts.renew', $contract)],
                    ]
                ]);
            }
        }

        if ($this->showContractRenewals) {
            $renewalDueContracts = Contract::with('employee')
                ->where('status', 'active')
                ->whereDate('end_date', $targetDate->copy()->addDays(30))
                ->get();

            foreach ($renewalDueContracts as $contract) {
                $events->push([
                    'id' => 'contract_renewal_' . $contract->id,
                    'type' => 'renewal_due',
                    'title' => 'Renewal Due (30 days)',
                    'description' => $contract->employee->name . ' - ' . $contract->contract_number,
                    'time' => 'All Day',
                    'hour' => 10,
                    'contract' => $contract,
                    'priority' => 'medium',
                    'url' => route('contracts.renew', $contract),
                    'actions' => [
                        ['label' => 'Renew Now', 'url' => route('contracts.renew', $contract)],
                        ['label' => 'View Contract', 'url' => route('contracts.show', $contract)],
                    ]
                ]);
            }
        }

        // Reminder Items - NEW FEATURE
        if ($this->showReminders && !empty($this->selectedReminderCategories)) {
            $reminderItems = ReminderItem::with(['category', 'assignedTo'])
                ->where('status', 'active')
                ->whereIn('category_id', $this->selectedReminderCategories)
                ->whereDate('due_date', $date)
                ->get();

            foreach ($reminderItems as $item) {
                $isOverdue = $item->isOverdue();
                $eventType = $isOverdue ? 'reminder_overdue' : 'reminder_due';
                
                $events->push([
                    'id' => 'reminder_' . $item->id,
                    'type' => $eventType,
                    'title' => $item->title,
                    'description' => $item->category->name . ($item->vendor_supplier ? ' - ' . $item->vendor_supplier : ''),
                    'time' => 'All Day',
                    'hour' => $item->preferred_time ? Carbon::parse($item->preferred_time)->hour : 14,
                    'reminder_item' => $item,
                    'priority' => $item->priority,
                    'url' => route('reminders.show', $item),
                    'actions' => [
                        ['label' => 'View Details', 'url' => route('reminders.show', $item)],
                        ['label' => 'Mark Complete', 'action' => 'markComplete', 'id' => $item->id],
                        ['label' => 'Snooze 7 days', 'action' => 'snooze', 'id' => $item->id, 'days' => 7],
                    ]
                ]);
            }

            // Also get reminder notifications (items due in X days)
            $upcomingReminders = ReminderItem::with(['category', 'assignedTo'])
                ->where('status', 'active')
                ->whereIn('category_id', $this->selectedReminderCategories)
                ->whereRaw("DATE_SUB(due_date, INTERVAL ? DAY) = ?", [7, $date])
                ->get();

            foreach ($upcomingReminders as $item) {
                $events->push([
                    'id' => 'reminder_notification_' . $item->id,
                    'type' => 'notification_scheduled',
                    'title' => 'Reminder: ' . $item->title . ' (7 days)',
                    'description' => $item->category->name . ' - Due in 7 days',
                    'time' => '09:00 AM',
                    'hour' => 9,
                    'reminder_item' => $item,
                    'priority' => 'low',
                    'url' => route('reminders.show', $item),
                    'actions' => [
                        ['label' => 'View Details', 'url' => route('reminders.show', $item)],
                        ['label' => 'Update Item', 'url' => route('reminders.edit', $item)],
                    ]
                ]);
            }
        }

        // Employee Events (existing logic)
        if ($this->showEmployeeEvents) {
            $employees = Employee::whereMonth('hire_date', $targetDate->month)
                ->whereDay('hire_date', $targetDate->day)
                ->get();

            foreach ($employees as $employee) {
                $yearsEmployed = $targetDate->diffInYears($employee->hire_date);
                $events->push([
                    'id' => 'employee_anniversary_' . $employee->id,
                    'type' => 'employee_birthday',
                    'title' => 'Work Anniversary',
                    'description' => $employee->name . ' - ' . $yearsEmployed . ' years',
                    'time' => 'All Day',
                    'hour' => 11,
                    'employee' => $employee,
                    'priority' => 'low',
                    'url' => route('employees.show', $employee),
                    'actions' => [
                        ['label' => 'View Profile', 'url' => route('employees.show', $employee)],
                        ['label' => 'Send Congratulations', 'action' => 'sendCongrats', 'id' => $employee->id],
                    ]
                ]);
            }
        }

        return $events->sortByDesc(function ($event) {
            $priorityOrder = ['critical' => 4, 'high' => 3, 'medium' => 2, 'low' => 1];
            return $priorityOrder[$event['priority']] ?? 0;
        });
    }

    public function getReminderCategoriesProperty()
    {
        return ReminderCategory::active()
            ->withCount(['activeItems'])
            ->ordered()
            ->get();
    }

    public function getUpcomingEventsProperty()
    {
        $events = collect();
        $startDate = Carbon::now();
        $endDate = Carbon::now()->addDays(30);

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $dailyEvents = $this->getEventsForDate($date->format('Y-m-d'));
            foreach ($dailyEvents as $event) {
                $event['date'] = $date->format('Y-m-d');
                $events->push($event);
            }
        }

        return $events->take(10);
    }

    public function getMonthStatsProperty()
    {
        $startOfMonth = Carbon::create($this->currentYear, $this->currentMonth, 1);
        $endOfMonth = $startOfMonth->copy()->endOfMonth();

        $contractStats = [
            'expirations' => Contract::where('status', 'active')
                ->whereBetween('end_date', [$startOfMonth, $endOfMonth])
                ->count(),
            'renewals' => Contract::where('status', 'active')
                ->whereBetween('end_date', [$startOfMonth->copy()->addDays(30), $endOfMonth->copy()->addDays(30)])
                ->count(),
        ];

        $reminderStats = [
            'due_items' => ReminderItem::where('status', 'active')
                ->whereBetween('due_date', [$startOfMonth, $endOfMonth])
                ->count(),
            'overdue_items' => ReminderItem::where('status', 'active')
                ->where('due_date', '<', $startOfMonth)
                ->count(),
            'upcoming_notifications' => ReminderItem::where('status', 'active')
                ->whereBetween('due_date', [$startOfMonth->copy()->addDays(7), $endOfMonth->copy()->addDays(7)])
                ->count(),
        ];

        return array_merge($contractStats, $reminderStats);
    }

    // Calendar Action Methods
    public function markComplete($itemId)
    {
        $item = ReminderItem::findOrFail($itemId);
        $item->markCompleted(auth()->id(), 'Completed via calendar');
        
        session()->flash('message', 'Item marked as completed!');
        $this->generateCalendar(); // Refresh calendar
    }

    public function snooze($itemId, $days = 7)
    {
        $item = ReminderItem::findOrFail($itemId);
        $item->update(['due_date' => $item->due_date->addDays($days)]);
        
        session()->flash('message', "Item snoozed for {$days} days!");
        $this->generateCalendar(); // Refresh calendar
    }

    public function sendCongrats($employeeId)
    {
        // Implementation would send congratulations message
        session()->flash('message', 'Congratulations sent!');
    }

    // Quick date jumps
    public function jumpToDate($date)
    {
        $targetDate = Carbon::parse($date);
        $this->currentDate = $targetDate->copy();
        $this->selectedDate = $targetDate->format('Y-m-d');
        $this->selectedDateObject = $targetDate->copy();
        $this->currentMonth = $targetDate->month;
        $this->currentYear = $targetDate->year;
        $this->generateCalendar();
    }

    public function jumpToMonth($year, $month)
    {
        $this->currentYear = $year;
        $this->currentMonth = $month;
        $this->currentDate = Carbon::create($year, $month, 1);
        $this->generateCalendar();
    }

    public function render()
    {
        return view('livewire.calendar.enhanced', [
            'upcomingEvents' => $this->upcomingEvents,
            'monthStats' => $this->monthStats,
            'reminderCategories' => $this->reminderCategories,
        ]);
    }
}