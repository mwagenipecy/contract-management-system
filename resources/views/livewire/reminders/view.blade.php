<div>
{{-- resources/views/livewire/reminders/view.blade.php --}}

<div class="px-4 sm:px-6 lg:px-8">
    {{-- Header --}}
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div class="flex-1 min-w-0">
            <div class="flex items-center space-x-3">
                <a href="{{ route('reminders.dashboard') }}" 
                   class="text-gray-400 hover:text-gray-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    @if($isEditing)
                    <input wire:model="editForm.title" 
                           class="text-2xl font-bold text-gray-900 border-b border-gray-300 bg-transparent focus:outline-none focus:border-indigo-500">
                    @else
                    <h1 class="text-2xl font-bold text-gray-900">{{ $reminder->title }}</h1>
                    @endif
                    <div class="flex items-center space-x-2 mt-1">
                        <span class="{{ $this->getPriorityBadgeClass() }}">
                            {{ ucfirst($reminder->priority) }}
                        </span>
                        <span class="{{ $this->getStatusBadgeClass() }}">
                            {{ $reminder->status_badge['text'] }}
                        </span>
                        <span class="text-sm text-gray-500">
                            {{ $reminder->category->name }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Action Buttons --}}
        <div class="mt-4 sm:mt-0 flex items-center space-x-3">
            @if($reminder->status === 'pending_approval')
                <button wire:click="approveReminder" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                    <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Approve
                </button>
                <button wire:click="rejectReminder" 
                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Reject
                </button>
            @endif

            @if($reminder->status === 'active')
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Actions
                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-cloak
                         class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10 border border-gray-200">
                        <div class="py-1">
                            <button wire:click="openCompleteModal" @click="open = false"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Mark Complete
                            </button>
                            @if($reminder->category->is_renewable)
                            <button wire:click="openRenewModal" @click="open = false"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Renew
                            </button>
                            @endif
                            <button wire:click="openSnoozeModal" @click="open = false"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Snooze
                            </button>
                            <button wire:click="openNotificationModal" @click="open = false"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Send Notification
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            @if($isEditing)
                <button wire:click="saveEdit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    Save Changes
                </button>
                <button wire:click="cancelEdit" 
                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Cancel
                </button>
            @else
                <button wire:click="startEdit" 
                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </button>
            @endif
        </div>
    </div>

    <div class="max-w-6xl mx-auto">
        {{-- Key Information Bar --}}
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-6 py-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Due Date</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            @if($isEditing)
                                <input wire:model="editForm.due_date" 
                                       type="date" 
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @else
                                {{ $reminder->effective_due_date->format('M d, Y') }}
                                @if($reminder->isOverdue())
                                    <span class="ml-2 text-red-600 text-xs font-medium">
                                        ({{ abs($reminder->days_until_due) }} days overdue)
                                    </span>
                                @elseif($reminder->isDueSoon())
                                    <span class="ml-2 text-yellow-600 text-xs font-medium">
                                        ({{ $reminder->days_until_due }} days left)
                                    </span>
                                @endif
                            @endif
                        </dd>
                    </div>
                    
                    @if($reminder->amount)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Amount</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            @if($isEditing)
                                <input wire:model="editForm.amount" 
                                       type="number" 
                                       step="0.01"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @else
                                {{ $reminder->formatted_amount }}
                            @endif
                        </dd>
                    </div>
                    @endif
                    
                    @if($reminder->vendor_supplier)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Vendor/Supplier</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            @if($isEditing)
                                <input wire:model="editForm.vendor_supplier" 
                                       type="text" 
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @else
                                {{ $reminder->vendor_supplier }}
                            @endif
                        </dd>
                    </div>
                    @endif
                    
                    @if($reminder->reference_number)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Reference #</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            @if($isEditing)
                                <input wire:model="editForm.reference_number" 
                                       type="text" 
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @else
                                {{ $reminder->reference_number }}
                            @endif
                        </dd>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Tabs Navigation --}}
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-8">
                <button wire:click="setTab('details')" 
                        class="py-2 px-1 border-b-2 font-medium text-sm whitespace-nowrap {{ $activeTab === 'details' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Details
                </button>
                <button wire:click="setTab('assignments')" 
                        class="py-2 px-1 border-b-2 font-medium text-sm whitespace-nowrap {{ $activeTab === 'assignments' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Assignments
                    @if($reminder->assignments->count())
                    <span class="ml-2 bg-gray-100 text-gray-600 py-0.5 px-2.5 rounded-full text-xs font-medium">
                        {{ $reminder->assignments->count() }}
                    </span>
                    @endif
                </button>
                <button wire:click="setTab('notifications')" 
                        class="py-2 px-1 border-b-2 font-medium text-sm whitespace-nowrap {{ $activeTab === 'notifications' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Notifications
                </button>
                <button wire:click="setTab('documents')" 
                        class="py-2 px-1 border-b-2 font-medium text-sm whitespace-nowrap {{ $activeTab === 'documents' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Documents
                    @if($reminder->documents && count($reminder->documents))
                    <span class="ml-2 bg-gray-100 text-gray-600 py-0.5 px-2.5 rounded-full text-xs font-medium">
                        {{ count($reminder->documents) }}
                    </span>
                    @endif
                </button>
                @if($reminder->renewals->count())
                <button wire:click="setTab('history')" 
                        class="py-2 px-1 border-b-2 font-medium text-sm whitespace-nowrap {{ $activeTab === 'history' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    History
                </button>
                @endif
            </nav>
        </div>

        {{-- Tab Content --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Main Content --}}
            <div class="lg:col-span-2">
                {{-- Details Tab --}}
                @if($activeTab === 'details')
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Reminder Details</h3>
                    </div>
                    <div class="px-6 py-4 space-y-6">
                        {{-- Description --}}
                        @if($reminder->description || $isEditing)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            @if($isEditing)
                                <textarea wire:model="editForm.description" 
                                          rows="4"
                                          class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                          placeholder="Enter description..."></textarea>
                            @else
                                <p class="text-sm text-gray-900">{{ $reminder->description ?: 'No description provided.' }}</p>
                            @endif
                        </div>
                        @endif

                        {{-- Priority --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Priority</label>
                            @if($isEditing)
                                <select wire:model="editForm.priority" 
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                    <option value="critical">Critical</option>
                                </select>
                            @else
                                <span class="{{ $this->getPriorityBadgeClass() }}">
                                    {{ ucfirst($reminder->priority) }}
                                </span>
                            @endif
                        </div>

                        {{-- Date Information --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if($reminder->category->has_start_end_dates)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                                    @if($isEditing)
                                        <input wire:model="editForm.start_date" 
                                               type="date" 
                                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @else
                                        <p class="text-sm text-gray-900">{{ $reminder->start_date?->format('M d, Y') ?? 'Not set' }}</p>
                                    @endif
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                                    @if($isEditing)
                                        <input wire:model="editForm.end_date" 
                                               type="date" 
                                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @else
                                        <p class="text-sm text-gray-900">{{ $reminder->end_date?->format('M d, Y') ?? 'Not set' }}</p>
                                    @endif
                                </div>
                            @elseif($reminder->category->reminder_type === 'event')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Event Date</label>
                                    @if($isEditing)
                                        <input wire:model="editForm.event_date" 
                                               type="date" 
                                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @else
                                        <p class="text-sm text-gray-900">{{ $reminder->event_date?->format('M d, Y') ?? 'Not set' }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>

                        {{-- Custom Fields --}}
                        @if($reminder->custom_fields && count($reminder->custom_fields) > 0)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Additional Information</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($reminder->custom_fields as $field => $value)
                                    @if($value)
                                    <div>
                                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">
                                            {{ ucwords(str_replace('_', ' ', $field)) }}
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $value }}</dd>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @endif

                        {{-- Notes --}}
                        @if($reminder->notes || $isEditing)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                            @if($isEditing)
                                <textarea wire:model="editForm.notes" 
                                          rows="4"
                                          class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                          placeholder="Add notes..."></textarea>
                            @else
                                <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $reminder->notes ?: 'No notes added.' }}</p>
                            @endif
                        </div>
                        @endif

                        {{-- Completion Notes --}}
                        @if($reminder->status === 'completed' && $reminder->completion_notes)
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-green-800 mb-2">Completion Notes</h4>
                            <p class="text-sm text-green-700">{{ $reminder->completion_notes }}</p>
                            <p class="text-xs text-green-600 mt-2">
                                Completed on {{ $reminder->completed_at->format('M d, Y \a\t g:i A') }}
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Assignments Tab --}}
                @if($activeTab === 'assignments')
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Assigned Employees</h3>
                        <button wire:click="openAssignmentModal" 
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200">
                            <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Assignment
                        </button>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @forelse($reminder->assignments as $assignment)
                        <div class="px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                            <span class="text-sm font-medium text-indigo-700">
                                                {{ substr($assignment->employee->name, 0, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">{{ $assignment->employee->name }}</h4>
                                        <p class="text-sm text-gray-500">{{ $assignment->employee->email }}</p>
                                        <div class="flex items-center space-x-2 mt-1">
                                            <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium 
                                                {{ $assignment->role === 'responsible' ? 'bg-blue-100 text-blue-800' : 
                                                   ($assignment->role === 'approver' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800') }}">
                                                {{ ucfirst($assignment->role) }}
                                            </span>
                                            @if($assignment->notification_methods)
                                            <span class="text-xs text-gray-400">•</span>
                                            <span class="text-xs text-gray-600">
                                                {{ implode(', ', array_map('ucfirst', $assignment->notification_methods)) }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <button wire:click="removeAssignment({{ $assignment->id }})" 
                                        onclick="return confirm('Remove this assignment?')"
                                        class="text-red-600 hover:text-red-500">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @empty
                        <div class="px-6 py-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No assignments</h3>
                            <p class="mt-1 text-sm text-gray-500">Assign employees to handle this reminder.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
                @endif

                {{-- Notifications Tab --}}
                @if($activeTab === 'notifications')
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Notification History</h3>
                        <button wire:click="openNotificationModal" 
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200">
                            Send Notification
                        </button>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @forelse($reminder->notifications()->latest()->get() as $notification)
                        <div class="px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm font-medium text-gray-900">
                                            {{ $notification->employee->name }}
                                        </span>
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium 
                                            {{ $notification->status === 'sent' ? 'bg-green-100 text-green-800' : 
                                               ($notification->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($notification->status) }}
                                        </span>
                                        <span class="text-xs text-gray-500">via {{ ucfirst($notification->method) }}</span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">{{ $notification->message }}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        @if($notification->status === 'sent')
                                            Sent {{ $notification->sent_at->diffForHumans() }}
                                        @else
                                            Scheduled for {{ $notification->scheduled_at->format('M d, Y \a\t g:i A') }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="px-6 py-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5-5-5h5V7a1 1 0 011-1h4a1 1 0 011 1v10z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No notifications</h3>
                            <p class="mt-1 text-sm text-gray-500">Notification history will appear here.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
                @endif

                {{-- Documents Tab --}}
                @if($activeTab === 'documents')
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Documents</h3>
                    </div>
                    <div class="px-6 py-4">
                        {{-- Upload Area --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Upload Documents</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-indigo-400 transition-colors">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="newDocuments" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Upload files</span>
                                            <input wire:model="newDocuments" 
                                                   id="newDocuments" 
                                                   type="file" 
                                                   multiple 
                                                   accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.xlsx,.xls"
                                                   class="sr-only">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PDF, DOC, JPG, PNG, XLS up to 10MB each</p>
                                </div>
                            </div>
                            
                            @if($newDocuments)
                            <div class="mt-4">
                                <button wire:click="uploadDocuments" 
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                    Upload {{ count($newDocuments) }} File{{ count($newDocuments) > 1 ? 's' : '' }}
                                </button>
                            </div>
                            @endif
                        </div>

                        {{-- Existing Documents --}}
                        @if($reminder->documents && count($reminder->documents) > 0)
                        <div class="space-y-3">
                            @foreach($reminder->documents as $index => $document)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-md border">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">{{ $document['name'] }}</h4>
                                        <p class="text-xs text-gray-500">
                                            {{ round($document['size'] / 1024, 1) }} KB
                                            @if(isset($document['uploaded_at']))
                                            • Uploaded {{ \Carbon\Carbon::parse($document['uploaded_at'])->diffForHumans() }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ Storage::disk('public')->url($document['path']) }}" 
                                       target="_blank"
                                       class="text-indigo-600 hover:text-indigo-500 text-sm">
                                        View
                                    </a>
                                    <button wire:click="removeDocument({{ $index }})" 
                                            onclick="return confirm('Remove this document?')"
                                            class="text-red-600 hover:text-red-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No documents</h3>
                            <p class="mt-1 text-sm text-gray-500">Upload documents related to this reminder.</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                {{-- History Tab --}}
                @if($activeTab === 'history')
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Renewal History</h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @foreach($reminder->renewals()->latest()->get() as $renewal)
                        <div class="px-6 py-4">
                            <div class="flex items-start justify-between">
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm font-medium text-gray-900">Renewed</span>
                                        <span class="text-xs text-gray-500">
                                            {{ $renewal->renewed_at->format('M d, Y \a\t g:i A') }}
                                        </span>
                                    </div>
                                    <div class="mt-2 text-sm text-gray-600 space-y-1">
                                        <p><strong>Previous:</strong> {{ $renewal->previous_start_date->format('M d, Y') }} - {{ $renewal->previous_end_date->format('M d, Y') }}</p>
                                        <p><strong>New:</strong> {{ $renewal->new_start_date->format('M d, Y') }} - {{ $renewal->new_end_date->format('M d, Y') }}</p>
                                        @if($renewal->renewal_amount)
                                        <p><strong>Amount:</strong> {{ $reminder->currency }} {{ number_format($renewal->renewal_amount, 2) }}</p>
                                        @endif
                                        @if($renewal->renewal_notes)
                                        <p><strong>Notes:</strong> {{ $renewal->renewal_notes }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1">
                {{-- Quick Info Card --}}
                <div class="bg-white shadow rounded-lg mb-6">
                    <div class="px-6 py-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Info</h3>
                        <dl class="space-y-3">
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Category</dt>
                                <dd class="text-sm text-gray-900">{{ $reminder->category->name }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Created</dt>
                                <dd class="text-sm text-gray-900">{{ $reminder->created_at->format('M d, Y') }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Created by</dt>
                                <dd class="text-sm text-gray-900">{{ $reminder->createdBy->name ?? 'System' }}</dd>
                            </div>
                            @if($reminder->approved_by)
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Approved by</dt>
                                <dd class="text-sm text-gray-900">{{ $reminder->approvedBy->name }}</dd>
                            </div>
                            @endif
                            @if($reminder->category->is_renewable)
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Renewable</dt>
                                <dd class="text-sm text-gray-900">
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Yes
                                    </span>
                                </dd>
                            </div>
                            @endif
                        </dl>
                    </div>
                </div>

                {{-- Actions Card --}}
                @if($reminder->status === 'active')
                <div class="bg-white shadow rounded-lg mb-6">
                    <div class="px-6 py-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                        <div class="space-y-3">
                            <button wire:click="openCompleteModal" 
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Mark Complete
                            </button>
                            
                            @if($reminder->category->is_renewable)
                            <button wire:click="openRenewModal" 
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Renew
                            </button>
                            @endif
                            
                            <button wire:click="openSnoozeModal" 
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Snooze
                            </button>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Danger Zone --}}
                <div class="bg-white shadow rounded-lg border border-red-200">
                    <div class="px-6 py-4">
                        <h3 class="text-lg font-medium text-red-900 mb-4">Danger Zone</h3>
                        <button wire:click="openDeleteModal" 
                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-red-600 text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50">
                            <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Reminder
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modals --}}
    {{-- Complete Modal --}}
    @if($showCompleteModal)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Complete Reminder</h3>
                    <button wire:click="closeCompleteModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="mb-4">
                    <p class="text-sm text-gray-600">Mark this reminder as completed. This action cannot be undone.</p>
                </div>

                <div class="mb-4">
                    <label for="completionNotes" class="block text-sm font-medium text-gray-700 mb-2">
                        Completion Notes (Optional)
                    </label>
                    <textarea wire:model="completionNotes" id="completionNotes" rows="3"
                              class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                              placeholder="Add any notes about the completion..."></textarea>
                </div>

                <div class="flex justify-end space-x-3">
                    <button wire:click="closeCompleteModal" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Cancel
                    </button>
                    <button wire:click="completeReminder" 
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                        Mark Complete
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Renew Modal --}}
    @if($showRenewModal)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Renew Reminder</h3>
                    <button wire:click="closeRenewModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label for="renewalEndDate" class="block text-sm font-medium text-gray-700 mb-1">
                            New End Date <span class="text-red-500">*</span>
                        </label>
                        <input wire:model="renewalForm.end_date" type="date" id="renewalEndDate" required
                               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('renewalForm.end_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="renewalAmount" class="block text-sm font-medium text-gray-700 mb-1">
                            Amount
                        </label>
                        <input wire:model="renewalForm.amount" type="number" step="0.01" id="renewalAmount"
                               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('renewalForm.amount') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="renewalNotes" class="block text-sm font-medium text-gray-700 mb-1">
                            Renewal Notes (Optional)
                        </label>
                        <textarea wire:model="renewalForm.notes" id="renewalNotes" rows="3"
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                  placeholder="Add any notes about the renewal..."></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Documents (Optional)
                        </label>
                        <input wire:model="renewalForm.documents" type="file" multiple
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <button wire:click="closeRenewModal" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Cancel
                    </button>
                    <button wire:click="renewReminder" 
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                        Renew Item
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Snooze Modal --}}
    @if($showSnoozeModal)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Snooze Reminder</h3>
                    <button wire:click="closeSnoozeModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label for="snoozeDays" class="block text-sm font-medium text-gray-700 mb-1">
                            Snooze for (days) <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="snoozeForm.days" id="snoozeDays"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="1">1 day</option>
                            <option value="3">3 days</option>
                            <option value="7">1 week</option>
                            <option value="14">2 weeks</option>
                            <option value="30">1 month</option>
                            <option value="90">3 months</option>
                        </select>
                        @error('snoozeForm.days') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="snoozeReason" class="block text-sm font-medium text-gray-700 mb-1">
                            Reason (Optional)
                        </label>
                        <textarea wire:model="snoozeForm.reason" id="snoozeReason" rows="3"
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                  placeholder="Why are you snoozing this reminder?"></textarea>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <button wire:click="closeSnoozeModal" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Cancel
                    </button>
                    <button wire:click="snoozeReminder" 
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700">
                        Snooze
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Assignment Modal --}}
    @if($showAssignmentModal)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Assign Employee</h3>
                    <button wire:click="closeAssignmentModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label for="assignEmployee" class="block text-sm font-medium text-gray-700 mb-1">
                            Employee <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="assignmentForm.employee_id" id="assignEmployee"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Select an employee</option>
                            @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">
                                {{ $employee->name }} - {{ $employee->department }}
                            </option>
                            @endforeach
                        </select>
                        @error('assignmentForm.employee_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Role <span class="text-red-500">*</span>
                        </label>
                        <div class="space-y-2">
                            @foreach(['responsible' => 'Responsible (Primary handler)', 'informed' => 'Informed (Receives updates)', 'approver' => 'Approver (Can approve completion)', 'backup' => 'Backup (Secondary contact)'] as $role => $description)
                            <label class="flex items-start">
                                <input wire:model="assignmentForm.role" 
                                       type="radio" 
                                       value="{{ $role }}"
                                       class="mt-1 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                <div class="ml-3">
                                    <span class="text-sm font-medium text-gray-900">{{ ucfirst($role) }}</span>
                                    <p class="text-xs text-gray-500">{{ explode('(', $description)[1] ?? $description }}</p>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Notification Methods <span class="text-red-500">*</span>
                        </label>
                        <div class="space-y-2">
                            @foreach(['email' => 'Email notifications', 'sms' => 'SMS alerts'] as $method => $label)
                            <label class="flex items-center">
                                <input wire:model="assignmentForm.notification_methods" 
                                       type="checkbox" 
                                       value="{{ $method }}"
                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <span class="ml-3 text-sm text-gray-700">{{ $label }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <button wire:click="closeAssignmentModal" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Cancel
                    </button>
                    <button wire:click="addAssignment" 
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                        Add Assignment
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Notification Modal --}}
    @if($showNotificationModal)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Send Notification</h3>
                    <button wire:click="closeNotificationModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Recipients</label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input wire:model="notificationForm.recipient_type" 
                                       type="radio" 
                                       value="assigned"
                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                <span class="ml-3 text-sm text-gray-700">Assigned employees only</span>
                            </label>
                            <label class="flex items-center">
                                <input wire:model="notificationForm.recipient_type" 
                                       type="radio" 
                                       value="all"
                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                <span class="ml-3 text-sm text-gray-700">All employees</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label for="notificationMethod" class="block text-sm font-medium text-gray-700 mb-1">
                            Method
                        </label>
                        <select wire:model="notificationForm.method" id="notificationMethod"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="email">Email</option>
                            <option value="sms">SMS</option>
                            <option value="system">System Notification</option>
                        </select>
                    </div>

                    <div>
                        <label for="notificationMessage" class="block text-sm font-medium text-gray-700 mb-1">
                            Message <span class="text-red-500">*</span>
                        </label>
                        <textarea wire:model="notificationForm.message" id="notificationMessage" rows="4"
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                  placeholder="Enter your message..."></textarea>
                        @error('notificationForm.message') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <button wire:click="closeNotificationModal" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Cancel
                    </button>
                    <button wire:click="sendNotification" 
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        Send Notification
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Delete Modal --}}
    @if($showDeleteModal)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-red-900">Delete Reminder</h3>
                    <button wire:click="closeDeleteModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="mb-4">
                    <div class="flex items-center mb-3">
                        <svg class="h-6 w-6 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <span class="text-sm font-medium text-red-900">Warning</span>
                    </div>
                    <p class="text-sm text-gray-600">
                        Are you sure you want to delete this reminder? This action cannot be undone and will remove all associated data including assignments, notifications, and documents.
                    </p>
                </div>

                <div class="flex justify-end space-x-3">
                    <button wire:click="closeDeleteModal" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Cancel
                    </button>
                    <button wire:click="deleteReminder" 
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                        Delete Reminder
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Loading Overlay --}}
    <div wire:loading wire:target="completeReminder,renewReminder,snoozeReminder,deleteReminder,saveEdit" 
         class="fixed inset-0 z-50 bg-gray-500 bg-opacity-75 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 flex items-center space-x-4">
            <svg class="animate-spin h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <div>
                <p class="text-lg font-medium text-gray-900">Processing</p>
                <p class="text-sm text-gray-500">Please wait...</p>
            </div>
        </div>
    </div>
</div>

</div>
