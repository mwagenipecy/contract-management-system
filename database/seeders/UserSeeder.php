<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\ReminderItem;
use App\Models\ReminderCategory;
use App\Models\Employee;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    // public function run()
    // {
    //     User::create([
    //         'name' => 'Admin User',
    //         'email' => 'admin@cms.com',
    //         'password' => Hash::make('password'),
    //         'email_verified_at' => now(),
    //     ]);

    //     User::create([
    //         'name' => 'HR Manager',
    //         'email' => 'hr@cms.com',
    //         'password' => Hash::make('password'),
    //         'email_verified_at' => now(),
    //     ]);
    // }



    public function run()
    {
        // Create enhanced categories with specific configurations
        $categories = [
            [
                'name' => 'Government Licenses',
                'slug' => 'government-licenses__',
                'description' => 'Business licenses, permits, and government registrations',
                'icon' => 'shield-check',
                'color' => '#ef4444',
                'reminder_type' => 'license',
                'required_fields' => ['license_number', 'issuing_authority'],
                'optional_fields' => ['registration_number', 'contact_person'],
                'default_notification_periods' => [90, 60, 30, 14, 7, 1],
                'notification_methods' => ['email', 'sms', 'system'],
                'has_start_end_dates' => true,
                'is_renewable' => true,
                'is_recurring' => false,
                'requires_approval' => false,
                'sort_order' => 1,
            ],
            [
                'name' => 'Airport Licenses & Permits',
                'slug' => 'airport-licenses2',
                'description' => 'TAA, KIA and other airport-related permits',
                'icon' => 'globe',
                'color' => '#f59e0b',
                'reminder_type' => 'license',
                'required_fields' => ['permit_type', 'license_number'],
                'optional_fields' => ['aircraft_registration', 'route_authorization'],
                'default_notification_periods' => [120, 90, 60, 30, 14, 7],
                'notification_methods' => ['email', 'sms', 'system'],
                'has_start_end_dates' => true,
                'is_renewable' => true,
                'is_recurring' => false,
                'requires_approval' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Staff Welfare Events',
                'slug' => 'staff-welfare',
                'description' => 'Employee welfare initiatives, gifts, and celebrations',
                'icon' => 'heart',
                'color' => '#10b981',
                'reminder_type' => 'event',
                'required_fields' => ['event_type', 'participant_count'],
                'optional_fields' => ['budget_code', 'venue', 'caterer'],
                'default_notification_periods' => [30, 14, 7, 3, 1],
                'notification_methods' => ['email', 'system'],
                'has_start_end_dates' => false,
                'is_renewable' => false,
                'is_recurring' => true, // Annual events like Christmas gifts
                'requires_approval' => false,
                'sort_order' => 3,
            ],
            [
                'name' => 'Employment Contracts',
                'slug' => 'employment-contracts',
                'description' => 'Employee contract renewals and reviews',
                'icon' => 'document-text',
                'color' => '#3b82f6',
                'reminder_type' => 'contract',
                'required_fields' => ['contract_type', 'employee_name'],
                'optional_fields' => ['salary_review', 'performance_rating'],
                'default_notification_periods' => [90, 60, 30, 14, 7],
                'notification_methods' => ['email', 'system'],
                'has_start_end_dates' => true,
                'is_renewable' => true,
                'is_recurring' => false,
                'requires_approval' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Work & Residence Permits',
                'slug' => 'foreign-staff-permits',
                'description' => 'Work and residence permits for foreign employees',
                'icon' => 'users',
                'color' => '#8b5cf6',
                'reminder_type' => 'license',
                'required_fields' => ['permit_type', 'employee_name', 'passport_number'],
                'optional_fields' => ['visa_category', 'sponsor_details'],
                'default_notification_periods' => [120, 90, 60, 30, 14, 7, 1],
                'notification_methods' => ['email', 'sms', 'system'],
                'has_start_end_dates' => true,
                'is_renewable' => true,
                'is_recurring' => false,
                'requires_approval' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Vendor & Supplier Contracts',
                'slug' => 'vendor-contracts',
                'description' => 'Supplier agreements and service contracts',
                'icon' => 'truck',
                'color' => '#06b6d4',
                'reminder_type' => 'contract',
                'required_fields' => ['contract_type', 'service_category'],
                'optional_fields' => ['performance_metrics', 'sla_requirements'],
                'default_notification_periods' => [60, 45, 30, 14, 7],
                'notification_methods' => ['email', 'system'],
                'has_start_end_dates' => true,
                'is_renewable' => true,
                'is_recurring' => false,
                'requires_approval' => false,
                'sort_order' => 6,
            ],
            [
                'name' => 'Training & Development',
                'slug' => 'training-development',
                'description' => 'Staff training programs and certifications',
                'icon' => 'academic-cap',
                'color' => '#84cc16',
                'reminder_type' => 'event',
                'required_fields' => ['training_type', 'participant_count'],
                'optional_fields' => ['trainer_name', 'certification_body', 'venue'],
                'default_notification_periods' => [30, 21, 14, 7, 3, 1],
                'notification_methods' => ['email', 'sms', 'system'],
                'has_start_end_dates' => false,
                'is_renewable' => false,
                'is_recurring' => true, // Quarterly safety training
                'requires_approval' => false,
                'sort_order' => 7,
            ],
            [
                'name' => 'Financial Obligations',
                'slug' => 'financial-obligations',
                'description' => 'Loan payments, insurance, taxes, and financial commitments',
                'icon' => 'currency-dollar',
                'color' => '#f97316',
                'reminder_type' => 'financial',
                'required_fields' => ['payment_type', 'account_number'],
                'optional_fields' => ['bank_details', 'reference_number'],
                'default_notification_periods' => [30, 14, 7, 3, 1],
                'notification_methods' => ['email', 'sms', 'system'],
                'has_start_end_dates' => false,
                'is_renewable' => false,
                'is_recurring' => true, // Monthly payments
                'requires_approval' => false,
                'sort_order' => 8,
            ],
            [
                'name' => 'Equipment & Maintenance',
                'slug' => 'equipment-maintenance',
                'description' => 'Equipment servicing, calibration, and maintenance schedules',
                'icon' => 'briefcase',
                'color' => '#6366f1',
                'reminder_type' => 'maintenance',
                'required_fields' => ['equipment_type', 'equipment_serial'],
                'optional_fields' => ['maintenance_type', 'service_provider', 'location'],
                'default_notification_periods' => [30, 14, 7, 3, 1],
                'notification_methods' => ['email', 'system'],
                'has_start_end_dates' => false,
                'is_renewable' => false,
                'is_recurring' => true, // Regular maintenance schedules
                'requires_approval' => false,
                'sort_order' => 9,
            ],
            [
                'name' => 'Company Events & Marketing',
                'slug' => 'company-events',
                'description' => 'Marketing events, promotions, and company celebrations',
                'icon' => 'calendar',
                'color' => '#ec4899',
                'reminder_type' => 'event',
                'required_fields' => ['event_type', 'target_audience'],
                'optional_fields' => ['venue', 'budget_code', 'marketing_materials'],
                'default_notification_periods' => [45, 30, 14, 7, 3, 1],
                'notification_methods' => ['email', 'system'],
                'has_start_end_dates' => false,
                'is_renewable' => false,
                'is_recurring' => false,
                'requires_approval' => true,
                'sort_order' => 10,
            ],
        ];

        foreach ($categories as $categoryData) {
            ReminderCategory::create($categoryData);
        }

        // Create sample reminder items with proper assignments
        $this->createSampleReminders();
    }

    private function createSampleReminders()
    {
        $categories = ReminderCategory::all();
        $employees = Employee::limit(10)->get();
        $user = User::first();

        if (!$user || $employees->isEmpty()) {
            return; // No users or employees to assign to
        }

        $sampleReminders = [
            // Government Licenses
            [
                'category_slug' => 'government-licenses1',
                'title' => 'Business License Renewal - Main Office',
                'description' => 'Annual business operating license renewal with Dar es Salaam City Council',
                'start_date' => Carbon::now()->subYear(),
                'end_date' => Carbon::now()->addMonths(2),
                'priority' => 'high',
                'amount' => 150000,
                'currency' => 'TZS',
                'vendor_supplier' => 'Dar es Salaam City Council',
                'reference_number' => 'BL-2024-001',
                'custom_fields' => [
                    'license_number' => 'BL/DSM/2024/001',
                    'issuing_authority' => 'Dar es Salaam City Council',
                    'registration_number' => 'REG-12345',
                ],
                'assignments' => [
                    ['role' => 'responsible', 'methods' => ['email', 'sms']],
                    ['role' => 'informed', 'methods' => ['email']],
                ],
            ],
            [
                'category_slug' => 'government-licenses2',
                'title' => 'VAT Certificate Renewal',
                'description' => 'VAT registration certificate renewal with Tanzania Revenue Authority',
                'start_date' => Carbon::now()->subMonths(6),
                'end_date' => Carbon::now()->addMonths(4),
                'priority' => 'critical',
                'amount' => 50000,
                'currency' => 'TZS',
                'vendor_supplier' => 'Tanzania Revenue Authority',
                'reference_number' => 'VAT-2024-002',
                'custom_fields' => [
                    'license_number' => 'VAT/TRA/2024/002',
                    'issuing_authority' => 'Tanzania Revenue Authority',
                ],
                'assignments' => [
                    ['role' => 'responsible', 'methods' => ['email', 'sms']],
                ],
            ],

            // Airport Licenses
            [
                'category_slug' => 'airport-licenses1',
                'title' => 'TAA Operating License Renewal',
                'description' => 'Tanzania Airports Authority operating license for ground handling services',
                'start_date' => Carbon::now()->subMonths(8),
                'end_date' => Carbon::now()->addMonths(3),
                'priority' => 'critical',
                'amount' => 500000,
                'currency' => 'TZS',
                'vendor_supplier' => 'Tanzania Airports Authority',
                'reference_number' => 'TAA-OL-2024',
                'custom_fields' => [
                    'permit_type' => 'operating',
                    'license_number' => 'TAA/OL/2024/001',
                ],
                'assignments' => [
                    ['role' => 'responsible', 'methods' => ['email', 'sms']],
                    ['role' => 'approver', 'methods' => ['email']],
                ],
            ],

            // Staff Welfare Events
            [
                'category_slug' => 'staff-welfare',
                'title' => 'December Staff Gifts Distribution',
                'description' => 'Annual Christmas and New Year gifts for all company employees',
                'event_date' => Carbon::create(Carbon::now()->year, 12, 15),
                'priority' => 'medium',
                'amount' => 2000000,
                'currency' => 'TZS',
                'custom_fields' => [
                    'event_type' => 'staff_gifts',
                    'participant_count' => '50',
                    'budget_code' => 'SW-2024-001',
                ],
                'assignments' => [
                    ['role' => 'responsible', 'methods' => ['email']],
                ],
            ],

            // Employment Contracts
            [
                'category_slug' => 'employment-contracts',
                'title' => 'Senior Manager Contract Review - John Mwangi',
                'description' => 'Annual contract review and salary increment discussion',
                'start_date' => Carbon::now()->subYear(),
                'end_date' => Carbon::now()->addMonths(2),
                'priority' => 'high',
                'custom_fields' => [
                    'contract_type' => 'permanent',
                    'employee_name' => 'John Mwangi',
                    'salary_review' => 'due',
                ],
                'assignments' => [
                    ['role' => 'responsible', 'methods' => ['email']],
                    ['role' => 'approver', 'methods' => ['email']],
                ],
            ],

            // Work Permits
            [
                'category_slug' => 'foreign-staff-permits',
                'title' => 'Work Permit Renewal - David Smith',
                'description' => 'Work permit renewal for expatriate operations manager',
                'start_date' => Carbon::now()->subYear(),
                'end_date' => Carbon::now()->addMonths(5),
                'priority' => 'critical',
                'amount' => 800000,
                'currency' => 'TZS',
                'vendor_supplier' => 'Ministry of Labour',
                'custom_fields' => [
                    'permit_type' => 'Class A Work Permit',
                    'employee_name' => 'David Smith',
                    'passport_number' => 'US123456789',
                    'visa_category' => 'Business',
                ],
                'assignments' => [
                    ['role' => 'responsible', 'methods' => ['email', 'sms']],
                ],
            ],

            // Training Events
            [
                'category_slug' => 'training-development',
                'title' => 'Quarterly Safety Training Program',
                'description' => 'Mandatory safety training for all operational staff',
                'event_date' => Carbon::now()->addMonths(1),
                'priority' => 'high',
                'amount' => 500000,
                'currency' => 'TZS',
                'vendor_supplier' => 'SafeWork Tanzania',
                'custom_fields' => [
                    'training_type' => 'safety',
                    'participant_count' => '25',
                    'trainer_name' => 'Dr. Amina Hassan',
                    'venue' => 'Main Conference Room',
                ],
                'assignments' => [
                    ['role' => 'responsible', 'methods' => ['email']],
                ],
            ],

            // Overdue items for demonstration
            [
                'category_slug' => 'equipment-maintenance',
                'title' => 'Vehicle Fleet Service - Monthly Maintenance',
                'description' => 'Regular maintenance service for company vehicle fleet',
                'due_date' => Carbon::now()->subDays(5), // Overdue
                'priority' => 'medium',
                'amount' => 800000,
                'currency' => 'TZS',
                'vendor_supplier' => 'Toyota Tanzania Limited',
                'custom_fields' => [
                    'equipment_type' => 'Vehicle Fleet',
                    'equipment_serial' => 'FLEET-001-010',
                    'maintenance_type' => 'Routine Service',
                    'service_provider' => 'Toyota Tanzania',
                ],
                'assignments' => [
                    ['role' => 'responsible', 'methods' => ['email', 'sms']],
                ],
            ],

            // Due today
            [
                'category_slug' => 'financial-obligations',
                'title' => 'Company Insurance Premium Payment',
                'description' => 'Monthly premium payment for comprehensive company insurance',
                'due_date' => Carbon::today(),
                'priority' => 'high',
                'amount' => 450000,
                'currency' => 'TZS',
                'vendor_supplier' => 'Heritage Insurance Company',
                'custom_fields' => [
                    'payment_type' => 'Insurance Premium',
                    'account_number' => 'POL-12345-2024',
                    'reference_number' => 'HER-INS-001',
                ],
                'assignments' => [
                    ['role' => 'responsible', 'methods' => ['email', 'sms']],
                ],
            ],
        ];

        foreach ($sampleReminders as $reminderData) {
            $category = $categories->where('slug', $reminderData['category_slug'])->first();
            
            if ($category) {
                $assignments = $reminderData['assignments'];
                unset($reminderData['category_slug'], $reminderData['assignments']);
                
                // Set proper due_date based on category type
                if ($category->reminder_type === 'event' && isset($reminderData['event_date'])) {
                    $reminderData['due_date'] = $reminderData['event_date'];
                } elseif ($category->has_start_end_dates && isset($reminderData['end_date'])) {
                    $reminderData['due_date'] = $reminderData['end_date'];
                }
                
                $reminderItem = ReminderItem::create(array_merge($reminderData, [
                    'category_id' => $category->id,
                    'created_by' => $user->id,
                    'status' => 'active',
                ]));

                // Create assignments
                foreach ($assignments as $index => $assignment) {
                    $employee = $employees->get($index % $employees->count());
                    if ($employee) {
                        $reminderItem->assignEmployee(
                            $employee->id,
                            $assignment['role'],
                            $assignment['methods']
                        );
                    }
                }

                // Schedule notifications
                $reminderItem->scheduleNotifications();
            }
        }

        // Create some completed items for history
        $this->createCompletedReminders($categories, $employees, $user);
    }

    private function createCompletedReminders($categories, $employees, $user)
    {
        $completedReminders = [
            [
                'category_slug' => 'government-licenses_',
                'title' => 'Fire Safety Certificate Renewal',
                'description' => 'Annual fire safety inspection and certificate renewal',
                'start_date' => Carbon::now()->subYear()->subMonth(),
                'end_date' => Carbon::now()->subMonth(),
                'priority' => 'high',
                'amount' => 75000,
                'currency' => 'TZS',
                'vendor_supplier' => 'Fire and Rescue Department',
                'status' => 'completed',
                'completed_at' => Carbon::now()->subDays(20),
                'completion_notes' => 'Certificate obtained successfully. Valid for 12 months.',
                'custom_fields' => [
                    'license_number' => 'FSC/2024/001',
                    'issuing_authority' => 'Fire and Rescue Department',
                ],
            ],
            [
                'category_slug' => 'staff-welfare',
                'title' => 'Q3 Staff Salary Review Meeting',
                'description' => 'Quarterly salary increment review for eligible staff members',
                'event_date' => Carbon::now()->subMonths(2),
                'priority' => 'medium',
                'status' => 'completed',
                'completed_at' => Carbon::now()->subMonths(2)->addWeeks(1),
                'completion_notes' => 'Meeting completed successfully. 15 staff members received salary increments averaging 8%.',
                'custom_fields' => [
                    'event_type' => 'salary_review',
                    'participant_count' => '15',
                    'budget_code' => 'HR-2024-Q3',
                ],
            ],
        ];

        foreach ($completedReminders as $reminderData) {
            $category = $categories->where('slug', $reminderData['category_slug'])->first();
            
            if ($category) {
                unset($reminderData['category_slug']);
                
                // Set proper due_date based on category type
                if ($category->reminder_type === 'event' && isset($reminderData['event_date'])) {
                    $reminderData['due_date'] = $reminderData['event_date'];
                } elseif ($category->has_start_end_dates && isset($reminderData['end_date'])) {
                    $reminderData['due_date'] = $reminderData['end_date'];
                }
                
                $reminderItem = ReminderItem::create(array_merge($reminderData, [
                    'category_id' => $category->id,
                    'created_by' => $user->id,
                ]));

                // Create at least one assignment for completed items
                $employee = $employees->first();
                if ($employee) {
                    $reminderItem->assignEmployee($employee->id, 'responsible', ['email']);
                }
            }
        }
    }

}
