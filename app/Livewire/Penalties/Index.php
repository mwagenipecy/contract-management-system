<?php

namespace App\Livewire\Penalties;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Penalty;
use App\Models\Employee;
use App\Models\Contract;
use Livewire\Attributes\Url;

class Index extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';
    
    #[Url]
    public $status = '';
    
    #[Url]
    public $employee_id = '';
    
    #[Url]
    public $sortBy = 'applied_date';
    
    #[Url]
    public $sortDirection = 'desc';

    public $selectedPenalties = [];
    public $selectAll = false;

    // Modal properties
    public $showCreateModal = false;
    public $showPaymentModal = false;
    public $selectedPenaltyId = null;
    public $paymentAmount = '';
    public $paymentNotes = '';

    // Create penalty form
    public $newPenalty = [
        'employee_id' => '',
        'contract_id' => '',
        'amount' => '',
        'type' => 'fixed',
        'reason' => '',
        'days_overdue' => 0,
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'employee_id' => ['except' => ''],
        'sortBy' => ['except' => 'applied_date'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function updatedSearch()
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
            $this->selectedPenalties = $this->penalties->pluck('id')->toArray();
        } else {
            $this->selectedPenalties = [];
        }
    }

    public function openCreateModal()
    {
        $this->showCreateModal = true;
        $this->resetNewPenalty();
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->resetNewPenalty();
    }

    public function resetNewPenalty()
    {
        $this->newPenalty = [
            'employee_id' => '',
            'contract_id' => '',
            'amount' => '',
            'type' => 'fixed',
            'reason' => '',
            'days_overdue' => 0,
        ];
    }

    public function createPenalty()
    {
        $this->validate([
            'newPenalty.employee_id' => 'required|exists:employees,id',
            'newPenalty.contract_id' => 'required|exists:contracts,id',
            'newPenalty.amount' => 'required|numeric|min:0',
            'newPenalty.type' => 'required|in:fixed,daily',
            'newPenalty.reason' => 'required|string|max:255',
            'newPenalty.days_overdue' => 'required|integer|min:0',
        ]);

        Penalty::create([
            'employee_id' => $this->newPenalty['employee_id'],
            'contract_id' => $this->newPenalty['contract_id'],
            'amount' => $this->newPenalty['amount'],
            'currency' => 'USD',
            'type' => $this->newPenalty['type'],
            'reason' => $this->newPenalty['reason'],
            'applied_date' => now(),
            'days_overdue' => $this->newPenalty['days_overdue'],
            'status' => 'pending',
            'created_by' => auth()->id(),
        ]);

        $this->closeCreateModal();
        session()->flash('message', 'Penalty created successfully.');
    }

    public function openPaymentModal($penaltyId)
    {
        $this->selectedPenaltyId = $penaltyId;
        $penalty = Penalty::find($penaltyId);
        $this->paymentAmount = $penalty->amount;
        $this->showPaymentModal = true;
    }

    public function closePaymentModal()
    {
        $this->showPaymentModal = false;
        $this->selectedPenaltyId = null;
        $this->paymentAmount = '';
        $this->paymentNotes = '';
    }

    public function recordPayment()
    {
        $this->validate([
            'paymentAmount' => 'required|numeric|min:0',
            'paymentNotes' => 'nullable|string|max:500',
        ]);

        $penalty = Penalty::find($this->selectedPenaltyId);
        if ($penalty) {
            $penalty->update([
                'status' => 'paid',
                'paid_date' => now(),
                'paid_amount' => $this->paymentAmount,
                'notes' => $this->paymentNotes,
            ]);

            $this->closePaymentModal();
            session()->flash('message', 'Payment recorded successfully.');
        }
    }

    public function waivePenalty($penaltyId)
    {
        $penalty = Penalty::find($penaltyId);
        if ($penalty) {
            $penalty->update([
                'status' => 'waived',
                'notes' => 'Penalty waived by ' . auth()->user()->name,
            ]);
            session()->flash('message', 'Penalty waived successfully.');
        }
    }

    public function bulkWaive()
    {
        if (!empty($this->selectedPenalties)) {
            Penalty::whereIn('id', $this->selectedPenalties)->update([
                'status' => 'waived',
                'notes' => 'Bulk waived by ' . auth()->user()->name,
            ]);
            $count = count($this->selectedPenalties);
            $this->selectedPenalties = [];
            $this->selectAll = false;
            session()->flash('message', $count . ' penalties waived successfully.');
        }
    }

    public function bulkDelete()
    {
        if (!empty($this->selectedPenalties)) {
            Penalty::whereIn('id', $this->selectedPenalties)->delete();
            $count = count($this->selectedPenalties);
            $this->selectedPenalties = [];
            $this->selectAll = false;
            session()->flash('message', $count . ' penalties deleted successfully.');
        }
    }

    public function getPenaltiesProperty()
    {
        return Penalty::query()
            ->with(['employee', 'contract'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('reason', 'like', '%' . $this->search . '%')
                      ->orWhereHas('employee', function ($eq) {
                          $eq->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('employee_id', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
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

    public function getContractsProperty()
    {
        if ($this->newPenalty['employee_id']) {
            return Contract::where('employee_id', $this->newPenalty['employee_id'])->orderBy('created_at', 'desc')->get();
        }
        return collect();
    }

    public function getStatsProperty()
    {
        return [
            'total_penalties' => Penalty::count(),
            'pending_amount' => Penalty::where('status', 'pending')->sum('amount'),
            'paid_amount' => Penalty::where('status', 'paid')->sum('paid_amount'),
            'waived_count' => Penalty::where('status', 'waived')->count(),
        ];
    }

    public function render()
    {
        return view('livewire.penalties.index', [
            'penalties' => $this->penalties,
            'employees' => $this->employees,
            'contracts' => $this->contracts,
            'stats' => $this->stats,
        ]);
    }



}