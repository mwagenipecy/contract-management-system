<?php

namespace App\Livewire\Reminders;

use Livewire\Component;
use App\Models\ReminderCategory;
use App\Models\Employee;
use Illuminate\Validation\Rule;

class Settings extends Component
{
    public $activeTab = 'categories';
    
    // Category Management
    public $categories;
    public $showCategoryModal = false;
    public $editingCategory = null;
    public $categoryForm = [
        'name' => '',
        'description' => '',
        'icon' => 'document-text',
        'color' => '#6366f1',
        'reminder_type' => 'task',
        'required_fields' => [],
        'optional_fields' => [],
        'default_notification_periods' => [30, 7, 1],
        'notification_methods' => ['email', 'system'],
        'has_start_end_dates' => false,
        'is_renewable' => false,
        'is_recurring' => false,
        'requires_approval' => false,
        'is_active' => true,
    ];

    // Global Settings
    public $globalSettings = [
        'default_currency' => 'TZS',
        'default_notification_methods' => ['email', 'system'],
        'default_priority' => 'medium',
        'require_approval_for_high_priority' => false,
        'auto_complete_overdue_days' => 0,
        'notification_timezone' => 'Africa/Dar_es_Salaam',
        'email_from_name' => 'Reminder System',
        'email_from_address' => 'noreply@company.com',
    ];

    // Notification Templates
    public $notificationTemplates = [
        'reminder' => [
            'subject' => '{item_title} - Due in {days_until} days',
            'body' => 'Hello {employee_name},\n\nThis is a reminder that "{item_title}" is due in {days_until} days.\n\nDue Date: {due_date}\nPriority: {priority}\nCategory: {category_name}\n\n{description}\n\nPlease take appropriate action.\n\nBest regards,\nReminder System'
        ],
        'overdue' => [
            'subject' => 'OVERDUE: {item_title}',
            'body' => 'Hello {employee_name},\n\n"{item_title}" is now OVERDUE.\n\nDue Date: {due_date}\nDays Overdue: {days_overdue}\nPriority: {priority}\n\nImmediate action is required.\n\nBest regards,\nReminder System'
        ]
    ];

    // Available options
    public $availableIcons = [
        'document-text' => 'Document',
        'shield-check' => 'Shield',
        'calendar' => 'Calendar',
        'heart' => 'Heart',
        'briefcase' => 'Briefcase',
        'academic-cap' => 'Academic Cap',
        'currency-dollar' => 'Currency',
        'cog' => 'Settings',
        'home' => 'Home',
        'users' => 'Users',
    ];

    public $availableColors = [
        '#ef4444' => 'Red',
        '#f97316' => 'Orange',
        '#f59e0b' => 'Amber',
        '#eab308' => 'Yellow',
        '#84cc16' => 'Lime',
        '#22c55e' => 'Green',
        '#10b981' => 'Emerald',
        '#14b8a6' => 'Teal',
        '#06b6d4' => 'Cyan',
        '#0ea5e9' => 'Sky',
        '#3b82f6' => 'Blue',
        '#6366f1' => 'Indigo',
        '#8b5cf6' => 'Violet',
        '#a855f7' => 'Purple',
        '#d946ef' => 'Fuchsia',
        '#ec4899' => 'Pink',
        '#f43f5e' => 'Rose',
    ];

    public $reminderTypes = [
        'license' => 'Licenses & Permits',
        'event' => 'Events & Activities',
        'contract' => 'Contracts',
        'task' => 'Tasks',
        'maintenance' => 'Maintenance',
        'financial' => 'Financial',
        'training' => 'Training',
        'welfare' => 'Staff Welfare',
    ];

    public $availableFields = [
        'license_number' => 'License Number',
        'issuing_authority' => 'Issuing Authority',
        'registration_number' => 'Registration Number',
        'permit_type' => 'Permit Type',
        'training_type' => 'Training Type',
        'equipment_serial' => 'Equipment Serial',
        'location' => 'Location',
        'contact_person' => 'Contact Person',
        'contact_phone' => 'Contact Phone',
        'contact_email' => 'Contact Email',
        'website' => 'Website',
        'insurance_policy_number' => 'Insurance Policy Number',
        'bank_account' => 'Bank Account',
        'tax_id' => 'Tax ID',
    ];

    public $currencies = [
        'TZS' => 'Tanzanian Shilling (TZS)',
        'USD' => 'US Dollar (USD)',
        'EUR' => 'Euro (EUR)',
        'GBP' => 'British Pound (GBP)',
        'KES' => 'Kenyan Shilling (KES)',
        'UGX' => 'Ugandan Shilling (UGX)',
    ];

    protected function rules()
    {
        $rules = [
            'categoryForm.name' => 'required|string|max:255',
            'categoryForm.description' => 'nullable|string|max:500',
            'categoryForm.icon' => 'required|string',
            'categoryForm.color' => 'required|string',
            'categoryForm.reminder_type' => 'required|string',
            'categoryForm.required_fields' => 'nullable|array',
            'categoryForm.optional_fields' => 'nullable|array',
            'categoryForm.default_notification_periods' => 'required|array|min:1',
            'categoryForm.default_notification_periods.*' => 'integer|min:1|max:365',
            'categoryForm.notification_methods' => 'required|array|min:1',
            'categoryForm.has_start_end_dates' => 'boolean',
            'categoryForm.is_renewable' => 'boolean',
            'categoryForm.is_recurring' => 'boolean',
            'categoryForm.requires_approval' => 'boolean',
            'categoryForm.is_active' => 'boolean',
        ];

        if ($this->editingCategory) {
            $rules['categoryForm.name'] .= '|unique:reminder_categories,name,' . $this->editingCategory->id;
        } else {
            $rules['categoryForm.name'] .= '|unique:reminder_categories,name';
        }

        return $rules;
    }

    public function mount()
    {
        $this->loadCategories();
        $this->loadGlobalSettings();
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    // Category Management Methods
    public function loadCategories()
    {
        $this->categories = ReminderCategory::orderBy('sort_order')->orderBy('name')->get();
    }

    public function openCategoryModal()
    {
        $this->resetCategoryForm();
        $this->showCategoryModal = true;
    }

    public function editCategory($categoryId)
    {
        $this->editingCategory = ReminderCategory::findOrFail($categoryId);
        $this->categoryForm = [
            'name' => $this->editingCategory->name,
            'description' => $this->editingCategory->description,
            'icon' => $this->editingCategory->icon,
            'color' => $this->editingCategory->color,
            'reminder_type' => $this->editingCategory->reminder_type,
            'required_fields' => $this->editingCategory->required_fields ?? [],
            'optional_fields' => $this->editingCategory->optional_fields ?? [],
            'default_notification_periods' => $this->editingCategory->default_notification_periods ?? [30, 7, 1],
            'notification_methods' => $this->editingCategory->notification_methods ?? ['email', 'system'],
            'has_start_end_dates' => $this->editingCategory->has_start_end_dates,
            'is_renewable' => $this->editingCategory->is_renewable,
            'is_recurring' => $this->editingCategory->is_recurring,
            'requires_approval' => $this->editingCategory->requires_approval,
            'is_active' => $this->editingCategory->is_active,
        ];
        $this->showCategoryModal = true;
    }

    public function saveCategory()
    {
        $this->validate();

        $data = $this->categoryForm;
        $data['slug'] = \Str::slug($data['name']);

        if ($this->editingCategory) {
            $this->editingCategory->update($data);
            session()->flash('message', 'Category updated successfully!');
        } else {
            ReminderCategory::create($data);
            session()->flash('message', 'Category created successfully!');
        }

        $this->closeCategoryModal();
        $this->loadCategories();
    }

    public function deleteCategory($categoryId)
    {
        $category = ReminderCategory::findOrFail($categoryId);
        
        if ($category->items()->count() > 0) {
            session()->flash('error', 'Cannot delete category with existing reminder items.');
            return;
        }

        $category->delete();
        session()->flash('message', 'Category deleted successfully!');
        $this->loadCategories();
    }

    public function closeCategoryModal()
    {
        $this->showCategoryModal = false;
        $this->editingCategory = null;
        $this->resetCategoryForm();
    }

    private function resetCategoryForm()
    {
        $this->categoryForm = [
            'name' => '',
            'description' => '',
            'icon' => 'document-text',
            'color' => '#6366f1',
            'reminder_type' => 'task',
            'required_fields' => [],
            'optional_fields' => [],
            'default_notification_periods' => [30, 7, 1],
            'notification_methods' => ['email', 'system'],
            'has_start_end_dates' => false,
            'is_renewable' => false,
            'is_recurring' => false,
            'requires_approval' => false,
            'is_active' => true,
        ];
    }

    // Category form helper methods
    public function addNotificationPeriod()
    {
        $this->categoryForm['default_notification_periods'][] = 1;
    }

    public function removeNotificationPeriod($index)
    {
        if (count($this->categoryForm['default_notification_periods']) > 1) {
            unset($this->categoryForm['default_notification_periods'][$index]);
            $this->categoryForm['default_notification_periods'] = array_values($this->categoryForm['default_notification_periods']);
        }
    }

    public function updatedCategoryFormReminderType()
    {
        // Auto-configure fields based on reminder type
        switch ($this->categoryForm['reminder_type']) {
            case 'license':
                $this->categoryForm['required_fields'] = ['license_number', 'issuing_authority'];
                $this->categoryForm['optional_fields'] = ['registration_number'];
                $this->categoryForm['has_start_end_dates'] = true;
                $this->categoryForm['is_renewable'] = true;
                break;
            case 'event':
                $this->categoryForm['required_fields'] = ['location'];
                $this->categoryForm['optional_fields'] = ['contact_person'];
                $this->categoryForm['has_start_end_dates'] = false;
                $this->categoryForm['is_renewable'] = false;
                break;
            case 'contract':
                $this->categoryForm['required_fields'] = ['contact_person'];
                $this->categoryForm['optional_fields'] = ['contact_email'];
                $this->categoryForm['has_start_end_dates'] = true;
                $this->categoryForm['is_renewable'] = true;
                break;
            default:
                $this->categoryForm['required_fields'] = [];
                $this->categoryForm['optional_fields'] = [];
                $this->categoryForm['has_start_end_dates'] = false;
                $this->categoryForm['is_renewable'] = false;
                break;
        }
    }

    // Global Settings Methods
    private function loadGlobalSettings()
    {
        // Load from config or database
        // This would typically come from a settings table or config file
    }

    public function saveGlobalSettings()
    {
        // Save global settings to database or config
        session()->flash('message', 'Global settings saved successfully!');
    }

    // Notification Template Methods
    public function saveNotificationTemplates()
    {
        // Save notification templates
        session()->flash('message', 'Notification templates saved successfully!');
    }

    public function resetNotificationTemplates()
    {
        $this->notificationTemplates = [
            'reminder' => [
                'subject' => '{item_title} - Due in {days_until} days',
                'body' => 'Hello {employee_name},\n\nThis is a reminder that "{item_title}" is due in {days_until} days.\n\nDue Date: {due_date}\nPriority: {priority}\nCategory: {category_name}\n\n{description}\n\nPlease take appropriate action.\n\nBest regards,\nReminder System'
            ],
            'overdue' => [
                'subject' => 'OVERDUE: {item_title}',
                'body' => 'Hello {employee_name},\n\n"{item_title}" is now OVERDUE.\n\nDue Date: {due_date}\nDays Overdue: {days_overdue}\nPriority: {priority}\n\nImmediate action is required.\n\nBest regards,\nReminder System'
            ]
        ];
    }

    public function render()
    {
        return view('livewire.reminders.settings');
    }
}