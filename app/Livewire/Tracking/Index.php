<?php

namespace App\Livewire\Tracking;

use Livewire\Component;
use App\Models\Contract;
use App\Models\Employee;
use Carbon\Carbon;

class Index extends Component
{
    public $selectedTab = 'expiring_soon';
    public $filterDays = 30;

    public function setTab($tab)
    {
        $this->selectedTab = $tab;
    }

    public function getExpiringContractsProperty()
    {
        return Contract::with('employee')
            ->where('status', 'active')
            ->where('end_date', '<=', Carbon::now()->addDays($this->filterDays))
            ->where('end_date', '>=', Carbon::now())
            ->orderBy('end_date', 'asc')
            ->get();
    }

    public function getExpiredContractsProperty()
    {
        return Contract::with('employee')
            ->where('end_date', '<', Carbon::now())
            ->whereIn('status', ['active', 'expired'])
            ->orderBy('end_date', 'desc')
            ->get();
    }

    public function getPendingRenewalsProperty()
    {
        return Contract::with('employee')
            ->where('status', 'pending_renewal')
            ->orderBy('end_date', 'asc')
            ->get();
    }

    public function getUpcomingStartsProperty()
    {
        return Contract::with('employee')
            ->where('start_date', '>', Carbon::now())
            ->where('status', 'active')
            ->orderBy('start_date', 'asc')
            ->get();
    }

    public function getStatsProperty()
    {
        return [
            'expiring_7_days' => Contract::expiring(7)->count(),
            'expiring_30_days' => Contract::expiring(30)->count(),
            'expired_total' => Contract::expired()->count(),
            'pending_renewals' => Contract::pendingRenewal()->count(),
        ];
    }

    public function markForRenewal($contractId)
    {
        $contract = Contract::find($contractId);
        if ($contract) {
            $contract->update(['status' => 'pending_renewal']);
            session()->flash('message', 'Contract marked for renewal successfully.');
        }
    }

    public function extendContract($contractId)
    {
        $contract = Contract::find($contractId);
        if ($contract) {
            // Extend by 1 year
            $contract->update([
                'end_date' => $contract->end_date->addYear(),
                'status' => 'active'
            ]);
            session()->flash('message', 'Contract extended by 1 year successfully.');
        }
    }

    public function render()
    {
        return view('livewire.tracking.index', [
            'expiringContracts' => $this->expiringContracts,
            'expiredContracts' => $this->expiredContracts,
            'pendingRenewals' => $this->pendingRenewals,
            'upcomingStarts' => $this->upcomingStarts,
            'stats' => $this->stats,
        ]);
    }
}