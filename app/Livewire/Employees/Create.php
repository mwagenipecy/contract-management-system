<?php

namespace App\Livewire\Employees;

use Livewire\Component;
use App\Models\Employee;
use Illuminate\Validation\Rule;

class Create extends Component
{
    public $employee_id = '';
    public $name = '';
    public $email = '';
    public $phone = '';
    public $position = '';
    public $department = '';
    public $hire_date = '';
    public $status = 'active';
    public $address = '';
    public $emergency_contact_name = '';
    public $emergency_contact_phone = '';

    protected function rules()
    {
        return [
            'employee_id' => 'required|string|unique:employees,employee_id',
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'nullable|string|max:20',
            'position' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'hire_date' => 'required|date|before_or_equal:today',
            'status' => 'required|in:active,inactive,terminated',
            'address' => 'nullable|string|max:500',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
        ];
    }

    protected $validationAttributes = [
        'employee_id' => 'employee ID',
        'hire_date' => 'hire date',
        'emergency_contact_name' => 'emergency contact name',
        'emergency_contact_phone' => 'emergency contact phone',
    ];

    public function mount()
    {
        // Set default hire date to today
        $this->hire_date = now()->format('Y-m-d');
        
        // Generate a suggested employee ID (can be customized)
        $this->employee_id = $this->generateEmployeeId();
    }

    public function store()
    {
        $this->validate();

        $employee = Employee::create([
            'employee_id' => $this->employee_id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'position' => $this->position,
            'department' => $this->department,
            'hire_date' => $this->hire_date,
            'status' => $this->status,
            'address' => $this->address,
            'emergency_contact_name' => $this->emergency_contact_name,
            'emergency_contact_phone' => $this->emergency_contact_phone,
        ]);

        session()->flash('message', 'Employee created successfully!');
        

           // Dispatch SMS notification
    dispatch(new \App\Jobs\SendSmsNotification(
        $employee->phone,
        "Welcome to the team, {$employee->name}! Your employee ID is {$employee->employee_id}. We're excited to have you join us in the {$employee->department} department."
    ));

    // Dispatch Email notification
    dispatch(new \App\Jobs\SendEmailNotification(
        $employee->email,
        $employee->name,
        'Welcome to Our Company',
        [
            'employee' => $employee,
            'welcome_message' => 'We are thrilled to welcome you to our team!',
            'start_date' => $employee->hire_date,
        ]
    ));


    
        return redirect()->route('employees.show', $employee);
    }

    public function generateEmployeeId()
    {
        // Generate employee ID format: EMP + year + sequential number
        $year = date('Y');
        $lastEmployee = Employee::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();
        
        $nextNumber = $lastEmployee ? 
            (int)substr($lastEmployee->employee_id, -4) + 1 : 1;
        
        return 'EMP' . $year . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    public function refreshEmployeeId()
    {
        $this->employee_id = $this->generateEmployeeId();
    }

    public function render()
    {
        return view('livewire.employees.create');
    }
}