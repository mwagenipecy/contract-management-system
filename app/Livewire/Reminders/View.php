<?php

namespace App\Livewire\Reminders;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\ReminderItem;
use App\Models\ReminderCategory;
use App\Models\Employee;
use Carbon\Carbon;

class View extends Component
{
    use WithFileUploads;

    public ReminderItem $reminder;
    public $activeTab = 'details';
    
    // Edit mode states
    public $isEditing = false;
    public $editForm = [];
    
    // Action modals
    public $showCompleteModal = false;
    public $showRenewModal = false;
    public $showSnoozeModal = false;
    public $showDeleteModal = false;
    public $showAssignmentModal = false;
    public $showNotificationModal = false;
    
    // Action form data
    public $completionNotes = '';
    public $renewalForm = [
        'end_date' => '',
        'amount' => '',
        'notes' => '',
        'documents' => []
    ];
    public $snoozeForm = [
        'days' => 7,
        'reason' => ''
    ];
    public $assignmentForm = [
        'employee_id' => '',
        'role' => 'responsible',
        'notification_methods' => ['email']
    ];
    public $notificationForm = [
        'recipient_type' => 'assigned', // assigned, custom, all
        'custom_recipients' => [],
        'message' => '',
        'method' => 'email'
    ];
    
    // File uploads
    public $newDocuments = [];
    
    // UI States
    public $employees;
    public $categories;
    public $showHistory = false;

    protected function rules()
    {
        return [
            'editForm.title' => 'required|string|max:255',
            'editForm.description' => 'nullable|string|max:1000',
            'editForm.priority' => 'required|in:low,medium,high,critical',
            'editForm.due_date' => 'required|date',
            'editForm.amount' => 'nullable|numeric|min:0',
            'editForm.vendor_supplier' => 'nullable|string|max:255',
            'editForm.notes' => 'nullable|string|max:2000',
            'renewalForm.end_date' => 'required|date|after:today',
            'renewalForm.amount' => 'nullable|numeric|min:0',
            'snoozeForm.days' => 'required|integer|min:1|max:365',
            'assignmentForm.employee_id' => 'required|exists:employees,id',
            'assignmentForm.role' => 'required|in:responsible,informed,approver,backup',
            'notificationForm.message' => 'required|string|max:500',
        ];
    }

    public function mount(ReminderItem $reminder)
    {
        $this->reminder = $reminder->load([
            'category', 
            'createdBy', 
            'approvedBy', 
            'assignments.employee', 
            'notifications', 
            'renewals'
        ]);
        $this->employees = Employee::active()->get();
        $this->categories = ReminderCategory::active()->get();
        $this->initializeEditForm();
        $this->initializeRenewalForm();
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    // Edit functionality
    public function startEdit()
    {
        $this->isEditing = true;
        $this->initializeEditForm();
    }

    public function cancelEdit()
    {
        $this->isEditing = false;
        $this->initializeEditForm();
    }

    public function saveEdit()
    {
        $this->validate([
            'editForm.title' => 'required|string|max:255',
            'editForm.description' => 'nullable|string|max:1000',
            'editForm.priority' => 'required|in:low,medium,high,critical',
            'editForm.due_date' => 'required|date',
            'editForm.amount' => 'nullable|numeric|min:0',
            'editForm.vendor_supplier' => 'nullable|string|max:255',
            'editForm.notes' => 'nullable|string|max:2000',
        ]);

        $this->reminder->update($this->editForm);
        $this->reminder->refresh();
        $this->isEditing = false;
        
        session()->flash('message', 'Reminder updated successfully!');
    }

    private function initializeEditForm()
    {
        $this->editForm = [
            'title' => $this->reminder->title,
            'description' => $this->reminder->description,
            'priority' => $this->reminder->priority,
            'due_date' => $this->reminder->due_date?->format('Y-m-d'),
            'start_date' => $this->reminder->start_date?->format('Y-m-d'),
            'end_date' => $this->reminder->end_date?->format('Y-m-d'),
            'event_date' => $this->reminder->event_date?->format('Y-m-d'),
            'amount' => $this->reminder->amount,
            'vendor_supplier' => $this->reminder->vendor_supplier,
            'reference_number' => $this->reminder->reference_number,
            'notes' => $this->reminder->notes,
        ];
    }

    // Complete functionality
    public function openCompleteModal()
    {
        $this->completionNotes = '';
        $this->showCompleteModal = true;
    }

    public function completeReminder()
    {
        $this->reminder->markCompleted(auth()->id(), $this->completionNotes);
        $this->reminder->refresh();
        $this->closeCompleteModal();
        
        session()->flash('message', 'Reminder marked as completed!');
    }

    public function closeCompleteModal()
    {
        $this->showCompleteModal = false;
        $this->completionNotes = '';
    }

    // Renewal functionality
    public function openRenewModal()
    {
        $this->initializeRenewalForm();
        $this->showRenewModal = true;
    }

    private function initializeRenewalForm()
    {
        $currentEndDate = $this->reminder->end_date ?? $this->reminder->due_date;
        $this->renewalForm = [
            'end_date' => $currentEndDate ? $currentEndDate->addYear()->format('Y-m-d') : '',
            'amount' => $this->reminder->amount,
            'notes' => '',
            'documents' => []
        ];
    }

    public function renewReminder()
    {
        $this->validate([
            'renewalForm.end_date' => 'required|date|after:today',
            'renewalForm.amount' => 'nullable|numeric|min:0',
        ]);

        // Handle document uploads
        $documents = [];
        if ($this->renewalForm['documents']) {
            foreach ($this->renewalForm['documents'] as $document) {
                $path = $document->store('renewal-documents', 'public');
                $documents[] = [
                    'name' => $document->getClientOriginalName(),
                    'path' => $path,
                    'size' => $document->getSize(),
                    'mime_type' => $document->getMimeType(),
                ];
            }
        }

        $this->reminder->renew(
            $this->renewalForm['end_date'],
            $this->renewalForm['amount'],
            $this->renewalForm['notes'],
            $documents,
            auth()->id()
        );

        $this->reminder->refresh();
        $this->closeRenewModal();
        
        session()->flash('message', 'Reminder renewed successfully!');
    }

    public function closeRenewModal()
    {
        $this->showRenewModal = false;
        $this->renewalForm = [
            'end_date' => '',
            'amount' => '',
            'notes' => '',
            'documents' => []
        ];
    }

    // Snooze functionality
    public function openSnoozeModal()
    {
        $this->snoozeForm = [
            'days' => 7,
            'reason' => ''
        ];
        $this->showSnoozeModal = true;
    }

    public function snoozeReminder()
    {
        $this->validate([
            'snoozeForm.days' => 'required|integer|min:1|max:365',
        ]);

        $days = $this->snoozeForm['days'];
        $currentDueDate = $this->reminder->effective_due_date;
        $newDueDate = $currentDueDate->addDays($days);

        // Update appropriate date field
        if ($this->reminder->category->reminder_type === 'event') {
            $this->reminder->update([
                'event_date' => $newDueDate,
                'due_date' => $newDueDate
            ]);
        } elseif ($this->reminder->category->has_start_end_dates) {
            $this->reminder->update([
                'end_date' => $newDueDate,
                'due_date' => $newDueDate
            ]);
        } else {
            $this->reminder->update(['due_date' => $newDueDate]);
        }

        // Reschedule notifications
        $this->reminder->notifications()->where('status', 'pending')->delete();
        $this->reminder->scheduleNotifications();

        $this->reminder->refresh();
        $this->closeSnoozeModal();
        
        session()->flash('message', "Reminder snoozed for {$days} days!");
    }

    public function closeSnoozeModal()
    {
        $this->showSnoozeModal = false;
    }

    // Assignment functionality
    public function openAssignmentModal()
    {
        $this->assignmentForm = [
            'employee_id' => '',
            'role' => 'responsible',
            'notification_methods' => ['email']
        ];
        $this->showAssignmentModal = true;
    }

    public function addAssignment()
    {
        $this->validate([
            'assignmentForm.employee_id' => 'required|exists:employees,id',
            'assignmentForm.role' => 'required|in:responsible,informed,approver,backup',
        ]);

        $this->reminder->assignEmployee(
            $this->assignmentForm['employee_id'],
            $this->assignmentForm['role'],
            $this->assignmentForm['notification_methods']
        );

        $this->reminder->load('assignments.employee');
        $this->closeAssignmentModal();
        
        session()->flash('message', 'Employee assigned successfully!');
    }

    public function removeAssignment($assignmentId)
    {
        $assignment = $this->reminder->assignments()->findOrFail($assignmentId);
        $assignment->delete();
        
        $this->reminder->load('assignments.employee');
        session()->flash('message', 'Assignment removed successfully!');
    }

    public function closeAssignmentModal()
    {
        $this->showAssignmentModal = false;
    }

    // Notification functionality
    public function openNotificationModal()
    {
        $this->notificationForm = [
            'recipient_type' => 'assigned',
            'custom_recipients' => [],
            'message' => '',
            'method' => 'email'
        ];
        $this->showNotificationModal = true;
    }

    public function sendNotification()
    {
        $this->validate([
            'notificationForm.message' => 'required|string|max:500',
        ]);

        // Logic to send notification would go here
        // This would integrate with your notification system

        $this->closeNotificationModal();
        session()->flash('message', 'Notification sent successfully!');
    }

    public function closeNotificationModal()
    {
        $this->showNotificationModal = false;
    }

    // File management
    public function uploadDocuments()
    {
        if ($this->newDocuments) {
            $existingDocs = $this->reminder->documents ?? [];
            
            foreach ($this->newDocuments as $document) {
                $path = $document->store('reminder-documents', 'public');
                $existingDocs[] = [
                    'name' => $document->getClientOriginalName(),
                    'path' => $path,
                    'size' => $document->getSize(),
                    'mime_type' => $document->getMimeType(),
                    'uploaded_at' => now()->toISOString(),
                ];
            }
            
            $this->reminder->update(['documents' => $existingDocs]);
            $this->reminder->refresh();
            $this->newDocuments = [];
            
            session()->flash('message', 'Documents uploaded successfully!');
        }
    }

    public function removeDocument($index)
    {
        $documents = $this->reminder->documents ?? [];
        
        if (isset($documents[$index])) {
            // Delete file from storage
            \Storage::disk('public')->delete($documents[$index]['path']);
            
            unset($documents[$index]);
            $documents = array_values($documents);
            
            $this->reminder->update(['documents' => $documents]);
            $this->reminder->refresh();
            
            session()->flash('message', 'Document removed successfully!');
        }
    }

    // Delete functionality
    public function openDeleteModal()
    {
        $this->showDeleteModal = true;
    }

    public function deleteReminder()
    {
        $this->reminder->delete();
        $this->showDeleteModal = false;
        
        return redirect()->route('reminders.dashboard')
            ->with('message', 'Reminder deleted successfully!');
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
    }

    // Approval functionality
    public function approveReminder()
    {
        $this->reminder->update([
            'status' => 'active',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);
        
        $this->reminder->refresh();
        session()->flash('message', 'Reminder approved successfully!');
    }

    public function rejectReminder()
    {
        $this->reminder->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);
        
        $this->reminder->refresh();
        session()->flash('message', 'Reminder rejected.');
    }

    // Helper methods
    public function getStatusBadgeClass()
    {
        $badge = $this->reminder->status_badge;
        $baseClasses = 'inline-flex px-2 py-0.5 rounded-full text-xs font-medium';
        
        $colorClasses = [
            'red' => 'bg-red-100 text-red-800',
            'yellow' => 'bg-yellow-100 text-yellow-800',
            'green' => 'bg-green-100 text-green-800',
            'blue' => 'bg-blue-100 text-blue-800',
            'gray' => 'bg-gray-100 text-gray-800',
        ];
        
        return $baseClasses . ' ' . ($colorClasses[$badge['color']] ?? $colorClasses['gray']);
    }

    public function getPriorityBadgeClass()
    {
        $classes = [
            'critical' => 'bg-red-100 text-red-800',
            'high' => 'bg-orange-100 text-orange-800',
            'medium' => 'bg-yellow-100 text-yellow-800',
            'low' => 'bg-green-100 text-green-800',
        ];
        
        return 'inline-flex px-2 py-0.5 rounded-full text-xs font-medium ' . 
               ($classes[$this->reminder->priority] ?? $classes['medium']);
    }

    public function render()
    {
        return view('livewire.reminders.view');
    }
}