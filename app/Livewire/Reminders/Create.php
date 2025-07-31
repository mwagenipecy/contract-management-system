<?php

namespace App\Livewire\Reminders;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\ReminderCategory;
use App\Models\ReminderItem;
use App\Models\Employee;
use Carbon\Carbon;

class Create extends Component
{
    use WithFileUploads;

    public $categories;
    public $employees;
    
    // Basic fields
    public $category_id = '';
    public $title = '';
    public $description = '';
    public $priority = 'medium';
    public $reference_number = '';
    
    // Dynamic date fields based on category type
    public $due_date = '';
    public $start_date = '';
    public $end_date = '';
    public $event_date = '';
    public $renewal_date = '';
    
    // Assignment and notifications
    public $assigned_employees = [];
    public $notification_recipients = [];
    public $notification_periods = [];
    public $notification_methods = [];
    public $custom_notifications = false;
    
    // Financial information
    public $amount = '';
    public $currency = 'TZS';
    public $vendor_supplier = '';
    
    // Custom fields (dynamic based on category)
    public $custom_fields = [];
    
    // Files and notes
    public $documents = [];
    public $notes = '';
    
    // UI State
    public $selectedCategory = null;
    public $fieldConfiguration = [];
    public $showAssignmentModal = false;
    public $tempAssignment = [
        'employee_id' => '',
        'role' => 'responsible',
        'notification_methods' => ['email'],
    ];

    protected function rules()
    {
        $rules = [
            'category_id' => 'required|exists:reminder_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'priority' => 'required|in:low,medium,high,critical',
            'reference_number' => 'nullable|string|max:100',
            'amount' => 'nullable|numeric|min:0',
            'currency' => 'required|string|size:3',
            'vendor_supplier' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:2000',
            'documents.*' => 'nullable|file|max:10240',
            'assigned_employees' => 'required|array|min:1',
            'assigned_employees.*.employee_id' => 'required|exists:employees,id',
            'assigned_employees.*.role' => 'required|in:responsible,informed,approver,backup',
            'assigned_employees.*.notification_methods' => 'required|array|min:1',
            'notification_periods' => 'nullable|array',
            'notification_periods.*' => 'integer|min:1|max:365',
        ];

        // Add dynamic date validation based on category
        if ($this->selectedCategory) {
            if ($this->selectedCategory->reminder_type === 'event') {
                $rules['event_date'] = 'required|date|after_or_equal:today';
                $rules['due_date'] = 'nullable|date';
            } elseif ($this->selectedCategory->has_start_end_dates) {
                $rules['start_date'] = 'required|date|after_or_equal:today';
                $rules['end_date'] = 'required|date|after:start_date';
                $rules['due_date'] = 'nullable|date';
            } else {
                $rules['due_date'] = 'required|date|after_or_equal:today';
            }

            // Add custom field validation
            if ($this->selectedCategory->required_fields) {
                foreach ($this->selectedCategory->required_fields as $field) {
                    if (!in_array($field, ['title', 'description', 'due_date', 'start_date', 'end_date', 'event_date'])) {
                        $rules["custom_fields.{$field}"] = 'required';
                    }
                }
            }
        }

        return $rules;
    }

    public function mount()
    {
        $this->categories = ReminderCategory::get();

        // $this->categories = ReminderCategory::active()->ordered()->get();

        $this->employees = Employee::active()->get();
        
        // Set defaults
        $this->due_date = Carbon::now()->addMonth()->format('Y-m-d');
        $this->notification_methods = ['email', 'system'];
        
        // Check if category is passed via URL
        if (request()->has('category_id')) {
            $this->category_id = request('category_id');
            $this->updatedCategoryId();
        }
    }

    public function updatedCategoryId()
    {
        if ($this->category_id) {
            $this->selectedCategory = ReminderCategory::find($this->category_id);
            
            if ($this->selectedCategory) {
                // Set field configuration
                $this->fieldConfiguration = $this->selectedCategory->getFieldConfiguration();
                
                // Set default notification settings
                if (!$this->custom_notifications) {
                    $this->notification_periods = $this->selectedCategory->default_notification_periods ?? [30, 7, 1];
                    $this->notification_methods = $this->selectedCategory->getNotificationMethods();
                }
                
                // Initialize custom fields
                $this->initializeCustomFields();
                
                // Set appropriate dates based on category type
                $this->setDefaultDates();
            }
        } else {
            $this->selectedCategory = null;
            $this->fieldConfiguration = [];
            $this->custom_fields = [];
        }
    }

    private function initializeCustomFields()
    {
        if (!$this->selectedCategory) return;
        
        $allFields = array_merge(
            $this->selectedCategory->required_fields ?? [],
            $this->selectedCategory->optional_fields ?? []
        );
        
        $baseFields = ['title', 'description', 'due_date', 'start_date', 'end_date', 'event_date', 'priority', 'amount', 'vendor_supplier'];
        
        foreach ($allFields as $field) {
            if (!in_array($field, $baseFields) && !isset($this->custom_fields[$field])) {
                $this->custom_fields[$field] = '';
            }
        }
    }

    private function setDefaultDates()
    {
        if (!$this->selectedCategory) return;
        
        switch ($this->selectedCategory->reminder_type) {
            case 'event':
                $this->event_date = Carbon::now()->addWeeks(2)->format('Y-m-d');
                $this->due_date = $this->event_date; // Due date same as event date
                break;
                
            case 'license':
            case 'contract':
                if ($this->selectedCategory->has_start_end_dates) {
                    $this->start_date = Carbon::now()->format('Y-m-d');
                    $this->end_date = Carbon::now()->addYear()->format('Y-m-d');
                    $this->due_date = $this->end_date; // Due date is the end date
                    
                    if ($this->selectedCategory->is_renewable) {
                        $this->renewal_date = Carbon::parse($this->end_date)->addYear()->format('Y-m-d');
                    }
                }
                break;
                
            default:
                $this->due_date = Carbon::now()->addMonth()->format('Y-m-d');
                break;
        }
    }

    public function updatedStartDate()
    {
        if ($this->start_date && $this->selectedCategory && $this->selectedCategory->has_start_end_dates) {
            // Auto-set end date to 1 year from start date for licenses/contracts
            $this->end_date = Carbon::parse($this->start_date)->addYear()->format('Y-m-d');
            $this->due_date = $this->end_date;
            
            if ($this->selectedCategory->is_renewable) {
                $this->renewal_date = Carbon::parse($this->end_date)->addYear()->format('Y-m-d');
            }
        }
    }

    public function updatedEndDate()
    {
        if ($this->end_date) {
            $this->due_date = $this->end_date;
            
            if ($this->selectedCategory && $this->selectedCategory->is_renewable) {
                $this->renewal_date = Carbon::parse($this->end_date)->addYear()->format('Y-m-d');
            }
        }
    }

    public function updatedEventDate()
    {
        if ($this->event_date) {
            $this->due_date = $this->event_date;
        }
    }

    public function openAssignmentModal()
    {
        $this->tempAssignment = [
            'employee_id' => '',
            'role' => 'responsible',
            'notification_methods' => ['email'],
        ];
        $this->showAssignmentModal = true;
    }

    public function closeAssignmentModal()
    {
        $this->showAssignmentModal = false;
    }

    public function addAssignment()
    {
        $this->validate([
            'tempAssignment.employee_id' => 'required|exists:employees,id',
            'tempAssignment.role' => 'required|in:responsible,informed,approver,backup',
            'tempAssignment.notification_methods' => 'required|array|min:1',
        ]);

        // Check if employee is already assigned
        $existingIndex = array_search($this->tempAssignment['employee_id'], array_column($this->assigned_employees, 'employee_id'));
        
        if ($existingIndex !== false) {
            // Update existing assignment
            $this->assigned_employees[$existingIndex] = $this->tempAssignment;
        } else {
            // Add new assignment
            $this->assigned_employees[] = $this->tempAssignment;
        }

        $this->closeAssignmentModal();
    }

    public function removeAssignment($index)
    {
        unset($this->assigned_employees[$index]);
        $this->assigned_employees = array_values($this->assigned_employees);
    }

    public function toggleCustomNotifications()
    {
        $this->custom_notifications = !$this->custom_notifications;
        
        if (!$this->custom_notifications && $this->selectedCategory) {
            $this->notification_periods = $this->selectedCategory->default_notification_periods ?? [30, 7, 1];
            $this->notification_methods = $this->selectedCategory->getNotificationMethods();
        }
    }

    public function addNotificationPeriod()
    {
        $this->notification_periods[] = 1;
    }

    public function removeNotificationPeriod($index)
    {
        if (count($this->notification_periods) > 1) {
            unset($this->notification_periods[$index]);
            $this->notification_periods = array_values($this->notification_periods);
        }
    }

    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    public function save()
    {
        $this->validate();

        // Handle file uploads
        $uploadedDocuments = [];
        if ($this->documents) {
            foreach ($this->documents as $document) {
                $path = $document->store('reminder-documents', 'public');
                $uploadedDocuments[] = [
                    'name' => $document->getClientOriginalName(),
                    'path' => $path,
                    'size' => $document->getSize(),
                    'mime_type' => $document->getMimeType(),
                ];
            }
        }

        // Prepare data for creation
        $data = [
            'category_id' => $this->category_id,
            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->priority,
            'reference_number' => $this->reference_number,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'vendor_supplier' => $this->vendor_supplier,
            'custom_fields' => $this->custom_fields,
            'documents' => $uploadedDocuments,
            'notes' => $this->notes,
            'notification_periods' => $this->notification_periods,
            'notification_methods' => $this->notification_methods,
            'created_by' => auth()->id(),
        ];

        // Set dates based on category type
        if ($this->selectedCategory->reminder_type === 'event') {
            $data['event_date'] = $this->event_date;
            $data['due_date'] = $this->event_date;
        } elseif ($this->selectedCategory->has_start_end_dates) {
            $data['start_date'] = $this->start_date;
            $data['end_date'] = $this->end_date;
            $data['due_date'] = $this->end_date;
            if ($this->renewal_date) {
                $data['renewal_date'] = $this->renewal_date;
            }
        } else {
            $data['due_date'] = $this->due_date;
        }

        // Create the reminder item
        $reminderItem = ReminderItem::create($data);

        // Create assignments
        foreach ($this->assigned_employees as $assignment) {
            $reminderItem->assignEmployee(
                $assignment['employee_id'],
                $assignment['role'],
                $assignment['notification_methods']
            );
        }

        // Schedule notifications
        $reminderItem->scheduleNotifications();

        session()->flash('message', 'Reminder created successfully!');
        
        return redirect()->route('reminders.show', $reminderItem);
    }

    public function getEmployeeName($employeeId)
    {
        $employee = $this->employees->find($employeeId);
        return $employee ? $employee->name : 'Unknown Employee';
    }

    public function getEmployeeDetails($employeeId)
    {
        $employee = $this->employees->find($employeeId);
        return $employee ? [
            'name' => $employee->name,
            'email' => $employee->email,
            'phone' => $employee->phone,
            'department' => $employee->department,
        ] : null;
    }

    public function getDynamicFieldType($fieldName)
    {
        // Define field types for better UI
        $fieldTypes = [
            'license_number' => 'text',
            'issuing_authority' => 'text',
            'registration_number' => 'text',
            'permit_type' => 'select',
            'training_type' => 'select',
            'equipment_serial' => 'text',
            'location' => 'text',
            'contact_person' => 'text',
            'contact_phone' => 'tel',
            'contact_email' => 'email',
            'website' => 'url',
            'insurance_policy_number' => 'text',
            'bank_account' => 'text',
            'tax_id' => 'text',
        ];

        return $fieldTypes[$fieldName] ?? 'text';
    }

    public function getDynamicFieldOptions($fieldName)
    {
        // Define options for select fields
        $fieldOptions = [
            'permit_type' => [
                'operating' => 'Operating Permit',
                'environmental' => 'Environmental Permit',
                'construction' => 'Construction Permit',
                'import_export' => 'Import/Export Permit',
            ],
            'training_type' => [
                'safety' => 'Safety Training',
                'technical' => 'Technical Training',
                'compliance' => 'Compliance Training',
                'management' => 'Management Training',
            ],
        ];

        return $fieldOptions[$fieldName] ?? [];
    }

    public function render()
    {
        return view('livewire.reminders.create');
    }
}