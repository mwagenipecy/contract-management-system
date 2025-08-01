<div>

{{-- resources/views/livewire/reminders/dashboard.blade.php --}}

<div class="px-4 sm:px-6 lg:px-8">
    {{-- Header --}}
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Reminder Dashboard</h1>
            <p class="mt-2 text-sm text-gray-700">Track and manage all your important deadlines, renewals, and events.</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:flex sm:space-x-3">
            <a href="{{ route('reminders.create') }}" 
               class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add Reminder
            </a>
            <a href="{{ route('reminders.index') }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Settings
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-md transition-shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Overdue Items</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['overdue'] }}</dd>
                        </dl>
                    </div>
                </div>
                @if($stats['overdue'] > 0)
                <div class="mt-3">
                    <button wire:click="setView('overdue')" class="text-xs text-red-600 hover:text-red-500 font-medium">
                        View overdue items →
                    </button>
                </div>
                @endif
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-md transition-shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Due Today</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['due_today'] }}</dd>
                        </dl>
                    </div>
                </div>
                @if($stats['due_today'] > 0)
                <div class="mt-3">
                    <button wire:click="setDateRange('today')" wire:click="setView('upcoming')" class="text-xs text-yellow-600 hover:text-yellow-500 font-medium">
                        View today's items →
                    </button>
                </div>
                @endif
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-md transition-shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h8a2 2 0 012 2v4m0 0V7a2 2 0 11-4 0V3M8 7V3a2 2 0 014 0v4m0 0v8a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h4z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">This Week</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['upcoming_week'] }}</dd>
                        </dl>
                    </div>
                </div>
                @if($stats['upcoming_week'] > 0)
                <div class="mt-3">
                    <button wire:click="setDateRange('next_7_days')" wire:click="setView('upcoming')" class="text-xs text-blue-600 hover:text-blue-500 font-medium">
                        View weekly items →
                    </button>
                </div>
                @endif
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-md transition-shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">High Priority</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['high_priority'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-md transition-shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-indigo-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Renewals Due</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['renewal_due'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        {{-- Main Content --}}
        <div class="lg:col-span-3">
            {{-- View Tabs --}}
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                        <button wire:click="setView('overview')" 
                                class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap {{ $selectedView === 'overview' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Overview
                            @if($selectedView === 'overview')<span class="ml-2 bg-indigo-100 text-indigo-600 py-0.5 px-2.5 rounded-full text-xs font-medium">{{ $stats['total'] }}</span>@endif
                        </button>
                        <button wire:click="setView('overdue')" 
                                class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap {{ $selectedView === 'overdue' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Overdue
                            @if($stats['overdue'] > 0)<span class="ml-2 bg-red-100 text-red-600 py-0.5 px-2.5 rounded-full text-xs font-medium">{{ $stats['overdue'] }}</span>@endif
                        </button>
                        <button wire:click="setView('upcoming')" 
                                class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap {{ $selectedView === 'upcoming' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Upcoming
                        </button>
                        <button wire:click="setView('pending_approval')" 
                                class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap {{ $selectedView === 'pending_approval' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Pending Approval
                            @if($stats['pending_approval'] > 0)<span class="ml-2 bg-yellow-100 text-yellow-600 py-0.5 px-2.5 rounded-full text-xs font-medium">{{ $stats['pending_approval'] }}</span>@endif
                        </button>
                        <button wire:click="setView('completed')" 
                                class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap {{ $selectedView === 'completed' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Completed
                        </button>
                    </nav>
                </div>

                {{-- Filters --}}
                <div class="p-6 border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        {{-- Search --}}
                        <div class="col-span-full md:col-span-1">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input wire:model.live="search" type="text" id="search" 
                                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                       placeholder="Search reminders...">
                            </div>
                        </div>


                        {{-- Category Filter --}}
                        
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select wire:model.live="selectedCategory" id="category" 
                                    class="block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Priority Filter --}}
                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                            <select wire:model.live="selectedPriority" id="priority"
                                    class="block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">All Priorities</option>
                                <option value="critical">Critical</option>
                                <option value="high">High</option>
                                <option value="medium">Medium</option>
                                <option value="low">Low</option>
                            </select>
                        </div>

                        {{-- Type Filter --}}
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                            <select wire:model.live="selectedType" id="type"
                                    class="block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">All Types</option>
                                @foreach($reminderTypes as $type => $label)
                                <option value="{{ $type }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Date Range for Upcoming View --}}
                    @if($selectedView === 'upcoming')
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="dateRange" class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                            <select wire:model.live="dateRange" id="dateRange"
                                    class="block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="today">Today</option>
                                <option value="next_7_days">Next 7 Days</option>
                                <option value="next_30_days">Next 30 Days</option>
                                <option value="custom">Custom Range</option>
                            </select>
                        </div>
                        @if($dateRange === 'custom')
                        <div>
                            <label for="customStartDate" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                            <input wire:model.live="customStartDate" type="date" id="customStartDate"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="customEndDate" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                            <input wire:model.live="customEndDate" type="date" id="customEndDate"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        @endif
                    </div>
                    @endif

                    {{-- Additional Options --}}
                    <div class="mt-4 flex flex-wrap items-center gap-4">
                        <label class="inline-flex items-center">
                            <input wire:model.live="assignedToMe" type="checkbox" 
                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Only items assigned to me</span>
                        </label>

                        @if($selectedCategory || $selectedPriority || $selectedType || $search || $assignedToMe)
                        <button wire:click="clearFilters" 
                                class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Clear Filters
                        </button>
                        @endif
                    </div>
                </div>

                {{-- Bulk Actions --}}
                @if($selectedView !== 'completed' && !empty($selectedItems))
                <div class="p-4 bg-gray-50 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-700">{{ count($selectedItems) }} items selected</span>
                        <div class="flex space-x-2">
                            <button wire:click="bulkComplete" 
                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Mark Complete
                            </button>
                            <button wire:click="bulkSnooze(7)" 
                                    class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Snooze 7 Days
                            </button>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Items List --}}
                <div class="overflow-hidden">
                    @if($items->count() > 0)
                    <div class="divide-y divide-gray-200">
                        @if($selectedView !== 'completed')
                        <div class="px-6 py-3 bg-gray-50">
                            <label class="inline-flex items-center">
                                <input wire:model.live="selectAll" type="checkbox" 
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm font-medium text-gray-700">Select All</span>
                            </label>
                        </div>
                        @endif

                        @foreach($items as $item)
                        <div class="px-6 py-4 hover:bg-gray-50 {{ in_array($item->id, $selectedItems) ? 'bg-blue-50' : '' }}">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start space-x-3 flex-1">
                                    @if($selectedView !== 'completed')
                                    <div class="flex-shrink-0 mt-1">
                                        <input wire:model.live="selectedItems" value="{{ $item->id }}" type="checkbox" 
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </div>
                                    @endif
                                    
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center space-x-2 mb-2">
                                            <h3 class="text-sm font-medium text-gray-900 truncate">{{ $item->title }}</h3>
                                            
                                            {{-- Priority Badge --}}
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                                {{ $item->priority === 'critical' ? 'bg-red-100 text-red-800' : '' }}
                                                {{ $item->priority === 'high' ? 'bg-orange-100 text-orange-800' : '' }}
                                                {{ $item->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $item->priority === 'low' ? 'bg-green-100 text-green-800' : '' }}">
                                                {{ ucfirst($item->priority) }}
                                            </span>

                                            {{-- Status Badge --}}
                                            @if($item->amount)
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                                </svg>
                                                ${{ number_format($item->amount, 2) }}
                                            </span>
                                            @endif

                                            @if($item->vendor_supplier)
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                </svg>
                                                {{ $item->vendor_supplier }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Quick Actions --}}
                                <div class="flex items-center space-x-2 ml-4">
                                    @if($selectedView === 'pending_approval')
                                        <button wire:click="approveItem({{ $item->id }})" 
                                                class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            Approve
                                        </button>
                                    @endif

                                    @if($selectedView !== 'completed')
                                        <button wire:click="openQuickComplete({{ $item->id }})" 
                                                class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            Complete
                                        </button>

                                        @if($item->category->is_renewable)
                                        <button wire:click="openQuickRenew({{ $item->id }})" 
                                                class="inline-flex items-center px-2 py-1 border border-gray-300 text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Renew
                                        </button>
                                        @endif

                                        <div class="relative" x-data="{ open: false }">
                                            <button @click="open = !open" 
                                                    class="inline-flex items-center px-2 py-1 border border-gray-300 text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Snooze
                                                <svg class="ml-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </button>
                                            <div x-show="open" @click.away="open = false" x-cloak
                                                 class="absolute right-0 mt-1 w-32 bg-white rounded-md shadow-lg z-10 border border-gray-200">
                                                <div class="py-1">
                                                    <button wire:click="snoozeItem({{ $item->id }}, 1)" @click="open = false"
                                                            class="block w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-100">1 Day</button>
                                                    <button wire:click="snoozeItem({{ $item->id }}, 7)" @click="open = false"
                                                            class="block w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-100">1 Week</button>
                                                    <button wire:click="snoozeItem({{ $item->id }}, 30)" @click="open = false"
                                                            class="block w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-100">1 Month</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <a href="{{ route('reminders.show', $item) }}" 
                                       class="inline-flex items-center px-2 py-1 border border-gray-300 text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $items->links() }}
                    </div>
                    @else
                    <div class="px-6 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No reminders found</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            @if($selectedView === 'overview')
                                Get started by creating your first reminder.
                            @else
                                No items match your current filters.
                            @endif
                        </p>
                        @if($selectedView === 'overview')
                        <div class="mt-6">
                            <a href="{{ route('reminders.create') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add Reminder
                            </a>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="lg:col-span-1">
            {{-- Upcoming Events --}}
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Upcoming This Week</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($upcomingEvents as $event)
                    <div class="px-6 py-4">
                        <div class="flex items-start justify-between">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $event->title }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $event->category->name }}</p>
                                <div class="flex items-center mt-2">
                                    <svg class="w-3 h-3 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h8a2 2 0 012 2v4m0 0V7a2 2 0 11-4 0V3M8 7V3a2 2 0 014 0v4m0 0v8a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h4z"></path>
                                    </svg>
                                    <span class="text-xs text-gray-500">{{ $event->due_date->format('M d') }}</span>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                {{ $event->priority === 'critical' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $event->priority === 'high' ? 'bg-orange-100 text-orange-800' : '' }}
                                {{ $event->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $event->priority === 'low' ? 'bg-green-100 text-green-800' : '' }}">
                                {{ ucfirst($event->priority) }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="px-6 py-8 text-center">
                        <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h8a2 2 0 012 2v4m0 0V7a2 2 0 11-4 0V3M8 7V3a2 2 0 014 0v4m0 0v8a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h4z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">No upcoming events</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Categories Overview --}}
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Categories</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    @foreach($categories as $category)
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <button wire:click="$set('selectedCategory', '{{ $category->id }}')" 
                                        class="text-sm font-medium text-gray-900 hover:text-indigo-600 truncate text-left">
                                    {{ $category->name }}
                                </button>
                                <div class="flex items-center space-x-2 mt-1">
                                    <span class="text-xs text-gray-500">{{ $category->active_items_count }} active</span>
                                    @if($category->overdue_count > 0)
                                    <span class="text-xs text-red-600">{{ $category->overdue_count }} overdue</span>
                                    @endif
                                </div>
                            </div>
                            <div class="ml-2">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $category->active_items_count }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Complete Modal --}}
    @if($showQuickCompleteModal)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" x-data>
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Complete Reminder</h3>
                    <button wire:click="closeQuickCompleteModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                @if($completingItem)
                <div class="mb-4">
                    <h4 class="font-medium text-gray-900">{{ $completingItem->title }}</h4>
                    <p class="text-sm text-gray-600">{{ $completingItem->category->name }}</p>
                </div>

                <div class="mb-4">
                    <label for="completionNotes" class="block text-sm font-medium text-gray-700 mb-2">
                        Completion Notes (Optional)
                    </label>
                    <textarea wire:model.live="completionNotes" id="completionNotes" rows="3"
                              class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                              placeholder="Add any notes about the completion..."></textarea>
                </div>

                <div class="flex justify-end space-x-3">
                    <button wire:click="closeQuickCompleteModal" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </button>
                    <button wire:click="quickComplete" 
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Mark Complete
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    {{-- Quick Renew Modal --}}
    @if($showQuickRenewModal)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" x-data>
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Renew Reminder</h3>
                    <button wire:click="closeQuickRenewModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                @if($renewingItem)
                <div class="mb-4">
                    <h4 class="font-medium text-gray-900">{{ $renewingItem->title }}</h4>
                    <p class="text-sm text-gray-600">{{ $renewingItem->category->name }}</p>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="renewalEndDate" class="block text-sm font-medium text-gray-700 mb-1">
                            New End Date <span class="text-red-500">*</span>
                        </label>
                        <input wire:model.live="renewalEndDate" type="date" id="renewalEndDate" required
                               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('renewalEndDate') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="renewalAmount" class="block text-sm font-medium text-gray-700 mb-1">
                            Amount
                        </label>
                        <input wire:model.live="renewalAmount" type="number" step="0.01" id="renewalAmount"
                               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('renewalAmount') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="renewalNotes" class="block text-sm font-medium text-gray-700 mb-1">
                            Renewal Notes (Optional)
                        </label>
                        <textarea wire:model.live="renewalNotes" id="renewalNotes" rows="3"
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                  placeholder="Add any notes about the renewal..."></textarea>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <button wire:click="closeQuickRenewModal" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </button>
                    <button wire:click="quickRenew" 
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Renew Item
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>







</div>
