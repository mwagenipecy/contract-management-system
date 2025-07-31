<div>
{{-- resources/views/livewire/reminders/create.blade.php --}}

<div class="px-4 sm:px-6 lg:px-8">
    {{-- Header --}}
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Create New Reminder</h1>
            <p class="mt-2 text-sm text-gray-700">Set up tracking for licenses, events, contracts, and other important deadlines.</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('reminders.dashboard') }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Dashboard
            </a>
        </div>
    </div>

    <div class="max-w-5xl mx-auto">
        <form wire:submit.prevent="save" class="space-y-8">
            {{-- Category Selection --}}
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-6">Select Reminder Type</h3>
                    
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($categories as $category)
                        <label class="relative flex cursor-pointer rounded-lg border p-4 focus:outline-none {{ $category_id == $category->id ? 'border-indigo-500 ring-2 ring-indigo-500' : 'border-gray-300' }}">
                            <input wire:model.live="category_id" 
                                   type="radio" 
                                   value="{{ $category->id }}"
                                   class="sr-only">
                            <span class="flex flex-1">
                                <span class="flex flex-col">
                                    <span class="flex items-center mb-2">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3" 
                                             style="background-color: {{ $category->color }}20; color: {{ $category->color }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                @if($category->icon === 'shield-check')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                                @elseif($category->icon === 'document-text')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                @elseif($category->icon === 'heart')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                @elseif($category->icon === 'calendar')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h8a2 2 0 012 2v4m0 0V7a2 2 0 11-4 0V3M8 7V3a2 2 0 014 0v4m0 0v8a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h4z"></path>
                                                @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5l-5-5h5v-2a4 4 0 01-4-4V9a3 3 0 013-3h4a3 3 0 013 3v1a4 4 0 01-4 4v2z"></path>
                                                @endif
                                            </svg>
                                        </div>
                                        <span class="block text-sm font-medium text-gray-900">{{ $category->name }}</span>
                                    </span>
                                    <span class="block text-xs text-gray-500 mb-2">{{ $category->description }}</span>
                                    <div class="flex flex-wrap gap-1">
                                        @if($category->has_start_end_dates)
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Start/End Dates</span>
                                        @endif
                                        @if($category->is_renewable)
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Renewable</span>
                                        @endif
                                        @if($category->reminder_type === 'event')
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">Event</span>
                                        @endif
                                    </div>
                                </span>
                            </span>
                        </label>
                        @endforeach
                    </div>
                    
                    @error('category_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            @if($selectedCategory)
            {{-- Basic Information --}}
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-6">Basic Information</h3>
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        {{-- Title --}}
                        <div class="sm:col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-700">
                                Title <span class="text-red-500">*</span>
                            </label>
                            <input wire:model="title" 
                                   type="text" 
                                   id="title"
                                   placeholder="e.g., Business License Renewal, TAA Operating Permit, Staff Christmas Gifts"
                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="sm:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700">
                                Description
                            </label>
                            <textarea wire:model="description" 
                                      id="description"
                                      rows="3"
                                      placeholder="Provide detailed information about this {{ strtolower($selectedCategory->reminder_type) }}..."
                                      class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Reference Number --}}
                        <div>
                            <label for="reference_number" class="block text-sm font-medium text-gray-700">
                                Reference Number
                            </label>
                            <input wire:model="reference_number" 
                                   type="text" 
                                   id="reference_number"
                                   placeholder="License #, Contract #, etc."
                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('reference_number')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Priority --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Priority <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
                                @foreach(['low' => ['color' => 'green', 'label' => 'Low'], 'medium' => ['color' => 'yellow', 'label' => 'Medium'], 'high' => ['color' => 'orange', 'label' => 'High'], 'critical' => ['color' => 'red', 'label' => 'Critical']] as $priorityValue => $priorityConfig)
                                <label class="relative flex cursor-pointer rounded-lg border p-3 focus:outline-none {{ $priority === $priorityValue ? 'border-' . $priorityConfig['color'] . '-500 ring-2 ring-' . $priorityConfig['color'] . '-500' : 'border-gray-300' }}">
                                    <input wire:model.live="priority" 
                                           type="radio" 
                                           value="{{ $priorityValue }}"
                                           class="sr-only">
                                    <span class="flex flex-1 flex-col">
                                        <span class="block text-sm font-medium text-gray-900">{{ $priorityConfig['label'] }}</span>
                                        <span class="mt-1 flex items-center text-sm text-gray-500">
                                            <span class="h-2 w-2 bg-{{ $priorityConfig['color'] }}-500 rounded-full mr-2"></span>
                                            {{ ucfirst($priorityValue) }}
                                        </span>
                                    </span>
                                </label>
                                @endforeach
                            </div>
                            @error('priority')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Date Configuration --}}
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-6">
                        Date Configuration
                        <span class="ml-2 inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $selectedCategory->color === '#ef4444' ? 'red' : ($selectedCategory->color === '#f59e0b' ? 'yellow' : 'indigo') }}-100 text-{{ $selectedCategory->color === '#ef4444' ? 'red' : ($selectedCategory->color === '#f59e0b' ? 'yellow' : 'indigo') }}-800">
                            {{ ucfirst($selectedCategory->reminder_type) }}
                        </span>
                    </h3>
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @if($selectedCategory->reminder_type === 'event')
                            {{-- Event Date --}}
                            <div class="sm:col-span-2">
                                <label for="event_date" class="block text-sm font-medium text-gray-700">
                                    Event Date <span class="text-red-500">*</span>
                                </label>
                                <input wire:model.live="event_date" 
                                       type="date" 
                                       id="event_date"
                                       min="{{ date('Y-m-d') }}"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <p class="mt-1 text-xs text-gray-500">When will this event take place?</p>
                                @error('event_date')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @elseif($selectedCategory->has_start_end_dates)
                            {{-- Start Date --}}
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">
                                    Start Date <span class="text-red-500">*</span>
                                </label>
                                <input wire:model.live="start_date" 
                                       type="date" 
                                       id="start_date"
                                       min="{{ date('Y-m-d') }}"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <p class="mt-1 text-xs text-gray-500">When does this {{ strtolower($selectedCategory->reminder_type) }} begin?</p>
                                @error('start_date')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- End Date --}}
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">
                                    End Date <span class="text-red-500">*</span>
                                </label>
                                <input wire:model.live="end_date" 
                                       type="date" 
                                       id="end_date"
                                       min="{{ $start_date ?: date('Y-m-d') }}"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <p class="mt-1 text-xs text-gray-500">When does this {{ strtolower($selectedCategory->reminder_type) }} expire?</p>
                                @error('end_date')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            @if($selectedCategory->is_renewable)
                            {{-- Renewal Date --}}
                            <div>
                                <label for="renewal_date" class="block text-sm font-medium text-gray-700">
                                    Next Renewal Date
                                </label>
                                <input wire:model="renewal_date" 
                                       type="date" 
                                       id="renewal_date"
                                       min="{{ $end_date ?: date('Y-m-d') }}"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <p class="mt-1 text-xs text-gray-500">When should this be renewed next?</p>
                                @error('renewal_date')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            @endif
                        @else
                            {{-- Due Date --}}
                            <div class="sm:col-span-2">
                                <label for="due_date" class="block text-sm font-medium text-gray-700">
                                    Due Date <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="due_date" 
                                       type="date" 
                                       id="due_date"
                                       min="{{ date('Y-m-d') }}"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <p class="mt-1 text-xs text-gray-500">When does this need to be completed?</p>
                                @error('due_date')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Custom Fields (Dynamic based on category) --}}
            @if(!empty($fieldConfiguration['required']) || !empty($fieldConfiguration['optional']))
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-6">Additional Information</h3>
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        @foreach(array_merge($fieldConfiguration['required'] ?? [], $fieldConfiguration['optional'] ?? []) as $field)
                            @if(!in_array($field, ['title', 'description', 'due_date', 'start_date', 'end_date', 'event_date', 'priority', 'amount', 'vendor_supplier']))
                            <div>
                                <label for="custom_{{ $field }}" class="block text-sm font-medium text-gray-700">
                                    {{ ucwords(str_replace('_', ' ', $field)) }}
                                    @if(in_array($field, $fieldConfiguration['required'] ?? []))
                                    <span class="text-red-500">*</span>
                                    @endif
                                </label>
                                
                                @if($this->getDynamicFieldType($field) === 'select')
                                    <select wire:model="custom_fields.{{ $field }}" 
                                            id="custom_{{ $field }}"
                                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                        <option value="">Select {{ str_replace('_', ' ', $field) }}</option>
                                        @foreach($this->getDynamicFieldOptions($field) as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input wire:model="custom_fields.{{ $field }}" 
                                           type="{{ $this->getDynamicFieldType($field) }}" 
                                           id="custom_{{ $field }}"
                                           placeholder="Enter {{ str_replace('_', ' ', $field) }}"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @endif
                                
                                @error("custom_fields.{$field}")
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            {{-- Financial Information --}}
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-6">Financial & Vendor Information</h3>
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        {{-- Amount --}}
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700">
                                Amount/Cost
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input wire:model="amount" 
                                       type="number" 
                                       id="amount"
                                       step="0.01"
                                       min="0"
                                       placeholder="0.00"
                                       class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pr-20 sm:text-sm border-gray-300 rounded-md">
                                <div class="absolute inset-y-0 right-0 flex items-center">
                                    <select wire:model="currency" 
                                            class="focus:ring-indigo-500 focus:border-indigo-500 h-full py-0 pl-2 pr-7 border-transparent bg-transparent text-gray-500 sm:text-sm rounded-md">
                                        <option value="TZS">TZS</option>
                                        <option value="USD">USD</option>
                                        <option value="EUR">EUR</option>
                                        <option value="KES">KES</option>
                                        <option value="UGX">UGX</option>
                                    </select>
                                </div>
                            </div>
                            @error('amount')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Vendor/Supplier --}}
                        <div>
                            <label for="vendor_supplier" class="block text-sm font-medium text-gray-700">
                                Vendor/Supplier/Agency
                            </label>
                            <input wire:model="vendor_supplier" 
                                   type="text" 
                                   id="vendor_supplier"
                                   placeholder="e.g., Tanzania Revenue Authority, KIA, City Council"
                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('vendor_supplier')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Employee Assignment --}}
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Employee Assignment & Notifications</h3>
                        <button type="button" 
                                wire:click="openAssignmentModal"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200">
                            <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Assign Employee
                        </button>
                    </div>
                    
                    @if(empty($assigned_employees))
                    <div class="text-center py-6 border-2 border-dashed border-gray-300 rounded-lg">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No employees assigned</h3>
                        <p class="mt-1 text-sm text-gray-500">Assign at least one employee to handle this reminder.</p>
                    </div>
                    @else
                    <div class="space-y-3">
                        @foreach($assigned_employees as $index => $assignment)
                            @php $employeeDetails = $this->getEmployeeDetails($assignment['employee_id']) @endphp
                            @if($employeeDetails)
                            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                            <span class="text-sm font-medium text-indigo-700">{{ substr($employeeDetails['name'], 0, 2) }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">{{ $employeeDetails['name'] }}</h4>
                                        <p class="text-sm text-gray-500">{{ $employeeDetails['email'] }} • {{ $employeeDetails['department'] }}</p>
                                        <div class="flex items-center space-x-2 mt-1">
                                            <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium 
                                                {{ $assignment['role'] === 'responsible' ? 'bg-blue-100 text-blue-800' : 
                                                   ($assignment['role'] === 'approver' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800') }}">
                                                {{ ucfirst($assignment['role']) }}
                                            </span>
                                            <span class="text-xs text-gray-400">•</span>
                                            <span class="text-xs text-gray-600">
                                                {{ implode(', ', array_map('ucfirst', $assignment['notification_methods'])) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" 
                                        wire:click="removeAssignment({{ $index }})"
                                        class="text-red-600 hover:text-red-500">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                            @endif
                        @endforeach
                    </div>
                    @endif
                    
                    @error('assigned_employees')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Notification Settings --}}
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Notification Settings</h3>
                        <button type="button" 
                                wire:click="toggleCustomNotifications"
                                class="text-sm text-indigo-600 hover:text-indigo-500">
                            {{ $custom_notifications ? 'Use category defaults' : 'Customize notifications' }}
                        </button>
                    </div>
                    
                    @if(!$custom_notifications && $selectedCategory)
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Category Default Settings</h4>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <p class="text-sm text-gray-600 mb-2">Notification Periods:</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($selectedCategory->default_notification_periods ?? [30, 7, 1] as $period)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                        {{ $period }} day{{ $period != 1 ? 's' : '' }} before
                                    </span>
                                    @endforeach
                                </div>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-2">Notification Methods:</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($selectedCategory->getNotificationMethods() as $method)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ ucfirst($method) }}
                                    </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($custom_notifications)
                    <div class="space-y-6">
                        {{-- Custom Notification Periods --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Notification Periods (days before due date)
                            </label>
                            <div class="space-y-3">
                                @foreach($notification_periods as $index => $period)
                                <div class="flex items-center space-x-3">
                                    <input wire:model="notification_periods.{{ $index }}" 
                                           type="number" 
                                           min="1" 
                                           max="365"
                                           placeholder="Days"
                                           class="block w-24 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md">
                                    <span class="text-sm text-gray-500">days before due date</span>
                                    @if(count($notification_periods) > 1)
                                    <button type="button" 
                                            wire:click="removeNotificationPeriod({{ $index }})"
                                            class="text-red-600 hover:text-red-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                    @endif
                                </div>
                                @endforeach
                                
                                <button type="button" 
                                        wire:click="addNotificationPeriod"
                                        class="inline-flex items-center px-3 py-2 border border-dashed border-gray-300 text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add notification period
                                </button>
                            </div>
                            @error('notification_periods')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Notification Methods --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Notification Methods
                            </label>
                            <div class="space-y-3">
                                @foreach(['email' => 'Email', 'sms' => 'SMS', 'system' => 'System Notification'] as $method => $label)
                                <div class="flex items-center">
                                    <input wire:model="notification_methods" 
                                           id="method_{{ $method }}" 
                                           type="checkbox" 
                                           value="{{ $method }}"
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="method_{{ $method }}" class="ml-3 block text-sm text-gray-700">
                                        {{ $label }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Additional Information --}}
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-6">Additional Information</h3>
                    
                    <div class="space-y-6">
                        {{-- Notes --}}
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700">
                                Notes & Instructions
                            </label>
                            <textarea wire:model="notes" 
                                      id="notes"
                                      rows="4"
                                      placeholder="Add any additional notes, requirements, contact information, or special instructions..."
                                      class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                            @error('notes')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- File Upload --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Supporting Documents
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-indigo-400 transition-colors"
                                 data-file-upload>
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="documents" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Upload files</span>
                                            <input wire:model="documents" 
                                                   id="documents" 
                                                   type="file" 
                                                   multiple 
                                                   accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.xlsx,.xls"
                                                   class="sr-only">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        PDF, DOC, JPG, PNG, XLS up to 10MB each
                                    </p>
                                </div>
                            </div>
                            
                            @if($documents)
                            <div class="mt-4 space-y-2">
                                @foreach($documents as $index => $document)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-md border">
                                    <div class="flex items-center space-x-3">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <div>
                                            <span class="text-sm font-medium text-gray-900">{{ $document->getClientOriginalName() }}</span>
                                            <p class="text-xs text-gray-500">{{ round($document->getSize() / 1024, 1) }} KB</p>
                                        </div>
                                    </div>
                                    <button type="button" 
                                            wire:click="removeDocument({{ $index }})"
                                            class="text-red-600 hover:text-red-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                @endforeach
                            </div>
                            @endif
                            
                            @error('documents')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-between pt-8 border-t border-gray-200">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('reminders.dashboard') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Cancel
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span wire:loading.remove wire:target="save">Create Reminder</span>
                        <span wire:loading wire:target="save">Creating...</span>
                    </button>
                </div>
            </div>
            @endif
        </form>
    </div>

    {{-- Employee Assignment Modal --}}
    @if($showAssignmentModal)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75" wire:click="closeAssignmentModal"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                Assign Employee
                            </h3>
                            
                            <div class="space-y-4">
                                {{-- Employee Selection --}}
                                <div>
                                    <label for="temp_employee" class="block text-sm font-medium text-gray-700">
                                        Employee <span class="text-red-500">*</span>
                                    </label>
                                    <select wire:model="tempAssignment.employee_id" 
                                            id="temp_employee"
                                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                        <option value="">Select an employee</option>
                                        @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}">
                                            {{ $employee->name }} - {{ $employee->department }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('tempAssignment.employee_id')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Role Selection --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-3">
                                        Role <span class="text-red-500">*</span>
                                    </label>
                                    <div class="space-y-2">
                                        @foreach(['responsible' => 'Responsible (Primary handler)', 'informed' => 'Informed (Receives updates)', 'approver' => 'Approver (Can approve completion)', 'backup' => 'Backup (Secondary contact)'] as $role => $description)
                                        <label class="flex items-start">
                                            <input wire:model="tempAssignment.role" 
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

                                {{-- Notification Methods --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-3">
                                        Notification Methods <span class="text-red-500">*</span>
                                    </label>
                                    <div class="space-y-2">
                                        @foreach(['email' => 'Email notifications', 'sms' => 'SMS alerts'] as $method => $label)
                                        <label class="flex items-center">
                                            <input wire:model="tempAssignment.notification_methods" 
                                                   type="checkbox" 
                                                   value="{{ $method }}"
                                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                            <span class="ml-3 text-sm text-gray-700">{{ $label }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                    @error('tempAssignment.notification_methods')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="addAssignment" 
                            type="button" 
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Add Assignment
                    </button>
                    <button wire:click="closeAssignmentModal" 
                            type="button" 
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Loading Overlay --}}
    <div wire:loading wire:target="save" class="fixed inset-0 z-50 bg-gray-500 bg-opacity-75 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 flex items-center space-x-4">
            <svg class="animate-spin h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <div>
                <p class="text-lg font-medium text-gray-900">Creating Reminder</p>
                <p class="text-sm text-gray-500">Setting up notifications and assignments...</p>
            </div>
        </div>
    </div>
</div>

</div>
