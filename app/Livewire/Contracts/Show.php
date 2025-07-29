<?php

namespace App\Livewire\Contracts;

use Livewire\Component;
use App\Models\Contract;

class Show extends Component
{
    public Contract $contract;
    public $showDeleteModal = false;

    public function mount(Contract $contract)
    {
        $this->contract = $contract->load([
            'employee', 
            'createdBy', 
            'approvedBy', 
            'renewals.createdBy', 
            'penalties',
            'employee.notifications' => function($query) {
                $query->where('contract_id', $this->contract->id)->latest()->take(5);
            }
        ]);
    }

    public function activateContract()
    {
        if ($this->contract->status === 'draft') {
            $this->contract->update([
                'status' => 'active',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);
            session()->flash('message', 'Contract activated successfully.');
        }
    }

    public function suspendContract()
    {
        if ($this->contract->status === 'active') {
            $this->contract->update(['status' => 'terminated']);
            session()->flash('message', 'Contract suspended successfully.');
        }
    }

    public function openDeleteModal()
    {
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
    }

    public function deleteContract()
    {
        $this->contract->delete();
        $this->closeDeleteModal();
        session()->flash('message', 'Contract deleted successfully.');
        return redirect()->route('contracts.index');
    }

    public function exportContract()
    {
        // In a real application, you would generate a PDF or document here
        session()->flash('message', 'Contract export functionality would be implemented here.');
    }

    public function render()
    {
        return view('livewire.contracts.show');
    }
}