<?php

namespace App\Livewire\Employees;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Employee;
use Livewire\Attributes\Url;

class Index extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';
    
    #[Url]
    public $status = '';
    
    #[Url]
    public $department = '';
    
    #[Url]
    public $sortBy = 'name';
    
    #[Url]
    public $sortDirection = 'asc';

    public $showFilters = false;
    public $selectedEmployees = [];
    public $selectAll = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'department' => ['except' => ''],
        'sortBy' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function updatedDepartment()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function updatedSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedEmployees = $this->employees->pluck('id')->toArray();
        } else {
            $this->selectedEmployees = [];
        }
    }

    public function deleteEmployee($employeeId)
    {
        $employee = Employee::find($employeeId);
        if ($employee) {
            $employee->delete();
            session()->flash('message', 'Employee deleted successfully.');
        }
    }

    public function bulkDelete()
    {
        if (!empty($this->selectedEmployees)) {
            Employee::whereIn('id', $this->selectedEmployees)->delete();
            $this->selectedEmployees = [];
            $this->selectAll = false;
            session()->flash('message', count($this->selectedEmployees) . ' employees deleted successfully.');
        }
    }

    public function getEmployeesProperty()
    {
        return Employee::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('employee_id', 'like', '%' . $this->search . '%')
                      ->orWhere('position', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->when($this->department, function ($query) {
                $query->where('department', $this->department);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);
    }

    public function getDepartmentsProperty()
    {
        return Employee::distinct('department')->pluck('department')->filter();
    }

    public function render()
    {
        return view('livewire.employees.index', [
            'employees' => $this->employees,
            'departments' => $this->departments,
        ]);
    }
}