<?php

namespace App\Livewire\Contracts;

use Livewire\Component;
use App\Models\Contract;
use App\Models\Employee;
use Illuminate\Validation\Rule;

class Create extends Component
{
    public $employee_id = '';
    public $contract_number = '';
    public $contract_type = 'full_time';
    public $start_date = '';
    public $end_date = '';
    public $salary = '';
    public $currency = 'USD';
    public $status = 'draft';
    public $terms_and_conditions = '';
    public $renewal_notice_period = 30;
    public $auto_renewal = false;

    public $selectedEmployee = null;

    protected function rules()
    {
        return [
            'employee_id' => 'required|exists:employees,id',
            'contract_number' => 'required|string|unique:contracts,contract_number',
            'contract_type' => 'required|in:full_time,part_time,contract,internship',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'salary' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'status' => 'required|in:draft,active,expired,terminated,pending_renewal',
            'terms_and_conditions' => 'nullable|string|max:2000',
            'renewal_notice_period' => 'required|integer|min:1|max:365',
            'auto_renewal' => 'boolean',
        ];
    }

    protected $validationAttributes = [
        'employee_id' => 'employee',
        'contract_number' => 'contract number',
        'contract_type' => 'contract type',
        'start_date' => 'start date',
        'end_date' => 'end date',
        'terms_and_conditions' => 'terms and conditions',
        'renewal_notice_period' => 'renewal notice period',
        'auto_renewal' => 'auto renewal',
    ];

    public function mount()
    {
        // Auto-generate contract number
        $lastContract = Contract::latest('id')->first();
        $nextId = $lastContract ? (int)substr($lastContract->contract_number, 3) + 1 : 1;
        $this->contract_number = 'CNT' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
        
        // Set default dates
        $this->start_date = date('Y-m-d');
        $this->end_date = date('Y-m-d', strtotime('+2 years'));

        // Set default terms
        $this->terms_and_conditions = 'Standard employment terms and conditions apply. This contract is subject to company policies and procedures.';

        // Check if employee_id is passed via query parameter
        if (request()->has('employee_id')) {
            $this->employee_id = request('employee_id');
            $this->updatedEmployeeId();
        }
    }

    public function updatedEmployeeId()
    {
        if ($this->employee_id) {
            $this->selectedEmployee = Employee::find($this->employee_id);
            
            // Set default salary based on position (you can customize this logic)
            $defaultSalaries = [
                'Software Engineer' => 80000,
                'Senior Developer' => 120000,
                'Product Manager' => 110000,
                'Marketing Manager' => 90000,
                'Sales Representative' => 60000,
                'UX Designer' => 85000,
                'Project Manager' => 95000,
                'Data Analyst' => 75000,
            ];

            if ($this->selectedEmployee && isset($defaultSalaries[$this->selectedEmployee->position])) {
                $this->salary = $defaultSalaries[$this->selectedEmployee->position];
            }
        } else {
            $this->selectedEmployee = null;
        }
    }

    public function updatedStartDate()
    {
        if ($this->start_date) {
            // Auto-set end date to 2 years from start date
            $this->end_date = date('Y-m-d', strtotime($this->start_date . ' +2 years'));
        }
    }

    public function save()
    {
        $this->validate();

        $contract = Contract::create([
            'employee_id' => $this->employee_id,
            'contract_number' => $this->contract_number,
            'contract_type' => $this->contract_type,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'salary' => $this->salary,
            'currency' => $this->currency,
            'status' => $this->status,
            'terms_and_conditions' => $this->terms_and_conditions,
            'renewal_notice_period' => $this->renewal_notice_period,
            'auto_renewal' => $this->auto_renewal,
            'created_by' => auth()->id(),
        ]);


         // Get the employee for notifications
    $employee = Employee::find($this->employee_id);

    // Send contract creation notification
    dispatch(new \App\Jobs\SendEmployeeNotification(
        $employee,
        'contract_created',
        'Contract Created',
        [
            'contract' => $contract,
            'message' => 'Your new contract has been created and is now active.',
        ]
    ));

        // Schedule contract renewal notification if applicable
    if ($contract->end_date && $contract->renewal_notice_period) {
        $notificationDate = \Carbon\Carbon::parse($contract->end_date)
            ->subDays($contract->renewal_notice_period);

        if ($notificationDate->isFuture()) {
            dispatch(new \App\Jobs\SendEmployeeNotification(
                $employee,
                'contract_renewal_reminder',
                'Contract Renewal Reminder',
                [
                    'contract' => $contract,
                    'days_until_expiry' => $contract->renewal_notice_period,
                ]
            ))->delay($notificationDate);
        }
    }

    
    // Notify HR/Admin about contract creation
    $hrUsers = \App\Models\User::where('id', 1)->get();
    foreach ($hrUsers as $hrUser) {
        dispatch(new \App\Jobs\SendAdminNotification(
            $hrUser,
            'contract_created_admin',
            'New Contract Created',
            [
                'contract' => $contract,
                'employee' => $employee,
                'created_by' => auth()->user()->name,
            ]
        ));
    }

    session()->flash('message', 'Contract created successfully! Notifications have been sent.');
    


        
        return redirect()->route('contracts.show', $contract);
    }

    public function getEmployeesProperty()
    {
        return Employee::orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.contracts.create', [
            'employees' => $this->employees,
        ]);
    }
}