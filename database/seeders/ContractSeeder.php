<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contract;
use App\Models\Employee;
use Carbon\Carbon;

class ContractSeeder extends Seeder
{
    public function run()
    {
        $employees = Employee::all();

        foreach ($employees as $employee) {
            // Create initial contract
            $startDate = $employee->hire_date;
            $endDate = $startDate->copy()->addYears(2);
            
            // Determine contract status based on expiry
            $status = 'active';
            if ($endDate < Carbon::now()) {
                $status = 'expired';
            } elseif ($endDate <= Carbon::now()->addDays(30)) {
                $status = 'active'; // expiring soon but still active
            }

            Contract::create([
                'employee_id' => $employee->id,
                'contract_number' => 'CNT' . str_pad($employee->id, 4, '0', STR_PAD_LEFT),
                'contract_type' => 'full_time',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'salary' => rand(50000, 120000),
                'currency' => 'USD',
                'status' => $status,
                'terms_and_conditions' => 'Standard employment terms and conditions apply.',
                'renewal_notice_period' => 30,
                'auto_renewal' => false,
                'created_by' => 1,
                'approved_by' => 1,
                'approved_at' => $startDate,
            ]);
        }

        // Create some specific scenarios for demo
        
        // Contract expiring in 3 days
        $sarah = Employee::where('name', 'Sarah Johnson')->first();
        if ($sarah && $sarah->contracts()->count() > 0) {
            $sarah->contracts()->first()->update([
                'end_date' => Carbon::now()->addDays(3),
            ]);
        }

        // Contract expiring in 7 days
        $alex = Employee::where('name', 'Alex Turner')->first();
        if ($alex && $alex->contracts()->count() > 0) {
            $alex->contracts()->first()->update([
                'end_date' => Carbon::now()->addDays(7),
            ]);
        }

        // Contract expiring in 15 days
        $lisa = Employee::where('name', 'Lisa Chen')->first();
        if ($lisa && $lisa->contracts()->count() > 0) {
            $lisa->contracts()->first()->update([
                'end_date' => Carbon::now()->addDays(15),
            ]);
        }

        // Expired contract (for penalty demo)
        $robert = Employee::where('name', 'Robert Brown')->first();
        if ($robert && $robert->contracts()->count() > 0) {
            $robert->contracts()->first()->update([
                'end_date' => Carbon::now()->subDays(5),
                'status' => 'expired',
            ]);
        }

        // Another expired contract
        $mike = Employee::where('name', 'Mike Davis')->first();
        if ($mike && $mike->contracts()->count() > 0) {
            $mike->contracts()->first()->update([
                'end_date' => Carbon::now()->subDays(1),
                'status' => 'expired',
            ]);
        }
    }
}
