<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use Carbon\Carbon;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        $employees = [
            [
                'employee_id' => 'EMP001',
                'name' => 'John Smith',
                'email' => 'john.smith@company.com',
                'phone' => '+1234567890',
                'position' => 'Software Engineer',
                'department' => 'Engineering',
                'hire_date' => Carbon::now()->subYears(2),
                'status' => 'active',
            ],
            [
                'employee_id' => 'EMP002',
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@company.com',
                'phone' => '+1234567891',
                'position' => 'Senior Developer',
                'department' => 'Engineering',
                'hire_date' => Carbon::now()->subYears(3),
                'status' => 'active',
            ],
            [
                'employee_id' => 'EMP003',
                'name' => 'Mike Davis',
                'email' => 'mike.davis@company.com',
                'phone' => '+1234567892',
                'position' => 'Software Engineer',
                'department' => 'Engineering',
                'hire_date' => Carbon::now()->subYears(1),
                'status' => 'active',
            ],
            [
                'employee_id' => 'EMP004',
                'name' => 'Emily Wilson',
                'email' => 'emily.wilson@company.com',
                'phone' => '+1234567893',
                'position' => 'Product Manager',
                'department' => 'Product',
                'hire_date' => Carbon::now()->subMonths(6),
                'status' => 'active',
            ],
            [
                'employee_id' => 'EMP005',
                'name' => 'Robert Brown',
                'email' => 'robert.brown@company.com',
                'phone' => '+1234567894',
                'position' => 'Sales Representative',
                'department' => 'Sales',
                'hire_date' => Carbon::now()->subYears(2),
                'status' => 'active',
            ],
            [
                'employee_id' => 'EMP006',
                'name' => 'Alex Turner',
                'email' => 'alex.turner@company.com',
                'phone' => '+1234567895',
                'position' => 'Marketing Manager',
                'department' => 'Marketing',
                'hire_date' => Carbon::now()->subYears(1),
                'status' => 'active',
            ],
            [
                'employee_id' => 'EMP007',
                'name' => 'Lisa Chen',
                'email' => 'lisa.chen@company.com',
                'phone' => '+1234567896',
                'position' => 'UX Designer',
                'department' => 'Design',
                'hire_date' => Carbon::now()->subMonths(8),
                'status' => 'active',
            ],
            [
                'employee_id' => 'EMP008',
                'name' => 'David Wilson',
                'email' => 'david.wilson@company.com',
                'phone' => '+1234567897',
                'position' => 'Sales Representative',
                'department' => 'Sales',
                'hire_date' => Carbon::now()->subYears(1),
                'status' => 'active',
            ],
            [
                'employee_id' => 'EMP009',
                'name' => 'Jennifer Garcia',
                'email' => 'jennifer.garcia@company.com',
                'phone' => '+1234567898',
                'position' => 'Project Manager',
                'department' => 'Operations',
                'hire_date' => Carbon::now()->subYears(2),
                'status' => 'active',
            ],
            [
                'employee_id' => 'EMP010',
                'name' => 'Thomas Anderson',
                'email' => 'thomas.anderson@company.com',
                'phone' => '+1234567899',
                'position' => 'Data Analyst',
                'department' => 'Analytics',
                'hire_date' => Carbon::now()->subMonths(10),
                'status' => 'active',
            ],
        ];

        foreach ($employees as $employee) {
            Employee::create($employee);
        }
    }
}
