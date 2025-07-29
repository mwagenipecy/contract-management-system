<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $stats = [
        'total_employees' => 0,
        'active_contracts' => 0,
        'expiring_soon' => 0,
        'expired_contracts' => 0,
        'pending_renewals' => 0,
        'total_penalties' => 0,
    ];

    public $recent_activities = [];
    public $upcoming_expirations = [];
    public $penalty_overview = [];
    public $contract_status_chart = [];

    public function mount()
    {
        $this->loadDashboardData();
    }

    private function loadDashboardData()
    {
        // Mock data for demonstration
        $this->stats = [
            'total_employees' => 145,
            'active_contracts' => 132,
            'expiring_soon' => 8,
            'expired_contracts' => 3,
            'pending_renewals' => 5,
            'total_penalties' => 2450.00,
        ];

        $this->recent_activities = [
            [
                'id' => 1,
                'type' => 'contract_renewed',
                'employee' => 'John Smith',
                'message' => 'Contract renewed for 2 years',
                'time' => '2 hours ago',
                'icon' => 'check-circle',
                'color' => 'green'
            ],
            [
                'id' => 2,
                'type' => 'expiry_warning',
                'employee' => 'Sarah Johnson',
                'message' => 'Contract expires in 3 days',
                'time' => '4 hours ago',
                'icon' => 'exclamation-triangle',
                'color' => 'yellow'
            ],
            [
                'id' => 3,
                'type' => 'penalty_applied',
                'employee' => 'Mike Davis',
                'message' => 'Penalty of $150 applied for late renewal',
                'time' => '1 day ago',
                'icon' => 'currency-dollar',
                'color' => 'red'
            ],
            [
                'id' => 4,
                'type' => 'new_employee',
                'employee' => 'Emily Wilson',
                'message' => 'New employee added with 3-year contract',
                'time' => '2 days ago',
                'icon' => 'user-plus',
                'color' => 'blue'
            ],
            [
                'id' => 5,
                'type' => 'contract_expired',
                'employee' => 'Robert Brown',
                'message' => 'Contract expired - action required',
                'time' => '3 days ago',
                'icon' => 'x-circle',
                'color' => 'red'
            ]
        ];

        $this->upcoming_expirations = [
            [
                'employee' => 'Sarah Johnson',
                'position' => 'Senior Developer',
                'expiry_date' => Carbon::now()->addDays(3)->format('M d, Y'),
                'days_left' => 3,
                'contract_type' => 'Full-time',
                'priority' => 'high'
            ],
            [
                'employee' => 'Alex Turner',
                'position' => 'Marketing Manager',
                'expiry_date' => Carbon::now()->addDays(7)->format('M d, Y'),
                'days_left' => 7,
                'contract_type' => 'Full-time',
                'priority' => 'medium'
            ],
            [
                'employee' => 'Lisa Chen',
                'position' => 'UX Designer',
                'expiry_date' => Carbon::now()->addDays(15)->format('M d, Y'),
                'days_left' => 15,
                'contract_type' => 'Contract',
                'priority' => 'low'
            ],
            [
                'employee' => 'David Wilson',
                'position' => 'Sales Representative',
                'expiry_date' => Carbon::now()->addDays(21)->format('M d, Y'),
                'days_left' => 21,
                'contract_type' => 'Part-time',
                'priority' => 'low'
            ]
        ];

        $this->penalty_overview = [
            [
                'employee' => 'Mike Davis',
                'position' => 'Software Engineer',
                'penalty_amount' => 150.00,
                'reason' => 'Late renewal (5 days)',
                'applied_date' => Carbon::now()->subDays(1)->format('M d, Y'),
                'status' => 'unpaid'
            ],
            [
                'employee' => 'Jennifer Garcia',
                'position' => 'Project Manager',
                'penalty_amount' => 300.00,
                'reason' => 'Late renewal (10 days)',
                'applied_date' => Carbon::now()->subDays(5)->format('M d, Y'),
                'status' => 'paid'
            ],
            [
                'employee' => 'Thomas Anderson',
                'position' => 'Data Analyst',
                'penalty_amount' => 200.00,
                'reason' => 'Late renewal (7 days)',
                'applied_date' => Carbon::now()->subDays(3)->format('M d, Y'),
                'status' => 'unpaid'
            ]
        ];

        $this->contract_status_chart = [
            ['status' => 'Active', 'count' => 132, 'color' => '#10B981'],
            ['status' => 'Expiring Soon', 'count' => 8, 'color' => '#F59E0B'],
            ['status' => 'Expired', 'count' => 3, 'color' => '#EF4444'],
            ['status' => 'Pending Renewal', 'count' => 5, 'color' => '#8B5CF6']
        ];
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}