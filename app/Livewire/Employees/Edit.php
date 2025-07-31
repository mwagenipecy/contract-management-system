<?php

namespace App\Livewire\Employees;

use Livewire\Component;
use App\Models\Employee;
use Illuminate\Validation\Rule;

class Edit extends Component
{
    public Employee $employee;
    
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
            'employee_id' => ['required', 'string', Rule::unique('employees', 'employee_id')->ignore($this->employee->id)],
            'name' => 'required|string|min:2|max:255',
            'email' => ['required', 'email', Rule::unique('employees', 'email')->ignore($this->employee->id)],
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

    public function mount(Employee $employee)
    {
        $this->employee = $employee;
        
        // Populate form fields with existing data
        $this->employee_id = $employee->employee_id;
        $this->name = $employee->name;
        $this->email = $employee->email;
        $this->phone = $employee->phone;
        $this->position = $employee->position;
        $this->department = $employee->department;
        $this->hire_date = $employee->hire_date->format('Y-m-d');
        $this->status = $employee->status;
        $this->address = $employee->address;
        $this->emergency_contact_name = $employee->emergency_contact_name;
        $this->emergency_contact_phone = $employee->emergency_contact_phone;
    }

    public function update()
    {
        $this->validate();

        $this->employee->update([
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

        session()->flash('message', 'Employee updated successfully!');
        
        return redirect()->route('employees.show', $this->employee);
        
    }

    public function render()
    {
        return view('livewire.employees.edit');

    }


}