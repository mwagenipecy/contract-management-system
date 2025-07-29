<?php

namespace App\Livewire\Contracts;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Contract;
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
    public $contract_type = '';
    
    #[Url]
    public $employee_id = '';
    
    #[Url]
    public $sortBy = 'created_at';
    
    #[Url]
    public $sortDirection = 'desc';

    public $showFilters = false;
    public $selectedContracts = [];
    public $selectAll = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'contract_type' => ['except' => ''],
        'employee_id' => ['except' => ''],
        'sortBy' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function updatedContractType()
    {
        $this->resetPage();
    }

    public function updatedEmployeeId()
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
            $this->selectedContracts = $this->contracts->pluck('id')->toArray();
        } else {
            $this->selectedContracts = [];
        }
    }

    public function deleteContract($contractId)
    {
        $contract = Contract::find($contractId);
        if ($contract) {
            $contract->delete();
            session()->flash('message', 'Contract deleted successfully.');
        }
    }

    public function bulkDelete()
    {
        if (!empty($this->selectedContracts)) {
            Contract::whereIn('id', $this->selectedContracts)->delete();
            $count = count($this->selectedContracts);
            $this->selectedContracts = [];
            $this->selectAll = false;
            session()->flash('message', $count . ' contracts deleted successfully.');
        }
    }

    public function bulkActivate()
    {
        if (!empty($this->selectedContracts)) {
            Contract::whereIn('id', $this->selectedContracts)->update(['status' => 'active']);
            $count = count($this->selectedContracts);
            $this->selectedContracts = [];
            $this->selectAll = false;
            session()->flash('message', $count . ' contracts activated successfully.');
        }
    }

    public function getContractsProperty()
    {
        return Contract::query()
            ->with(['employee'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('contract_number', 'like', '%' . $this->search . '%')
                      ->orWhereHas('employee', function ($eq) {
                          $eq->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('employee_id', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->when($this->contract_type, function ($query) {
                $query->where('contract_type', $this->contract_type);
            })
            ->when($this->employee_id, function ($query) {
                $query->where('employee_id', $this->employee_id);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);
    }

    public function getEmployeesProperty()
    {
        return Employee::orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.contracts.index', [
            'contracts' => $this->contracts,
            'employees' => $this->employees,
        ]);
    }
}