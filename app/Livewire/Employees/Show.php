<?php

namespace App\Livewire\Employees;

use Livewire\Component;
use App\Models\Employee;

class Show extends Component
{
    public Employee $employee;

    public function mount(Employee $employee)
    {
        $this->employee = $employee->load(['contracts', 'penalties', 'notifications']);
    }

    public function render()
    {
        return view('livewire.employees.show');
    }
}