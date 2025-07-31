<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReminderCategory;
use App\Models\ReminderItem;
use App\Models\User;
use Carbon\Carbon;

class ReminderSystemSeeder extends Seeder
{
    public function run()
    {
        // Create default categories based on your company requirements
        $categories = [
            [
                'name' => 'Government Licenses',
                'slug' => 'government-licenses',
                'description' => 'All government license renewals and payments',
                'icon' => 'shield-check',
                'color' => '#ef4444', // Red
                'default_notification_periods' => [60, 30, 7, 1],
                'sort_order' => 1,
            ],
            [
                'name' => 'Airport Licenses',
                'slug' => 'airport-licenses',
                'description' => 'TAA, KIA and other airport-related licenses',
                'icon' => 'globe',
                'color' => '#f59e0b', // Orange
                'default_notification_periods' => [90, 60, 30, 7],
                'sort_order' => 2,
            ],
            [
                'name' => 'Staff Welfare',
                'slug' => 'staff-welfare',
                'description' => 'Employee welfare initiatives and benefits',
                'icon' => 'heart',
                'color' => '#10b981', // Green
                'default_notification_periods' => [30, 14, 7, 1],
                'sort_order' => 3,
            ],
            [
                'name' => 'Employment Contracts',
                'slug' => 'employment-contracts',
                'description' => 'Employee contract renewals and reviews',
                'icon' => 'document-text',
                'color' => '#3b82f6', // Blue
                'default_notification_periods' => [60, 30, 14, 7],
                'sort_order' => 4,
            ],
            [
                'name' => 'Foreign Staff Permits',
                'slug' => 'foreign-staff-permits',
                'description' => 'Work and residence permits for foreign employees',
                'icon' => 'users',
                'color' => '#8b5cf6', // Purple
                'default_notification_periods' => [90, 60, 30, 14, 7],
                'sort_order' => 5,
            ],
            [
                'name' => 'Vendor Contracts',
                'slug' => 'vendor-contracts',
                'description' => 'Supplier and vendor contract management',
                'icon' => 'truck',
                'color' => '#06b6d4', // Cyan
                'default_notification_periods' => [45, 30, 14, 7],
                'sort_order' => 6,
            ],
            [
                'name' => 'Company Events',
                'slug' => 'company-events',
                'description' => 'Marketing events, promotions, and celebrations',
                'icon' => 'calendar',
                'color' => '#ec4899', // Pink
                'default_notification_periods' => [30, 14, 7, 3, 1],
                'sort_order' => 7,
            ],
            [
                'name' => 'Training & Development',
                'slug' => 'training-development',
                'description' => 'Staff training programs and professional development',
                'icon' => 'academic-cap',
                'color' => '#84cc16', // Lime
                'default_notification_periods' => [21, 14, 7, 3],
                'sort_order' => 8,
            ],
            [
                'name' => 'Financial Obligations',
                'slug' => 'financial-obligations',
                'description' => 'Loan payments, insurance premiums, and other financial commitments',
                'icon' => 'currency-dollar',
                'color' => '#f97316', // Orange
                'default_notification_periods' => [30, 14, 7, 3, 1],
                'sort_order' => 9,
            ],
            [
                'name' => 'Equipment & Maintenance',
                'slug' => 'equipment-maintenance',
                'description' => 'Equipment servicing, calibration, and maintenance schedules',
                'icon' => 'briefcase',
                'color' => '#6366f1', // Indigo
                'default_notification_periods' => [30, 14, 7],
                'sort_order' => 10,
            ],
        ];

        foreach ($categories as $categoryData) {
            ReminderCategory::create($categoryData);
        }

        // Create sample reminder items
        $this->createSampleReminders();
    }

    private function createSampleReminders()
    {
        // Get categories and first user
        $categories = ReminderCategory::all();
        $user = User::first();

        if (!$user) {
            return; // No users to assign to
        }

        $sampleReminders = [
            // Government Licenses
            [
                'category_slug' => 'government-licenses',
                'title' => 'Business License Renewal',
                'description' => 'Annual business operating license renewal with local government',
                'due_date' => Carbon::now()->addMonths(2),
                'priority' => 'high',
                'amount' => 150000,
                'currency' => 'TZS',
                'vendor_supplier' => 'Dar es Salaam City Council',
            ],
            [
                'category_slug' => 'government-licenses',
                'title' => 'VAT Certificate Renewal',
                'description' => 'VAT registration certificate renewal with TRA',
                'due_date' => Carbon::now()->addMonths(4),
                'priority' => 'critical',
                'amount' => 50000,
                'currency' => 'TZS',
                'vendor_supplier' => 'Tanzania Revenue Authority',
            ],

            // Airport Licenses
            [
                'category_slug' => 'airport-licenses',
                'title' => 'TAA Operating License',
                'description' => 'Tanzania Airports Authority operating license renewal',
                'due_date' => Carbon::now()->addMonths(3),
                'priority' => 'critical',
                'amount' => 500000,
                'currency' => 'TZS',
                'vendor_supplier' => 'Tanzania Airports Authority',
            ],
            [
                'category_slug' => 'airport-licenses',
                'title' => 'KIA Ground Handling License',
                'description' => 'Kilimanjaro International Airport ground handling permit',
                'due_date' => Carbon::now()->addMonths(6),
                'priority' => 'high',
                'amount' => 300000,
                'currency' => 'TZS',
                'vendor_supplier' => 'Kilimanjaro International Airport',
            ],

            // Staff Welfare
            [
                'category_slug' => 'staff-welfare',
                'title' => 'December Staff Gifts',
                'description' => 'Purchase and distribute Christmas and New Year gifts for all staff',
                'due_date' => Carbon::create(Carbon::now()->year, 12, 15),
                'priority' => 'medium',
                'amount' => 2000000,
                'currency' => 'TZS',
                'notes' => 'Budget allocated for 50 staff members',
            ],
            [
                'category_slug' => 'staff-welfare',
                'title' => 'Mfuko wa Pole na Hongera Review',
                'description' => 'Quarterly review and update of staff welfare fund contributions',
                'due_date' => Carbon::now()->addMonths(1),
                'priority' => 'medium',
                'notes' => 'Review contribution amounts and beneficiaries',
            ],

            // Employment Contracts
            [
                'category_slug' => 'employment-contracts',
                'title' => 'Senior Manager Contract Review',
                'description' => 'Annual review and renewal of senior management contracts',
                'due_date' => Carbon::now()->addMonths(2),
                'priority' => 'high',
                'notes' => 'Include salary increment discussions',
            ],

            // Foreign Staff Permits
            [
                'category_slug' => 'foreign-staff-permits',
                'title' => 'Work Permit - John Smith',
                'description' => 'Work permit renewal for expatriate operations manager',
                'due_date' => Carbon::now()->addMonths(5),
                'priority' => 'critical',
                'amount' => 800000,
                'currency' => 'TZS',
                'vendor_supplier' => 'Ministry of Labour',
                'notes' => 'Include residence permit application',
            ],

            // Company Events
            [
                'category_slug' => 'company-events',
                'title' => 'Annual Company Retreat',
                'description' => 'Organize annual team building and strategy retreat',
                'due_date' => Carbon::now()->addMonths(3),
                'priority' => 'medium',
                'amount' => 5000000,
                'currency' => 'TZS',
                'notes' => 'Book venue and arrange transportation',
            ],

            // Training & Development
            [
                'category_slug' => 'training-development',
                'title' => 'Safety Training Program',
                'description' => 'Quarterly safety training for all operational staff',
                'due_date' => Carbon::now()->addMonths(1),
                'priority' => 'high',
                'amount' => 500000,
                'currency' => 'TZS',
                'vendor_supplier' => 'SafeWork Tanzania',
            ],

            // Overdue items for demonstration
            [
                'category_slug' => 'equipment-maintenance',
                'title' => 'Vehicle Service - Fleet Maintenance',
                'description' => 'Quarterly service for company vehicle fleet',
                'due_date' => Carbon::now()->subDays(5), // Overdue
                'priority' => 'medium',
                'amount' => 800000,
                'currency' => 'TZS',
                'vendor_supplier' => 'Toyota Tanzania',
            ],

            // Due today
            [
                'category_slug' => 'financial-obligations',
                'title' => 'Insurance Premium Payment',
                'description' => 'Monthly insurance premium for company assets',
                'due_date' => Carbon::today(),
                'priority' => 'high',
                'amount' => 450000,
                'currency' => 'TZS',
                'vendor_supplier' => 'Heritage Insurance',
            ],
        ];

        foreach ($sampleReminders as $reminderData) {
            $category = $categories->where('slug', $reminderData['category_slug'])->first();
            
            if ($category) {
                unset($reminderData['category_slug']);
                
                ReminderItem::create(array_merge($reminderData, [
                    'category_id' => $category->id,
                    'assigned_to' => $user->id,
                    'created_by' => $user->id,
                    'status' => 'active',
                ]));
            }
        }

        // Create some completed items for history
        $completedReminders = [
            [
                'category_slug' => 'government-licenses',
                'title' => 'Fire Safety Certificate',
                'description' => 'Annual fire safety inspection and certificate',
                'due_date' => Carbon::now()->subMonths(1),
                'priority' => 'high',
                'amount' => 75000,
                'currency' => 'TZS',
                'vendor_supplier' => 'Fire and Rescue Department',
                'status' => 'completed',
                'completed_at' => Carbon::now()->subDays(20),
            ],
            [
                'category_slug' => 'staff-welfare',
                'title' => 'Q3 Staff Salary Review',
                'description' => 'Quarterly salary increment review for eligible staff',
                'due_date' => Carbon::now()->subMonths(2),
                'priority' => 'medium',
                'status' => 'completed',
                'completed_at' => Carbon::now()->subMonths(2)->addWeeks(1),
                'notes' => 'Completed with 8% average increment',
            ],
        ];

        foreach ($completedReminders as $reminderData) {
            $category = $categories->where('slug', $reminderData['category_slug'])->first();
            
            if ($category) {
                unset($reminderData['category_slug']);
                
                ReminderItem::create(array_merge($reminderData, [
                    'category_id' => $category->id,
                    'assigned_to' => $user->id,
                    'created_by' => $user->id,
                ]));
            }
        }
    }
}