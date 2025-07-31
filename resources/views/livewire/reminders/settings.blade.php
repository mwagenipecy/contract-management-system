<div>
{{-- resources/views/livewire/reminders/settings.blade.php --}}

<div class="px-4 sm:px-6 lg:px-8">
    {{-- Header --}}
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Reminder Settings</h1>
            <p class="mt-2 text-sm text-gray-700">Configure your reminder system, categories, and notification preferences.</p>
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

    <div class="max-w-6xl mx-auto">
        {{-- Tabs Navigation --}}
        <div class="border-b border-gray-200 mb-8">
            <nav class="-mb-px flex space-x-8">
                <button wire:click="setTab('categories')" 
                        class="py-2 px-1 border-b-2 font-medium text-sm whitespace-nowrap {{ $activeTab === 'categories' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    Categories
                </button>
                <button wire:click="setTab('global')" 
                        class="py-2 px-1 border-b-2 font-medium text-sm whitespace-nowrap {{ $activeTab === 'global' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Global Settings
                </button>
                <button wire:click="setTab('notifications')" 
                        class="py-2 px-1 border-b-2 font-medium text-sm whitespace-nowrap {{ $activeTab === 'notifications' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5-5-5h5V7a1 1 0 011-1h4a1 1 0 011 1v10z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    Notifications
                </button>
            </nav>
        </div>

        {{-- Categories Tab --}}
        @if($activeTab === 'categories')
        <div class="space-y-6">
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Reminder Categories</h3>
                    <button wire:click="openCategoryModal" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Category
                    </button>
                </div>
                
                <div class="divide-y divide-gray-200">
                    @forelse($categories as $category)
                    <div class="px-6 py-4 hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center" 
                                     style="background-color: {{ $category->color }}20; color: {{ $category->color }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($category->icon === 'shield-check')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        @elseif($category->icon === 'document-text')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        @endif
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">{{ $category->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $category->description }}</p>
                                    <div class="flex items-center space-x-4 mt-1">
                                        <span class="text-xs text-gray-400">{{ ucfirst($category->reminder_type) }}</span>
                                        @if($category->has_start_end_dates)
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Start/End Dates</span>
                                        @endif
                                        @if($category->is_renewable)
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Renewable</span>
                                        @endif
                                        @if(!$category->is_active)
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Inactive</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button wire:click="editCategory({{ $category->id }})" 
                                        class="text-indigo-600 hover:text-indigo-500 text-sm font-medium">
                                    Edit
                                </button>
                                @if($category->items_count === 0)
                                <button wire:click="deleteCategory({{ $category->id }})" 
                                        onclick="return confirm('Are you sure you want to delete this category?')"
                                        class="text-red-600 hover:text-red-500 text-sm font-medium">
                                    Delete
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="px-6 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No categories</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating your first reminder category.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        @endif

        {{-- Global Settings Tab --}}
        @if($activeTab === 'global')
        <div class="space-y-6">
            <form wire:submit.prevent="saveGlobalSettings">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">System Defaults</h3>
                    </div>
                    <div class="px-6 py-4 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="default_currency" class="block text-sm font-medium text-gray-700">Default Currency</label>
                                <select wire:model="globalSettings.default_currency" id="default_currency"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @foreach($currencies as $code => $name)
                                    <option value="{{ $code }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="default_priority" class="block text-sm font-medium text-gray-700">Default Priority</label>
                                <select wire:model="globalSettings.default_priority" id="default_priority"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                    <option value="critical">Critical</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Default Notification Methods</label>
                            <div class="space-y-2">
                                @foreach(['email' => 'Email', 'sms' => 'SMS', 'system' => 'System Notification'] as $method => $label)
                                <div class="flex items-center">
                                    <input wire:model="globalSettings.default_notification_methods" 
                                           id="global_method_{{ $method }}" 
                                           type="checkbox" 
                                           value="{{ $method }}"
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="global_method_{{ $method }}" class="ml-3 block text-sm text-gray-700">
                                        {{ $label }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="notification_timezone" class="block text-sm font-medium text-gray-700">Notification Timezone</label>
                                <select wire:model="globalSettings.notification_timezone" id="notification_timezone"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="Africa/Dar_es_Salaam">Africa/Dar es Salaam</option>
                                    <option value="Africa/Nairobi">Africa/Nairobi</option>
                                    <option value="Africa/Kampala">Africa/Kampala</option>
                                    <option value="UTC">UTC</option>
                                </select>
                            </div>

                            <div>
                                <label for="auto_complete_overdue_days" class="block text-sm font-medium text-gray-700">Auto-complete overdue items after (days)</label>
                                <input wire:model="globalSettings.auto_complete_overdue_days" 
                                       type="number" 
                                       id="auto_complete_overdue_days"
                                       min="0"
                                       placeholder="0 = Never"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <p class="mt-1 text-xs text-gray-500">Set to 0 to disable auto-completion</p>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center">
                                <input wire:model="globalSettings.require_approval_for_high_priority" 
                                       id="require_approval_high_priority" 
                                       type="checkbox"
                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="require_approval_high_priority" class="ml-3 block text-sm text-gray-700">
                                    Require approval for high priority reminders
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg mt-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Email Configuration</h3>
                    </div>
                    <div class="px-6 py-4 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="email_from_name" class="block text-sm font-medium text-gray-700">From Name</label>
                                <input wire:model="globalSettings.email_from_name" 
                                       type="text" 
                                       id="email_from_name"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div>
                                <label for="email_from_address" class="block text-sm font-medium text-gray-700">From Email Address</label>
                                <input wire:model="globalSettings.email_from_address" 
                                       type="email" 
                                       id="email_from_address"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Save Settings
                    </button>
                </div>
            </form>
        </div>
        @endif

        {{-- Notifications Tab --}}
        @if($activeTab === 'notifications')
        <div class="space-y-6">
            <form wire:submit.prevent="saveNotificationTemplates">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Notification Templates</h3>
                        <button type="button" wire:click="resetNotificationTemplates" 
                                class="text-sm text-indigo-600 hover:text-indigo-500">
                            Reset to Defaults
                        </button>
                    </div>
                    <div class="px-6 py-4 space-y-8">
                        {{-- Reminder Template --}}
                        <div>
                            <h4 class="text-md font-medium text-gray-900 mb-4">Reminder Notification</h4>
                            <div class="space-y-4">
                                <div>
                                    <label for="reminder_subject" class="block text-sm font-medium text-gray-700">Subject Line</label>
                                    <input wire:model="notificationTemplates.reminder.subject" 
                                           type="text" 
                                           id="reminder_subject"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="reminder_body" class="block text-sm font-medium text-gray-700">Email Body</label>
                                    <textarea wire:model="notificationTemplates.reminder.body" 
                                              id="reminder_body"
                                              rows="8"
                                              class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Overdue Template --}}
                        <div>
                            <h4 class="text-md font-medium text-gray-900 mb-4">Overdue Notification</h4>
                            <div class="space-y-4">
                                <div>
                                    <label for="overdue_subject" class="block text-sm font-medium text-gray-700">Subject Line</label>
                                    <input wire:model="notificationTemplates.overdue.subject" 
                                           type="text" 
                                           id="overdue_subject"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="overdue_body" class="block text-sm font-medium text-gray-700">Email Body</label>
                                    <textarea wire:model="notificationTemplates.overdue.body" 
                                              id="overdue_body"
                                              rows="8"
                                              class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Available Variables --}}
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h5 class="text-sm font-medium text-gray-900 mb-2">Available Variables</h5>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-2 text-xs">
                                <span class="bg-white px-2 py-1 rounded border">{item_title}</span>
                                <span class="bg-white px-2 py-1 rounded border">{employee_name}</span>
                                <span class="bg-white px-2 py-1 rounded border">{due_date}</span>
                                <span class="bg-white px-2 py-1 rounded border">{days_until}</span>
                                <span class="bg-white px-2 py-1 rounded border">{days_overdue}</span>
                                <span class="bg-white px-2 py-1 rounded border">{priority}</span>
                                <span class="bg-white px-2 py-1 rounded border">{category_name}</span>
                                <span class="bg-white px-2 py-1 rounded border">{description}</span>
                                <span class="bg-white px-2 py-1 rounded border">{vendor_supplier}</span>
                                <span class="bg-white px-2 py-1 rounded border">{amount}</span>
                                <span class="bg-white px-2 py-1 rounded border">{reference_number}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Save Templates
                    </button>
                </div>
            </form>
        </div>
        @endif
    </div>

    {{-- Category Modal --}}
    @if($showCategoryModal)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75" wire:click="closeCategoryModal"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <form wire:submit.prevent="saveCategory">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                {{ $editingCategory ? 'Edit Category' : 'Add Category' }}
                            </h3>
                            <button type="button" wire:click="closeCategoryModal" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="space-y-6">
                            {{-- Basic Information --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="category_name" class="block text-sm font-medium text-gray-700">
                                        Name <span class="text-red-500">*</span>
                                    </label>
                                    <input wire:model="categoryForm.name" 
                                           type="text" 
                                           id="category_name"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('categoryForm.name')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="category_type" class="block text-sm font-medium text-gray-700">
                                        Type <span class="text-red-500">*</span>
                                    </label>
                                    <select wire:model="categoryForm.reminder_type" 
                                            id="category_type"
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        @foreach($reminderTypes as $type => $label)
                                        <option value="{{ $type }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="category_description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea wire:model="categoryForm.description" 
                                          id="category_description"
                                          rows="3"
                                          class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                            </div>

                            {{-- Visual Settings --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="category_icon" class="block text-sm font-medium text-gray-700">Icon</label>
                                    <select wire:model="categoryForm.icon" 
                                            id="category_icon"
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        @foreach($availableIcons as $icon => $label)
                                        <option value="{{ $icon }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="category_color" class="block text-sm font-medium text-gray-700">Color</label>
                                    <div class="mt-1 flex space-x-2">
                                        @foreach(array_chunk($availableColors, 6, true) as $colorRow)
                                        <div class="flex space-x-1">
                                            @foreach($colorRow as $color => $name)
                                            <label class="inline-flex items-center">
                                                <input wire:model="categoryForm.color" 
                                                       type="radio" 
                                                       value="{{ $color }}"
                                                       class="sr-only">
                                                <span class="w-6 h-6 rounded-full border-2 border-gray-300 cursor-pointer {{ $categoryForm['color'] === $color ? 'ring-2 ring-offset-2 ring-indigo-500' : '' }}"
                                                      style="background-color: {{ $color }}"></span>
                                            </label>
                                            @endforeach
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            {{-- Configuration Options --}}
                            <div class="space-y-4">
                                <h4 class="text-sm font-medium text-gray-900">Configuration</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="flex items-center">
                                        <input wire:model="categoryForm.has_start_end_dates" 
                                               id="has_start_end_dates" 
                                               type="checkbox"
                                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <label for="has_start_end_dates" class="ml-3 block text-sm text-gray-700">
                                            Has start and end dates
                                        </label>
                                    </div>

                                    <div class="flex items-center">
                                        <input wire:model="categoryForm.is_renewable" 
                                               id="is_renewable" 
                                               type="checkbox"
                                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <label for="is_renewable" class="ml-3 block text-sm text-gray-700">
                                            Is renewable
                                        </label>
                                    </div>

                                    <div class="flex items-center">
                                        <input wire:model="categoryForm.requires_approval" 
                                               id="requires_approval" 
                                               type="checkbox"
                                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <label for="requires_approval" class="ml-3 block text-sm text-gray-700">
                                            Requires approval
                                        </label>
                                    </div>

                                    <div class="flex items-center">
                                        <input wire:model="categoryForm.is_active" 
                                               id="is_active" 
                                               type="checkbox"
                                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <label for="is_active" class="ml-3 block text-sm text-gray-700">
                                            Active
                                        </label>
                                    </div>
                                </div>
                            </div>

                            {{-- Required Fields --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Required Fields</label>
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach($availableFields as $field => $label)
                                    <div class="flex items-center">
                                        <input wire:model="categoryForm.required_fields" 
                                               id="required_{{ $field }}" 
                                               type="checkbox" 
                                               value="{{ $field }}"
                                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <label for="required_{{ $field }}" class="ml-2 block text-sm text-gray-700">
                                            {{ $label }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Optional Fields --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Optional Fields</label>
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach($availableFields as $field => $label)
                                    <div class="flex items-center">
                                        <input wire:model="categoryForm.optional_fields" 
                                               id="optional_{{ $field }}" 
                                               type="checkbox" 
                                               value="{{ $field }}"
                                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <label for="optional_{{ $field }}" class="ml-2 block text-sm text-gray-700">
                                            {{ $label }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Notification Settings --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">Default Notification Periods (days before due date)</label>
                                <div class="space-y-2">
                                    @foreach($categoryForm['default_notification_periods'] as $index => $period)
                                    <div class="flex items-center space-x-2">
                                        <input wire:model="categoryForm.default_notification_periods.{{ $index }}" 
                                               type="number" 
                                               min="1" 
                                               max="365"
                                               class="block w-20 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <span class="text-sm text-gray-500">days</span>
                                        @if(count($categoryForm['default_notification_periods']) > 1)
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
                                            class="inline-flex items-center px-2 py-1 border border-dashed border-gray-300 text-xs leading-4 font-medium rounded text-gray-700 bg-white hover:bg-gray-50">
                                        <svg class="-ml-0.5 mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Add period
                                    </button>
                                </div>
                            </div>

                            {{-- Notification Methods --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">Default Notification Methods</label>
                                <div class="space-y-2">
                                    @foreach(['email' => 'Email', 'sms' => 'SMS', 'system' => 'System Notification'] as $method => $label)
                                    <div class="flex items-center">
                                        <input wire:model="categoryForm.notification_methods" 
                                               id="category_method_{{ $method }}" 
                                               type="checkbox" 
                                               value="{{ $method }}"
                                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <label for="category_method_{{ $method }}" class="ml-3 block text-sm text-gray-700">
                                            {{ $label }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" 
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                            {{ $editingCategory ? 'Update Category' : 'Create Category' }}
                        </button>
                        <button type="button" 
                                wire:click="closeCategoryModal" 
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    {{-- Loading Overlay --}}
    <div wire:loading wire:target="saveCategory,saveGlobalSettings,saveNotificationTemplates" class="fixed inset-0 z-50 bg-gray-500 bg-opacity-75 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 flex items-center space-x-4">
            <svg class="animate-spin h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <div>
                <p class="text-lg font-medium text-gray-900">Saving Settings</p>
                <p class="text-sm text-gray-500">Please wait...</p>
            </div>
        </div>
    </div>
</div>

</div>
