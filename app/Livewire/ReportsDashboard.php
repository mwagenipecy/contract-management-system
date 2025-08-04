<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;
use App\Models\Contract;
use App\Models\Promotion;
use App\Models\PromotionLog;
use App\Models\ReminderItem;
use App\Models\ReminderNotification;
use App\Models\Department;
use App\Models\Penalty;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportsDashboard extends Component
{
    public $dateRange = '30'; // Default to last 30 days
    public $selectedDepartment = 'all';
    public $refreshInterval = 30000; // 30 seconds

    public function mount()
    {
        $this->dateRange = '30';
        $this->selectedDepartment = 'all';
    }

    public function updatedDateRange()
    {
        $this->dispatch('refreshCharts');
    }

    public function updatedSelectedDepartment()
    {
        $this->dispatch('refreshCharts');
    }

    public function getEmployeeStatsProperty()
    {
        $query = Employee::query();
        
        if ($this->selectedDepartment !== 'all') {
            $query->where('department_id', $this->selectedDepartment);
        }

        $total = $query->count();
        $active = $query->where('status', 'active')->count();
        $inactive = $query->where('status', 'inactive')->count();

        return [
            'total' => $total,
            'active' => $active,
            'inactive' => $inactive,
            'active_percentage' => $total > 0 ? round(($active / $total) * 100, 1) : 0
        ];
    }

    public function getContractStatsProperty()
    {
        $now = Carbon::now();
        $query = Contract::query();

        if ($this->selectedDepartment !== 'all') {
            $query->whereHas('employee', function($q) {
                $q->where('department_id', $this->selectedDepartment);
            });
        }

        $total = $query->count();
        $active = $query->where('status', 'active')->count();
        $expiring = $query->where('status', 'active')
                         ->where('end_date', '<=', $now->copy()->addDays(30))
                         ->count();
        $expired = $query->where('end_date', '<', $now)->count();

        return [
            'total' => $total,
            'active' => $active,
            'expiring_soon' => $expiring,
            'expired' => $expired
        ];
    }

    public function getPromotionStatsProperty()
    {
        $days = (int) $this->dateRange;
        $startDate = Carbon::now()->subDays($days);
        
        $query = Promotion::where('created_at', '>=', $startDate);

        if ($this->selectedDepartment !== 'all') {
            $query->whereHas('employees', function($q) {
                $q->where('department_id', $this->selectedDepartment);
            });
        }

        $total = $query->count();
        $sent = PromotionLog::where('created_at', '>=', $startDate)
                           ->where('status', 'sent')
                           ->count();
        $failed = PromotionLog::where('created_at', '>=', $startDate)
                            ->where('status', 'failed')
                            ->count();

        return [
            'total' => $total,
            'sent' => $sent,
            'failed' => $failed,
            'success_rate' => ($sent + $failed) > 0 ? round(($sent / ($sent + $failed)) * 100, 1) : 0
        ];
    }

    public function getReminderStatsProperty()
    {
        $days = (int) $this->dateRange;
        $startDate = Carbon::now()->subDays($days);
        
        $total = ReminderItem::where('created_at', '>=', $startDate)->count();
        $pending = ReminderItem::where('status', 'pending')->count();
        $completed = ReminderItem::where('status', 'completed')
                                 ->where('updated_at', '>=', $startDate)
                                 ->count();
        $overdue = ReminderItem::where('due_date', '<', Carbon::now())
                              ->where('status', '!=', 'completed')
                              ->count();

        return [
            'total' => $total,
            'pending' => $pending,
            'completed' => $completed,
            'overdue' => $overdue
        ];
    }

    public function getPromotionTrendsProperty()
    {
        $days = (int) $this->dateRange;
        $startDate = Carbon::now()->subDays($days);
        
        $trends = PromotionLog::selectRaw('DATE(created_at) as date, 
                                         COUNT(*) as total,
                                         SUM(CASE WHEN status = "sent" THEN 1 ELSE 0 END) as sent,
                                         SUM(CASE WHEN status = "failed" THEN 1 ELSE 0 END) as failed')
                            ->where('created_at', '>=', $startDate)
                            ->groupBy('date')
                            ->orderBy('date')
                            ->get();

        return $trends->map(function($trend) {
            return [
                'date' => Carbon::parse($trend->date)->format('M d'),
                'total' => $trend->total,
                'sent' => $trend->sent,
                'failed' => $trend->failed,
                'success_rate' => $trend->total > 0 ? round(($trend->sent / $trend->total) * 100, 1) : 0
            ];
        });
    }

    public function getDepartmentBreakdownProperty()
    {
        $departments = Department::get()
                                ->map(function($dept) {
                                    return [
                                        'name' => "N/A",
                                        'employees' => 0,
                                        'contracts' => 0,
                                        'reminders' => 0
                                    ];
                                });

        return $departments;
    }

    public function getNotificationMethodsProperty()
    {
        $days = (int) $this->dateRange;
        $startDate = Carbon::now()->subDays($days);
        
        $methods = PromotionLog::selectRaw('type, COUNT(*) as count, 
                                          SUM(CASE WHEN status = "sent" THEN 1 ELSE 0 END) as sent')
                              ->where('created_at', '>=', $startDate)
                              ->groupBy('type')
                              ->get();

        return $methods->map(function($method) {
            return [
                'type' => ucfirst($method->type),
                'total' => $method->count,
                'sent' => $method->sent,
                'success_rate' => $method->count > 0 ? round(($method->sent / $method->count) * 100, 1) : 0
            ];
        });
    }

    public function getRecentAlertsProperty()
    {
        $alerts = collect();

        // Contract expiration alerts
        $expiringContracts = Contract::where('status', 'active')
                                   ->where('end_date', '<=', Carbon::now()->addDays(30))
                                   ->with('employee')
                                   ->limit(5)
                                   ->get();

        foreach ($expiringContracts as $contract) {
            $alerts->push([
                'type' => 'contract_expiry',
                'title' => 'Contract Expiring',
                'message' => $contract->employee->name . "'s contract expires on " . Carbon::parse($contract->end_date)->format('M d, Y'),
                'severity' => 'warning',
                'date' => $contract->end_date
            ]);
        }

        // Overdue reminders
        $overdueReminders = ReminderItem::where('due_date', '<', Carbon::now())
                                      ->where('status', '!=', 'completed')
                                      ->with('employee')
                                      ->limit(5)
                                      ->get();

        foreach ($overdueReminders as $reminder) {
            $alerts->push([
                'type' => 'overdue_reminder',
                'title' => 'Overdue Reminder',
                'message' => $reminder->title . ' is overdue for ' . ($reminder->employee->name ?? 'Unknown'),
                'severity' => 'danger',
                'date' => $reminder->due_date
            ]);
        }

        // Recent failed promotions
        $failedPromotions = PromotionLog::where('status', 'failed')
                                      ->where('created_at', '>=', Carbon::now()->subDays(7))
                                      ->with('promotion')
                                      ->limit(3)
                                      ->get();

        foreach ($failedPromotions as $failed) {
            $alerts->push([
                'type' => 'failed_promotion',
                'title' => 'Failed Notification',
                'message' => 'Failed to send ' . $failed->type . ' notification to ' . $failed->recipient,
                'severity' => 'danger',
                'date' => $failed->created_at
            ]);
        }

        return $alerts->sortByDesc('date')->take(10);
    }

    public function getDepartmentsProperty()
    {
        return Department::all();
    }

    public function render()
    {
        return view('livewire.reports-dashboard');
    }
}