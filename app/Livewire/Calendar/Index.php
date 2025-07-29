<?php

namespace App\Livewire\Calendar;

use Livewire\Component;
use App\Models\Contract;
use App\Models\Employee;
use Carbon\Carbon;

class Index extends Component
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
    
    // Event filters
    public $showExpirations = true;
    public $showRenewals = true;
    public $showNotifications = true;
    public $showBirthdays = false;
    
    // Event types
    public $eventTypes = [
        'contract_expiry' => ['color' => 'red', 'icon' => 'exclamation-triangle', 'label' => 'Contract Expiry'],
        'renewal_due' => ['color' => 'yellow', 'icon' => 'refresh', 'label' => 'Renewal Due'],
        'notification_scheduled' => ['color' => 'blue', 'icon' => 'bell', 'label' => 'Notification'],
        'employee_birthday' => ['color' => 'green', 'icon' => 'cake', 'label' => 'Birthday'],
    ];

    public function mount()
    {
        $this->currentDate = Carbon::now();
        $this->selectedDate = $this->currentDate->format('Y-m-d');
        $this->currentMonth = $this->currentDate->month;
        $this->currentYear = $this->currentDate->year;
        $this->generateCalendar();
    }

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

    public function goToToday()
    {
        $this->currentDate = Carbon::now();
        $this->currentMonth = $this->currentDate->month;
        $this->currentYear = $this->currentDate->year;
        $this->generateCalendar();
    }

    public function setViewMode($mode)
    {
        $this->viewMode = $mode;
        if ($mode !== 'month') {
            $this->generateCalendar();
        }
    }

    public function selectDate($date)
    {
        $this->selectedDate = $date;
        $this->selectedEvents = $this->getEventsForDate($date);
        $this->showEventModal = true;
    }

    public function closeEventModal()
    {
        $this->showEventModal = false;
        $this->selectedEvents = [];
    }

    private function generateCalendar()
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

    private function getEventsForDate($date)
    {
        $events = collect();
        $targetDate = Carbon::parse($date);

        // Contract Expirations
        if ($this->showExpirations) {
            $expiringContracts = Contract::with('employee')
                ->where('status', 'active')
                ->whereDate('end_date', $date)
                ->get();

            foreach ($expiringContracts as $contract) {
                $events->push([
                    'id' => 'expiry_' . $contract->id,
                    'type' => 'contract_expiry',
                    'title' => 'Contract Expires',
                    'description' => $contract->employee->name . ' - ' . $contract->contract_number,
                    'time' => 'All Day',
                    'contract' => $contract,
                    'priority' => 'high',
                    'url' => route('contracts.show', $contract)
                ]);
            }
        }

        // Renewal Due (30 days before expiry)
        if ($this->showRenewals) {
            $renewalDueContracts = Contract::with('employee')
                ->where('status', 'active')
                ->whereDate('end_date', $targetDate->copy()->addDays(30))
                ->get();

            foreach ($renewalDueContracts as $contract) {
                $events->push([
                    'id' => 'renewal_' . $contract->id,
                    'type' => 'renewal_due',
                    'title' => 'Renewal Due (30 days)',
                    'description' => $contract->employee->name . ' - ' . $contract->contract_number,
                    'time' => 'All Day',
                    'contract' => $contract,
                    'priority' => 'medium',
                    'url' => route('contracts.renew', $contract)
                ]);
            }
        }

        // Notification reminders (7 days before expiry)
        if ($this->showNotifications) {
            $notificationContracts = Contract::with('employee')
                ->where('status', 'active')
                ->whereDate('end_date', $targetDate->copy()->addDays(7))
                ->get();

            foreach ($notificationContracts as $contract) {
                $events->push([
                    'id' => 'notification_' . $contract->id,
                    'type' => 'notification_scheduled',
                    'title' => 'Send Reminder (7 days)',
                    'description' => $contract->employee->name . ' - ' . $contract->contract_number,
                    'time' => '09:00 AM',
                    'contract' => $contract,
                    'priority' => 'low',
                    'url' => route('contracts.show', $contract)
                ]);
            }
        }

        // Employee Birthdays (if enabled)
        if ($this->showBirthdays) {
            $employees = Employee::whereMonth('hire_date', $targetDate->month)
                ->whereDay('hire_date', $targetDate->day)
                ->get();

            foreach ($employees as $employee) {
                $yearsEmployed = $targetDate->diffInYears($employee->hire_date);
                $events->push([
                    'id' => 'birthday_' . $employee->id,
                    'type' => 'employee_birthday',
                    'title' => 'Work Anniversary',
                    'description' => $employee->name . ' - ' . $yearsEmployed . ' years',
                    'time' => 'All Day',
                    'employee' => $employee,
                    'priority' => 'low',
                    'url' => route('employees.show', $employee)
                ]);
            }
        }

        return $events->sortBy('priority');
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

        return [
            'expirations' => Contract::where('status', 'active')
                ->whereBetween('end_date', [$startOfMonth, $endOfMonth])
                ->count(),
            'renewals' => Contract::where('status', 'active')
                ->whereBetween('end_date', [$startOfMonth->copy()->addDays(30), $endOfMonth->copy()->addDays(30)])
                ->count(),
            'notifications' => Contract::where('status', 'active')
                ->whereBetween('end_date', [$startOfMonth->copy()->addDays(7), $endOfMonth->copy()->addDays(7)])
                ->count(),
        ];
    }

    public function render()
    {
        return view('livewire.calendar.index', [
            'upcomingEvents' => $this->upcomingEvents,
            'monthStats' => $this->monthStats,
        ]);
    }
}