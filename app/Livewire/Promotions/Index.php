<?php

namespace App\Livewire\Promotions;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Promotion;
use App\Models\Employee;
use App\Models\Department;
use App\Models\PromotionDelivery;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PromotionNotification;
use Exception;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    public $activeTab = 'active';
    
    // Create/Edit form
    public $showCreateModal = false;
    public $editingPromotion = null;
    public $promotionForm = [
        'title' => '',
        'content' => '',
        'type' => 'announcement',
        'priority' => 'medium',
        'start_date' => '',
        'end_date' => '',
        'delivery_methods' => ['email'],
        'recipient_type' => 'all_employees',
        'selected_employees' => [],
        'selected_departments' => [],
        'include_attachments' => false,
        'schedule_delivery' => false,
        'scheduled_at' => '',
        'is_active' => true,
    ];

    // Recipients management
    public $employees=[];
    public $departments;
    public $recipientStats = [
        'total' => 0,
        'by_method' => []
    ];

    // Preview and sending
    public $showPreviewModal = false;
    public $showSendModal = false;
    public $previewData = null;
    public $sendingPromotion = null;
    public $attachments = [];

    // Filters
    public $search = '';
    public $filterType = '';
    public $filterPriority = '';
    public $filterStatus = '';
    public $dateRange = 'all';

    // UI States
    public $selectedPromotions = [];
    public $selectAll = false;
    public $isLoading = false;

    protected $queryString = [
        'activeTab' => ['except' => 'active'],
        'search' => ['except' => ''],
        'filterType' => ['except' => ''],
        'filterPriority' => ['except' => ''],
        'filterStatus' => ['except' => ''],
    ];

    protected function rules()
    {
        return [
            'promotionForm.title' => 'required|string|max:255',
            'promotionForm.content' => 'required|string|min:10',
            'promotionForm.type' => 'required|in:promotion,announcement,update,alert,celebration',
            'promotionForm.priority' => 'required|in:low,medium,high,urgent',
            'promotionForm.start_date' => 'nullable|date|after_or_equal:today',
            'promotionForm.end_date' => 'nullable|date|after:promotionForm.start_date',
            'promotionForm.delivery_methods' => 'required|array|min:1',
            'promotionForm.delivery_methods.*' => 'in:email,sms,push',
            'promotionForm.recipient_type' => 'required|in:all_employees,selected_employees,departments',
            'promotionForm.selected_employees' => 'required_if:promotionForm.recipient_type,selected_employees|array',
            'promotionForm.selected_departments' => 'required_if:promotionForm.recipient_type,departments|array',
            'promotionForm.scheduled_at' => 'required_if:promotionForm.schedule_delivery,true|nullable|date|after:now',
            'attachments.*' => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,xlsx,xls',
        ];
    }

    protected $messages = [
        'promotionForm.title.required' => 'Title is required.',
        'promotionForm.content.required' => 'Content is required.',
        'promotionForm.content.min' => 'Content must be at least 10 characters.',
        'promotionForm.delivery_methods.required' => 'At least one delivery method is required.',
        'promotionForm.selected_employees.required_if' => 'Please select at least one employee.',
        'promotionForm.selected_departments.required_if' => 'Please select at least one department.',
        'promotionForm.scheduled_at.required_if' => 'Scheduled date and time is required.',
        'promotionForm.scheduled_at.after' => 'Scheduled time must be in the future.',
    ];

    public function mount()
    {
        try {
            $this->loadInitialData();
            $this->initializeForm();
            
            Log::info('Promotions component mounted successfully', [
                'user_id' => auth()->id(),
                'employees_count' => $this->employees->count(),
                'departments_count' => 0 , // $this->departments->count()
            ]);
        } catch (Exception $e) {
            Log::error('Error mounting promotions component', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
            session()->flash('error', 'Error loading promotions data. Please refresh the page.');
        }
    }

    private function loadInitialData()
    {
        $this->employees = Employee::
            select('id', 'name', 'email', 'phone')
            ->orderBy('name')
            ->get();
            
        $this->departments = []; 
        
        // Department::select('id', 'name')
        //     ->orderBy('name')
        //     ->get();
    }

    private function initializeForm()
    {
        $this->promotionForm['start_date'] = Carbon::now()->format('Y-m-d');
        $this->promotionForm['end_date'] = Carbon::now()->addDays(30)->format('Y-m-d');
        $this->updateRecipientStats();
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
        
        Log::info('Tab changed in promotions', [
            'tab' => $tab,
            'user_id' => auth()->id()
        ]);
    }

    // Create/Edit functionality
    public function openCreateModal()
    {
        $this->resetPromotionForm();
        $this->showCreateModal = true;
        
        Log::info('Create promotion modal opened', [
            'user_id' => auth()->id()
        ]);
    }

    public function editPromotion($promotionId)
    {
        try {
            $this->editingPromotion = Promotion::findOrFail($promotionId);
            $this->populateFormWithPromotion($this->editingPromotion);
            $this->updateRecipientStats();
            $this->showCreateModal = true;
            
            Log::info('Promotion opened for editing', [
                'promotion_id' => $promotionId,
                'user_id' => auth()->id()
            ]);
        } catch (Exception $e) {
            Log::error('Error opening promotion for edit', [
                'promotion_id' => $promotionId,
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
            session()->flash('error', 'Error loading promotion data.');
        }
    }

    private function populateFormWithPromotion($promotion)
    {
        $this->promotionForm = [
            'title' => $promotion->title,
            'content' => $promotion->content,
            'type' => $promotion->type,
            'priority' => $promotion->priority,
            'start_date' => $promotion->start_date?->format('Y-m-d'),
            'end_date' => $promotion->end_date?->format('Y-m-d'),
            'delivery_methods' => $promotion->delivery_methods ?? ['email'],
            'recipient_type' => $promotion->recipient_type,
            'selected_employees' => $promotion->selected_employees ?? [],
            'selected_departments' => $promotion->selected_departments ?? [],
            'include_attachments' => false,
            'schedule_delivery' => $promotion->scheduled_at ? true : false,
            'scheduled_at' => $promotion->scheduled_at?->format('Y-m-d\TH:i'),
            'is_active' => $promotion->is_active,
        ];
    }

    public function savePromotion()
    {
        $this->validate();

        $this->isLoading = true;

        DB::beginTransaction();
        try {
            $uploadedAttachments = $this->handleAttachments();
            $promotionData = $this->preparePromotionData($uploadedAttachments);
            
            if ($this->editingPromotion) {
                $this->editingPromotion->update($promotionData);
                $promotion = $this->editingPromotion;
                $action = 'updated';
            } else {
                $promotion = Promotion::create($promotionData);
                $action = 'created';
            }

            // Auto-send if not scheduled
            if (!$this->promotionForm['schedule_delivery']) {
                $this->sendPromotionNow($promotion);
            }

            DB::commit();
            session()->flash('message', "Promotion {$action} successfully!");
            $this->closeCreateModal();
            
            Log::info("Promotion {$action}", [
                'promotion_id' => $promotion->id,
                'title' => $promotion->title,
                'user_id' => auth()->id()
            ]);
            
        } catch (Exception $e) {
            DB::rollback();

            dd($e->getMessage());

            Log::error('Error saving promotion', [
                'error' => $e->getMessage(),
                'form_data' => $this->promotionForm,
                'user_id' => auth()->id()
            ]);
            session()->flash('error', 'Error saving promotion. Please try again.');
        } finally {
            $this->isLoading = false;
        }
    }

    private function handleAttachments()
    {
        $uploadedAttachments = [];
        if ($this->attachments) {
            foreach ($this->attachments as $attachment) {
                try {
                    $path = $attachment->store('promotion-attachments', 'public');
                    $uploadedAttachments[] = [
                        'name' => $attachment->getClientOriginalName(),
                        'path' => $path,
                        'size' => $attachment->getSize(),
                        'mime_type' => $attachment->getMimeType(),
                        'uploaded_at' => now(),
                    ];
                } catch (Exception $e) {
                    Log::error('Error uploading attachment', [
                        'error' => $e->getMessage(),
                        'filename' => $attachment->getClientOriginalName()
                    ]);
                }
            }
        }
        return $uploadedAttachments;
    }

    private function preparePromotionData($uploadedAttachments)
    {
        $data = $this->promotionForm;
        $data['attachments'] = array_merge(
            $this->editingPromotion->attachments ?? [], 
            $uploadedAttachments
        );
        $data['created_by'] = auth()->id();
        $data['total_recipients'] = $this->recipientStats['total'];
        $data['status'] = $this->promotionForm['schedule_delivery'] ? 'scheduled' : 'draft';
        
        // Parse dates
        if ($data['start_date']) {
            $data['start_date'] = Carbon::parse($data['start_date']);
        }
        if ($data['end_date']) {
            $data['end_date'] = Carbon::parse($data['end_date']);
        }
       if (!empty($data['scheduled_at'])) {
    $data['scheduled_at'] = Carbon::parse($data['scheduled_at']);
        } else {
            $data['scheduled_at'] = null;
        }

        return $data;
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->editingPromotion = null;
        $this->resetPromotionForm();
        $this->attachments = [];
        $this->resetValidation();
    }

    private function resetPromotionForm()
    {
        $this->promotionForm = [
            'title' => '',
            'content' => '',
            'type' => 'announcement',
            'priority' => 'medium',
            'start_date' => Carbon::now()->format('Y-m-d'),
            'end_date' => Carbon::now()->addDays(30)->format('Y-m-d'),
            'delivery_methods' => ['email'],
            'recipient_type' => 'all_employees',
            'selected_employees' => [],
            'selected_departments' => [],
            'include_attachments' => false,
            'schedule_delivery' => false,
            'scheduled_at' => '',
            'is_active' => true,
        ];
        $this->updateRecipientStats();
    }

    // Recipients management
    public function updatedPromotionFormRecipientType()
    {
        $this->promotionForm['selected_employees'] = [];
        $this->promotionForm['selected_departments'] = [];
        $this->updateRecipientStats();
    }

    public function updatedPromotionFormSelectedEmployees()
    {
        $this->updateRecipientStats();
    }

    public function updatedPromotionFormSelectedDepartments()
    {
        $this->updateRecipientStats();
    }

    public function updatedPromotionFormDeliveryMethods()
    {
        $this->updateRecipientStats();
    }

    private function updateRecipientStats()
    {
        try {
            $recipients = $this->getRecipients();
            $this->recipientStats['total'] = $recipients->count();
            
            $this->recipientStats['by_method'] = [];
            foreach ($this->promotionForm['delivery_methods'] as $method) {
                if ($method === 'email') {
                    $this->recipientStats['by_method']['email'] = $recipients
                        ->whereNotNull('email')
                        ->where('email', '!=', '')
                        ->count();
                } elseif ($method === 'sms') {
                    $this->recipientStats['by_method']['sms'] = $recipients
                        ->whereNotNull('phone')
                        ->where('phone', '!=', '')
                        ->count();
                }
            }
        } catch (Exception $e) {
            Log::error('Error updating recipient stats', [
                'error' => $e->getMessage(),
                'recipient_type' => $this->promotionForm['recipient_type'],
                'user_id' => auth()->id()
            ]);
            $this->recipientStats = ['total' => 0, 'by_method' => []];
        }
    }

    private function getRecipients()
    {
        switch ($this->promotionForm['recipient_type']) {
            case 'selected_employees':
                return Employee::whereIn('id', $this->promotionForm['selected_employees'])
                    ->active()
                    ->get();
            case 'departments':
                return Employee::whereIn('department_id', $this->promotionForm['selected_departments'])
                    ->active()
                    ->get();
            default:
                return Employee::active()->get();
        }
    }

    // Preview functionality
    public function previewPromotion($promotionId = null)
    {
        try {
            if ($promotionId) {
                $this->previewData = Promotion::with('createdBy')->findOrFail($promotionId);
            } else {
                // Create temporary promotion for preview
                $this->previewData = new Promotion($this->promotionForm);
                $this->previewData->total_recipients = $this->recipientStats['total'];
                $this->previewData->created_by = auth()->id();
                $this->previewData->createdBy = auth()->user();
            }
            $this->showPreviewModal = true;
            
            Log::info('Promotion preview opened', [
                'promotion_id' => $promotionId,
                'user_id' => auth()->id()
            ]);
        } catch (Exception $e) {
            Log::error('Error opening promotion preview', [
                'promotion_id' => $promotionId,
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
            session()->flash('error', 'Error loading promotion preview.');
        }
    }

    public function closePreviewModal()
    {
        $this->showPreviewModal = false;
        $this->previewData = null;
    }

    // Sending functionality
    public function openSendModal($promotionId)
    {
        try {
            $this->sendingPromotion = Promotion::findOrFail($promotionId);
            $this->showSendModal = true;
            
            Log::info('Send promotion modal opened', [
                'promotion_id' => $promotionId,
                'user_id' => auth()->id()
            ]);
        } catch (Exception $e) {
            Log::error('Error opening send modal', [
                'promotion_id' => $promotionId,
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
            session()->flash('error', 'Error loading promotion for sending.');
        }
    }

    public function sendPromotionNow($promotion = null)
    {
        $promotion = $promotion ?? $this->sendingPromotion;
        
        if (!$promotion) {
            Log::warning('Attempted to send null promotion', [
                'user_id' => auth()->id()
            ]);
            return;
        }

        $this->isLoading = true;

        DB::beginTransaction();
        try {
            $recipients = $this->getRecipientsForPromotion($promotion);
            $results = $this->processDeliveries($promotion, $recipients);
            
            $promotion->update([
                'status' => 'sent',
                'sent_at' => now(),
                'actual_recipients' => $results['sent_count'],
            ]);

            DB::commit();
            
            Log::info('Promotion sent successfully', [
                'promotion_id' => $promotion->id,
                'sent_count' => $results['sent_count'],
                'failed_count' => $results['failed_count'],
                'user_id' => auth()->id()
            ]);

            $this->closeSendModal();
            $this->showSuccessMessage($results);
            
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Error sending promotion', [
                'promotion_id' => $promotion->id,
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
            session()->flash('error', 'Error sending promotion. Please try again.');
        } finally {
            $this->isLoading = false;
        }
    }

    private function processDeliveries($promotion, $recipients)
    {
        $sentCount = 0;
        $failedCount = 0;
        
        foreach ($recipients as $employee) {
            foreach ($promotion->delivery_methods as $method) {
                try {
                    $delivery = PromotionDelivery::create([
                        'promotion_id' => $promotion->id,
                        'employee_id' => $employee->id,
                        'method' => $method,
                        'status' => 'pending'
                    ]);

                    $success = $this->sendNotification($promotion, $employee, $method);
                    
                    if ($success) {
                        $delivery->update([
                            'status' => 'sent',
                            'sent_at' => now()
                        ]);
                        $sentCount++;
                    } else {
                        throw new Exception("Failed to send {$method} notification");
                    }
                    
                } catch (Exception $e) {
                    $failedCount++;
                    if (isset($delivery)) {
                        $delivery->update([
                            'status' => 'failed',
                            'failure_reason' => $e->getMessage()
                        ]);
                    }
                    
                    Log::error('Failed to send promotion to employee', [
                        'promotion_id' => $promotion->id,
                        'employee_id' => $employee->id,
                        'method' => $method,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }

        return ['sent_count' => $sentCount, 'failed_count' => $failedCount];
    }

    private function sendNotification($promotion, $employee, $method)
    {
        try {
            switch ($method) {
                case 'email':
                    if (!$employee->email) {
                        throw new Exception('Employee has no email address');
                    }
                    return $this->sendEmail($promotion, $employee);
                    
                case 'sms':
                    if (!$employee->phone) {
                        throw new Exception('Employee has no phone number');
                    }
                    return $this->sendSMS($promotion, $employee);
                    
                default:
                    throw new Exception("Unsupported delivery method: {$method}");
            }
        } catch (Exception $e) {
            Log::error("Error sending {$method} notification", [
                'promotion_id' => $promotion->id,
                'employee_id' => $employee->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    private function sendEmail($promotion, $employee)
    {
        try {
            Notification::send($employee, new PromotionNotification($promotion, 'email'));
            
            Log::info('Email sent successfully', [
                'promotion_id' => $promotion->id,
                'employee_id' => $employee->id,
                'email' => $employee->email
            ]);
            
            return true;
        } catch (Exception $e) {
            Log::error('Failed to send email', [
                'promotion_id' => $promotion->id,
                'employee_id' => $employee->id,
                'email' => $employee->email,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    private function sendSMS($promotion, $employee)
    {
        try {
            Notification::send($employee, new PromotionNotification($promotion, 'sms'));
            
            Log::info('SMS sent successfully', [
                'promotion_id' => $promotion->id,
                'employee_id' => $employee->id,
                'phone' => $employee->phone
            ]);
            
            return true;
        } catch (Exception $e) {
            Log::error('Failed to send SMS', [
                'promotion_id' => $promotion->id,
                'employee_id' => $employee->id,
                'phone' => $employee->phone,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    private function getRecipientsForPromotion($promotion)
    {
        switch ($promotion->recipient_type) {
            case 'selected_employees':
                return Employee::whereIn('id', $promotion->selected_employees)
                    ->active()
                    ->get();
            case 'departments':
                return Employee::whereIn('department_id', $promotion->selected_departments)
                    ->active()
                    ->get();
            default:
                return Employee::active()->get();
        }
    }

    private function showSuccessMessage($results)
    {
        if ($results['failed_count'] > 0) {
            session()->flash('message', 
                "Promotion sent to {$results['sent_count']} recipients. {$results['failed_count']} deliveries failed."
            );
        } else {
            session()->flash('message', 
                "Promotion sent successfully to {$results['sent_count']} recipients!"
            );
        }
    }

    public function closeSendModal()
    {
        $this->showSendModal = false;
        $this->sendingPromotion = null;
    }

    // Bulk actions
    public function updatedSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedPromotions = $this->promotions->pluck('id')->toArray();
        } else {
            $this->selectedPromotions = [];
        }
        
        Log::info('Bulk selection changed', [
            'select_all' => $this->selectAll,
            'selected_count' => count($this->selectedPromotions),
            'user_id' => auth()->id()
        ]);
    }

    public function bulkDelete()
    {
        if (empty($this->selectedPromotions)) return;

        try {
            DB::beginTransaction();
            
            $promotions = Promotion::whereIn('id', $this->selectedPromotions)->get();
            
            // Delete associated files
            foreach ($promotions as $promotion) {
                $this->deletePromotionFiles($promotion);
            }
            
            $count = Promotion::whereIn('id', $this->selectedPromotions)->delete();
            
            DB::commit();
            
            Log::info('Bulk promotions deleted', [
                'count' => $count,
                'promotion_ids' => $this->selectedPromotions,
                'user_id' => auth()->id()
            ]);
            
            $this->selectedPromotions = [];
            $this->selectAll = false;
            session()->flash('message', "{$count} promotions deleted successfully.");
            
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Error in bulk delete', [
                'error' => $e->getMessage(),
                'promotion_ids' => $this->selectedPromotions,
                'user_id' => auth()->id()
            ]);
            session()->flash('error', 'Error deleting promotions. Please try again.');
        }
    }

    public function bulkActivate()
    {
        if (empty($this->selectedPromotions)) return;

        try {
            $count = Promotion::whereIn('id', $this->selectedPromotions)
                ->update(['is_active' => true]);
            
            $this->resetBulkSelection();
            session()->flash('message', "{$count} promotions activated.");
            
        } catch (Exception $e) {
            $this->logBulkError('activate', $e);
            session()->flash('error', 'Error activating promotions. Please try again.');
        }
    }

    public function bulkDeactivate()
    {
        if (empty($this->selectedPromotions)) return;

        try {
            $count = Promotion::whereIn('id', $this->selectedPromotions)
                ->update(['is_active' => false]);
            
            $this->resetBulkSelection();
            session()->flash('message', "{$count} promotions deactivated.");
            
        } catch (Exception $e) {
            $this->logBulkError('deactivate', $e);
            session()->flash('error', 'Error deactivating promotions. Please try again.');
        }
    }

    private function resetBulkSelection()
    {
        $this->selectedPromotions = [];
        $this->selectAll = false;
    }

    private function logBulkError($action, $exception)
    {
        Log::error("Error in bulk {$action}", [
            'error' => $exception->getMessage(),
            'promotion_ids' => $this->selectedPromotions,
            'user_id' => auth()->id()
        ]);
    }

    // Individual actions
    public function deletePromotion($promotionId)
    {
        try {
            DB::beginTransaction();
            
            $promotion = Promotion::findOrFail($promotionId);
            $this->deletePromotionFiles($promotion);
            $promotion->delete();
            
            DB::commit();
            
            Log::info('Promotion deleted', [
                'promotion_id' => $promotionId,
                'title' => $promotion->title,
                'user_id' => auth()->id()
            ]);
            
            session()->flash('message', 'Promotion deleted successfully!');
            
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Error deleting promotion', [
                'promotion_id' => $promotionId,
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
            session()->flash('error', 'Error deleting promotion. Please try again.');
        }
    }

    private function deletePromotionFiles($promotion)
    {
        if ($promotion->attachments) {
            foreach ($promotion->attachments as $attachment) {
                try {
                    Storage::disk('public')->delete($attachment['path']);
                } catch (Exception $e) {
                    Log::warning('Failed to delete attachment file', [
                        'path' => $attachment['path'],
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }
    }

    public function toggleStatus($promotionId)
    {
        try {
            $promotion = Promotion::findOrFail($promotionId);
            $newStatus = !$promotion->is_active;
            $promotion->update(['is_active' => $newStatus]);
            
            $status = $newStatus ? 'activated' : 'deactivated';
            
            Log::info('Promotion status toggled', [
                'promotion_id' => $promotionId,
                'new_status' => $newStatus,
                'user_id' => auth()->id()
            ]);
            
            session()->flash('message', "Promotion {$status} successfully!");
            
        } catch (Exception $e) {
            Log::error('Error toggling promotion status', [
                'promotion_id' => $promotionId,
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
            session()->flash('error', 'Error updating promotion status. Please try again.');
        }
    }

    public function duplicatePromotion($promotionId)
    {
        try {
            DB::beginTransaction();
            
            $original = Promotion::findOrFail($promotionId);
            $duplicate = $original->replicate();
            $duplicate->title = $original->title . ' (Copy)';
            $duplicate->status = 'draft';
            $duplicate->sent_at = null;
            $duplicate->actual_recipients = null;
            $duplicate->created_by = auth()->id();
            $duplicate->save();

            DB::commit();
            
            Log::info('Promotion duplicated', [
                'original_id' => $promotionId,
                'duplicate_id' => $duplicate->id,
                'user_id' => auth()->id()
            ]);
            
            session()->flash('message', 'Promotion duplicated successfully!');
            
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Error duplicating promotion', [
                'promotion_id' => $promotionId,
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
            session()->flash('error', 'Error duplicating promotion. Please try again.');
        }
    }

    // Filter methods
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->filterType = '';
        $this->filterPriority = '';
        $this->filterStatus = '';
        $this->resetPage();
        
        Log::info('Filters cleared', [
            'user_id' => auth()->id()
        ]);
    }

    // Properties
    public function getPromotionsProperty()
    {
        try {
            $query = Promotion::with(['createdBy'])
                ->when($this->search, function ($q) {
                    $q->where(function($subQuery) {
                        $subQuery->where('title', 'like', '%' . $this->search . '%')
                                ->orWhere('content', 'like', '%' . $this->search . '%');
                    });
                })
                ->when($this->filterType, function ($q) {
                    $q->where('type', $this->filterType);
                })
                ->when($this->filterPriority, function ($q) {
                    $q->where('priority', $this->filterPriority);
                })
                ->when($this->filterStatus, function ($q) {
                    $q->where('status', $this->filterStatus);
                });

            // Apply tab filters
            switch ($this->activeTab) {
                case 'active':
                    $query->where('is_active', true)->where('status', '!=', 'sent');
                    break;
                case 'sent':
                    $query->where('status', 'sent');
                    break;
                case 'scheduled':
                    $query->where('status', 'scheduled');
                    break;
                case 'draft':
                    $query->where('status', 'draft');
                    break;
                case 'archived':
                    $query->where('is_active', false);
                    break;
            }

            return $query->latest('created_at')->paginate(15);
            
        } catch (Exception $e) {
            Log::error('Error loading promotions', [
                'error' => $e->getMessage(),
                'filters' => [
                    'search' => $this->search,
                    'type' => $this->filterType,
                    'priority' => $this->filterPriority,
                    'status' => $this->filterStatus,
                    'tab' => $this->activeTab
                ],
                'user_id' => auth()->id()
            ]);
            return collect([]);
        }
    }

    public function getStatsProperty()
    {
        try {
            return [
                'total' => Promotion::count(),
                'active' => Promotion::where('is_active', true)->where('status', '!=', 'sent')->count(),
                'sent' => Promotion::where('status', 'sent')->count(),
                'scheduled' => Promotion::where('status', 'scheduled')->count(),
                'draft' => Promotion::where('status', 'draft')->count(),
                'this_month' => Promotion::whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
            ];
        } catch (Exception $e) {
            Log::error('Error loading promotion stats', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
            return [
                'total' => 0,
                'active' => 0,
                'sent' => 0,
                'scheduled' => 0,
                'draft' => 0,
                'this_month' => 0,
            ];
        }
    }

    public function render()
    {
        return view('livewire.promotions.index', [
            'promotions' => $this->promotions,
            'stats' => $this->stats,
        ]);
    }
}