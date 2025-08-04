<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            [
                'name' => 'Human Resources',
                'description' => 'Manages recruitment, training, and benefits',
                'manager_id' => 1,
                'budget' => 100000,
                'status' => 'active',
            ],
            [
                'name' => 'Finance',
                'description' => 'Handles financial planning and reporting',
                'manager_id' => 2,
                'budget' => 200000,
                'status' => 'active',
            ],
            [
                'name' => 'IT',
                'description' => 'Oversees tech infrastructure and support',
                'manager_id' => 3,
                'budget' => 300000,
                'status' => 'active',
            ],
            [
                'name' => 'Marketing',
                'description' => 'Promotes brand and generates leads',
                'manager_id' => 4,
                'budget' => 150000,
                'status' => 'active',
            ],
            [
                'name' => 'Sales',
                'description' => 'Converts leads into revenue',
                'manager_id' => 5,
                'budget' => 250000,
                'status' => 'active',
            ],
            [
                'name' => 'Customer Service',
                'description' => 'Supports customers post-sale',
                'manager_id' => 6,
                'budget' => 80000,
                'status' => 'active',
            ],
            [
                'name' => 'Research & Development',
                'description' => 'Innovates and develops new products',
                'manager_id' => 7,
                'budget' => 350000,
                'status' => 'active',
            ],
            [
                'name' => 'Operations',
                'description' => 'Manages daily business processes',
                'manager_id' => 8,
                'budget' => 180000,
                'status' => 'active',
            ],
            [
                'name' => 'Legal',
                'description' => 'Ensures compliance and manages contracts',
                'manager_id' => 9,
                'budget' => 120000,
                'status' => 'active',
            ],
            [
                'name' => 'Procurement',
                'description' => 'Handles purchasing and vendor relations',
                'manager_id' => 10,
                'budget' => 90000,
                'status' => 'active',
            ],
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }
    }
}


