<?php

namespace App\Livewire\Contracts;

use Livewire\Component;
use App\Models\Contract;
use App\Models\ContractRenewal;
use Carbon\Carbon;

class Renew extends Component
{
    public Contract $contract;
    
    // Original contract details
    public $original_end_date;
    public $original_salary;
    public $original_terms;
    
    // Renewal form fields
    public $new_end_date = '';
    public $new_salary = '';
    public $salary_increase_percentage = 0;
    public $new_terms_and_conditions = '';
    public $renewal_type = 'extend'; // extend, new_terms, salary_adjustment
    public $renewal_period_years = 2;
    public $renewal_period_months = 0;
    public $renewal_notes = '';
    public $auto_renewal = false;
    public $renewal_notice_period = 30;

    // Calculated fields
    public $salary_difference = 0;
    public $new_duration_days = 0;

    protected function rules()
    {
        return [
            'new_end_date' => 'required|date|after:' . $this->contract->end_date->format('Y-m-d'),
            'new_salary' => 'required|numeric|min:0',
            'new_terms_and_conditions' => 'nullable|string|max:2000',
            'renewal_notes' => 'nullable|string|max:500',
            'renewal_notice_period' => 'required|integer|min:1|max:365',
            'salary_increase_percentage' => 'nullable|numeric|min:-100|max:1000',
        ];
    }

    public function mount(Contract $contract)
    {
        $this->contract = $contract->load('employee');
        
        // Store original values
        $this->original_end_date = $this->contract->end_date->format('Y-m-d');
        $this->original_salary = $this->contract->salary;
        $this->original_terms = $this->contract->terms_and_conditions;
        
        // Set default renewal values
        $this->new_salary = $this->contract->salary;
        $this->new_terms_and_conditions = $this->contract->terms_and_conditions;
        $this->renewal_notice_period = $this->contract->renewal_notice_period;
        $this->auto_renewal = $this->contract->auto_renewal;
        
        // Calculate default new end date (extend by 2 years)
        $this->calculateNewEndDate();
    }

    public function updatedRenewalPeriodYears()
    {
        $this->calculateNewEndDate();
    }

    public function updatedRenewalPeriodMonths()
    {
        $this->calculateNewEndDate();
    }

    public function updatedSalaryIncreasePercentage()
    {
        if ($this->salary_increase_percentage) {
            $this->new_salary = $this->original_salary * (1 + ($this->salary_increase_percentage / 100));
            $this->calculateSalaryDifference();
        }
    }

    public function updatedNewSalary()
    {
        $this->calculateSalaryDifference();
        $this->calculateSalaryIncreasePercentage();
    }

    public function updatedNewEndDate()
    {
        $this->calculateDuration();
    }

    private function calculateNewEndDate()
    {
        $baseDate = $this->contract->end_date;
        $newDate = $baseDate->copy()
            ->addYears($this->renewal_period_years)
            ->addMonths($this->renewal_period_months);
        
        $this->new_end_date = $newDate->format('Y-m-d');
        $this->calculateDuration();
    }

    private function calculateSalaryDifference()
    {
        $this->salary_difference = $this->new_salary - $this->original_salary;
    }

    private function calculateSalaryIncreasePercentage()
    {
        if ($this->original_salary > 0) {
            $this->salary_increase_percentage = (($this->new_salary - $this->original_salary) / $this->original_salary) * 100;
        }
    }

    private function calculateDuration()
    {
        if ($this->new_end_date) {
            $startDate = $this->contract->end_date;
            $endDate = Carbon::parse($this->new_end_date);
            $this->new_duration_days = $startDate->diffInDays($endDate);
        }
    }

    public function setRenewalType($type)
    {
        $this->renewal_type = $type;
        
        if ($type === 'extend') {
            // Simple extension - keep same terms and salary
            $this->new_salary = $this->original_salary;
            $this->new_terms_and_conditions = $this->original_terms;
            $this->salary_increase_percentage = 0;
        } elseif ($type === 'salary_adjustment') {
            // Focus on salary changes
            $this->new_terms_and_conditions = $this->original_terms;
        }
        
        $this->calculateSalaryDifference();
    }

    public function applySalaryIncrease($percentage)
    {
        $this->salary_increase_percentage = $percentage;
        $this->new_salary = $this->original_salary * (1 + ($percentage / 100));
        $this->calculateSalaryDifference();
    }

    public function renewContract()
    {
        $this->validate();

        // Create renewal record
        $renewal = ContractRenewal::create([
            'contract_id' => $this->contract->id,
            'old_end_date' => $this->contract->end_date,
            'new_end_date' => $this->new_end_date,
            'old_salary' => $this->contract->salary,
            'new_salary' => $this->new_salary,
            'renewal_date' => now(),
            'renewal_notes' => $this->renewal_notes,
            'created_by' => auth()->id(),
        ]);

        // Update contract
        $this->contract->update([
            'end_date' => $this->new_end_date,
            'salary' => $this->new_salary,
            'terms_and_conditions' => $this->new_terms_and_conditions,
            'renewal_notice_period' => $this->renewal_notice_period,
            'auto_renewal' => $this->auto_renewal,
            'status' => 'active',
        ]);

        session()->flash('message', 'Contract renewed successfully!');
        
        return redirect()->route('contracts.show', $this->contract);
    }

    public function render()
    {
        return view('livewire.contracts.renew')->layout('layouts.app');
    }
}