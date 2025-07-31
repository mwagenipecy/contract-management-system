<div>
{{-- resources/views/livewire/calendar/enhanced.blade.php --}}

<div class="px-4 sm:px-6 lg:px-8">
    {{-- Header --}}
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Enhanced Calendar</h1>
            <p class="mt-2 text-sm text-gray-700">View contracts, reminders, and important dates in one place.</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:flex sm:space-x-3">
            <a href="{{ route('reminders.create') }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add Reminder
            </a>
            <a href="{{ route('contracts.create') }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                New Contract
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-5 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
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
                            <dt class="text-sm font-medium text-gray-500 truncate">Contract Expirations</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $monthStats['expirations'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Contract Renewals</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $monthStats['renewals'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5l-5-5h5v-2a4 4 0 01-4-4V9a3 3 0 013-3h4a3 3 0 013 3v1a4 4 0 01-4 4v2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Reminders Due</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $monthStats['due_items'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-600 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Overdue Items</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $monthStats['overdue_items'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5l-5-5h5v-2a4 4 0 01-4-4V9a3 3 0 013-3h4a3 3 0 013 3v1a4 4 0 01-4 4v2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Notifications Due</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $monthStats['upcoming_notifications'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        {{-- Calendar --}}
        <div class="lg:col-span-3">
            <div class="bg-white shadow rounded-lg">
                {{-- Calendar Header --}}
                <div class="px-4 py-5 sm:p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ $currentDate->format('F Y') }}
                            </h2>
                            <div class="flex items-center space-x-1">
                                <button wire:click="previousMonth" 
                                        class="p-1 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </button>
                                <button wire:click="nextMonth" 
                                        class="p-1 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <button wire:click="goToToday" 
                                    class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Today
                            </button>
                        </div>
                    </div>

                    {{-- Event Type Filters --}}
                    <div class="mt-4 flex flex-wrap items-center gap-4">
                        <div class="flex items-center">
                            <input wire:model.live="showContractExpirations" 
                                   id="show_contract_expirations" 
                                   type="checkbox" 
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="show_contract_expirations" class="ml-2 block text-sm text-gray-900">
                                <span class="inline-block w-3 h-3 bg-red-500 rounded-full mr-1"></span>
                                Contract Expirations
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input wire:model.live="showContractRenewals" 
                                   id="show_contract_renewals" 
                                   type="checkbox" 
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="show_contract_renewals" class="ml-2 block text-sm text-gray-900">
                                <span class="inline-block w-3 h-3 bg-yellow-500 rounded-full mr-1"></span>
                                Contract Renewals
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input wire:model.live="showContractNotifications" 
                                   id="show_contract_notifications" 
                                   type="checkbox" 
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="show_contract_notifications" class="ml-2 block text-sm text-gray-900">
                                <span class="inline-block w-3 h-3 bg-blue-500 rounded-full mr-1"></span>
                                Contract Notifications
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input wire:model.live="showReminders" 
                                   id="show_reminders" 
                                   type="checkbox" 
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="show_reminders" class="ml-2 block text-sm text-gray-900">
                                <span class="inline-block w-3 h-3 bg-purple-500 rounded-full mr-1"></span>
                                Reminders
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input wire:model.live="showEmployeeEvents" 
                                   id="show_employee_events" 
                                   type="checkbox" 
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="show_employee_events" class="ml-2 block text-sm text-gray-900">
                                <span class="inline-block w-3 h-3 bg-green-500 rounded-full mr-1"></span>
                                Employee Events
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Calendar Grid --}}
                <div class="p-0">
                    {{-- Days of Week Header --}}
                    <div class="grid grid-cols-7 border-b border-gray-200">
                        @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                        <div class="p-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">
                            {{ $day }}
                        </div>
                        @endforeach
                    </div>

                    {{-- Calendar Days --}}
                    @foreach($calendarDays as $week)
                    <div class="grid grid-cols-7 border-b border-gray-200 last:border-b-0">
                        @foreach($week as $day)
                        <div class="relative min-h-32 border-r border-gray-200 last:border-r-0 p-2 
                                    {{ $day['isCurrentMonth'] ? 'bg-white' : 'bg-gray-50' }}
                                    {{ $day['isToday'] ? 'bg-blue-50' : '' }}
                                    hover:bg-gray-100 cursor-pointer transition-colors duration-150"
                             wire:click="selectDate('{{ $day['dateString'] }}')">
                            
                            {{-- Day Number --}}
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-sm font-medium 
                                    {{ $day['isCurrentMonth'] ? 'text-gray-900' : 'text-gray-400' }}
                                    {{ $day['isToday'] ? 'bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs' : '' }}">
                                    {{ $day['day'] }}
                                </span>
                                @if($day['events']->count() > 3)
                                <span class="text-xs text-gray-500 bg-gray-200 rounded-full px-1">+{{ $day['events']->count() - 3 }}</span>
                                @endif
                            </div>

                            {{-- Events --}}
                            <div class="space-y-1">
                                @foreach($day['events']->take(3) as $event)
                                @php 
                                    $eventType = $eventTypes[$event['type']];
                                    $colorClasses = [
                                        'red' => 'bg-red-100 text-red-800 hover:bg-red-200',
                                        'yellow' => 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200',
                                        'blue' => 'bg-blue-100 text-blue-800 hover:bg-blue-200',
                                        'green' => 'bg-green-100 text-green-800 hover:bg-green-200',
                                        'purple' => 'bg-purple-100 text-purple-800 hover:bg-purple-200',
                                        'orange' => 'bg-orange-100 text-orange-800 hover:bg-orange-200',
                                        'gray' => 'bg-gray-100 text-gray-800 hover:bg-gray-200',
                                    ];
                                    $colorClass = $colorClasses[$eventType['color']] ?? $colorClasses['gray'];
                                @endphp
                                
                                <div class="group relative">
                                    <div class="flex items-center space-x-1 p-1 rounded text-xs {{ $colorClass }} transition-colors duration-150">
                                        <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            @if($eventType['icon'] === 'exclamation-triangle')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            @elseif($eventType['icon'] === 'refresh')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            @elseif($eventType['icon'] === 'bell')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5l-5-5h5v-2a4 4 0 01-4-4V9a3 3 0 013-3h4a3 3 0 013 3v1a4 4 0 01-4 4v2z"></path>
                                            @elseif($eventType['icon'] === 'clock')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            @elseif($eventType['icon'] === 'exclamation')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            @elseif($eventType['icon'] === 'cake')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0A1.5 1.5 0 013 15.546V12a9 9 0 0118 0v3.546z"></path>
                                            @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            @endif
                                        </svg>
                                        <span class="truncate flex-1">{{ Str::limit($event['title'], 20) }}</span>
                                        @if(isset($event['priority']) && in_array($event['priority'], ['critical', 'high']))
                                        <span class="flex-shrink-0 w-1.5 h-1.5 bg-current rounded-full"></span>
                                        @endif
                                    </div>
                                    
                                    {{-- Tooltip --}}
                                    <div class="absolute bottom-full left-0 z-20 mb-2 hidden group-hover:block">
                                        <div class="bg-gray-900 text-white text-xs rounded-lg py-2 px-3 whitespace-nowrap shadow-lg max-w-xs">
                                            <div class="font-medium">{{ $event['title'] }}</div>
                                            <div class="text-gray-300">{{ $event['description'] }}</div>
                                            <div class="text-gray-400 mt-1">{{ $event['time'] }}</div>
                                            @if(isset($event['priority']))
                                            <div class="text-gray-400">Priority: {{ ucfirst($event['priority']) }}</div>
                                            @endif
                                            <div class="absolute top-full left-4 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-gray-900"></div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="lg:col-span-1 space-y-6">
            {{-- Quick Actions --}}
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('reminders.create') }}" 
                           class="block w-full text-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Add Reminder
                        </a>
                        <a href="{{ route('contracts.create') }}" 
                           class="block w-full text-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            New Contract
                        </a>
                        <a href="{{ route('reminders.dashboard') }}" 
                           class="block w-full text-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            View Dashboard
                        </a>
                    </div>
                </div>
            </div>

            {{-- Reminder Categories Filter --}}
            @if($showReminders && $reminderCategories->count() > 0)
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Reminder Categories</h3>
                    <div class="space-y-3 max-h-60 overflow-y-auto">
                        @foreach($reminderCategories as $category)
                        <div class="flex items-center">
                            <input wire:model.live="selectedReminderCategories" 
                                   id="category_{{ $category->id }}" 
                                   type="checkbox" 
                                   value="{{ $category->id }}"
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="category_{{ $category->id }}" class="ml-3 flex items-center cursor-pointer">
                                <div class="w-4 h-4 rounded-full mr-2" style="background-color: {{ $category->color }}"></div>
                                <span class="text-sm text-gray-900">{{ $category->name }}</span>
                                @if($category->active_items_count > 0)
                                <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $category->active_items_count }}
                                </span>
                                @endif
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            {{-- Upcoming Events --}}
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Upcoming Events</h3>
                    <div class="space-y-3 max-h-80 overflow-y-auto">
                        @forelse($upcomingEvents as $event)
                        @php 
                            $eventType = $eventTypes[$event['type']];
                            $colorClasses = [
                                'red' => 'bg-red-100 text-red-600',
                                'yellow' => 'bg-yellow-100 text-yellow-600',
                                'blue' => 'bg-blue-100 text-blue-600',
                                'green' => 'bg-green-100 text-green-600',
                                'purple' => 'bg-purple-100 text-purple-600',
                                'orange' => 'bg-orange-100 text-orange-600',
                                'gray' => 'bg-gray-100 text-gray-600',
                            ];
                            $colorClass = $colorClasses[$eventType['color']] ?? $colorClasses['gray'];
                        @endphp
                        <div class="flex items-start space-x-3 p-3 rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer transition-colors duration-150"
                             onclick="window.location.href='{{ $event['url'] }}'">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 rounded-full {{ $colorClass }} flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($eventType['icon'] === 'exclamation-triangle')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                        @elseif($eventType['icon'] === 'refresh')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        @elseif($eventType['icon'] === 'bell')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5l-5-5h5v-2a4 4 0 01-4-4V9a3 3 0 013-3h4a3 3 0 013 3v1a4 4 0 01-4 4v2z"></path>
                                        @elseif($eventType['icon'] === 'clock')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        @endif
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">{{ $event['title'] }}</p>
                                <p class="text-sm text-gray-500 truncate">{{ $event['description'] }}</p>
                                <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($event['date'])->format('M j, Y') }} • {{ $event['time'] }}</p>
                                @if(isset($event['priority']) && in_array($event['priority'], ['critical', 'high']))
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                    {{ $event['priority'] === 'critical' ? 'bg-red-100 text-red-800' : 'bg-orange-100 text-orange-800' }}">
                                    {{ ucfirst($event['priority']) }} Priority
                                </span>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-6">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h8a2 2 0 012 2v4m0 0V7a2 2 0 11-4 0V3M8 7V3a2 2 0 014 0v4m0 0v8a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h4z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No upcoming events</h3>
                            <p class="mt-1 text-sm text-gray-500">No events in the next 30 days.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Event Legend --}}
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Event Types</h3>
                    <div class="space-y-3">
                        @foreach($eventTypes as $type => $config)
                        @php
                            $colorClasses = [
                                'red' => 'bg-red-500',
                                'yellow' => 'bg-yellow-500',
                                'blue' => 'bg-blue-500',
                                'green' => 'bg-green-500',
                                'purple' => 'bg-purple-500',
                                'orange' => 'bg-orange-500',
                                'gray' => 'bg-gray-500',
                            ];
                            $colorClass = $colorClasses[$config['color']] ?? $colorClasses['gray'];
                        @endphp
                        <div class="flex items-center space-x-3">
                            <div class="w-4 h-4 rounded {{ $colorClass }}"></div>
                            <span class="text-sm text-gray-700">{{ $config['label'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Event Detail Modal --}}
    @if($showEventModal)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75" wire:click="closeEventModal"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="w-full">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Events for {{ \Carbon\Carbon::parse($selectedDate)->format('F j, Y') }}
                                </h3>
                                <button wire:click="closeEventModal" 
                                        class="text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-md p-1">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            
                            @if(count($selectedEvents) > 0)
                            <div class="space-y-4 max-h-96 overflow-y-auto">
                                @foreach($selectedEvents as $event)
                                @php 
                                    $eventType = $eventTypes[$event['type']];
                                    $colorClasses = [
                                        'red' => 'bg-red-100 text-red-600',
                                        'yellow' => 'bg-yellow-100 text-yellow-600',
                                        'blue' => 'bg-blue-100 text-blue-600',
                                        'green' => 'bg-green-100 text-green-600',
                                        'purple' => 'bg-purple-100 text-purple-600',
                                        'orange' => 'bg-orange-100 text-orange-600',
                                        'gray' => 'bg-gray-100 text-gray-600',
                                    ];
                                    $colorClass = $colorClasses[$eventType['color']] ?? $colorClasses['gray'];
                                @endphp
                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors duration-150">
                                    <div class="flex items-start space-x-4">
                                        <div class="flex-shrink-0">
                                            <div class="w-12 h-12 rounded-full {{ $colorClass }} flex items-center justify-center">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    @if($eventType['icon'] === 'exclamation-triangle')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                                    @elseif($eventType['icon'] === 'refresh')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                    @elseif($eventType['icon'] === 'bell')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5l-5-5h5v-2a4 4 0 01-4-4V9a3 3 0 013-3h4a3 3 0 013 3v1a4 4 0 01-4 4v2z"></path>
                                                    @elseif($eventType['icon'] === 'clock')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    @elseif($eventType['icon'] === 'exclamation')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    @else
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    @endif
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between">
                                                <h4 class="text-lg font-medium text-gray-900">{{ $event['title'] }}</h4>
                                                @if(isset($event['priority']))
                                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                                                    {{ $event['priority'] === 'critical' ? 'bg-red-100 text-red-800' : 
                                                       ($event['priority'] === 'high' ? 'bg-orange-100 text-orange-800' : 
                                                        ($event['priority'] === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800')) }}">
                                                    {{ ucfirst($event['priority']) }} Priority
                                                </span>
                                                @endif
                                            </div>
                                            <p class="text-sm text-gray-600 mt-2">{{ $event['description'] }}</p>
                                            <p class="text-sm text-gray-500 mt-1">
                                                <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $event['time'] }}
                                            </p>
                                            
                                            {{-- Contract Details --}}
                                            @if(isset($event['contract']))
                                            <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                                                <h5 class="text-sm font-medium text-gray-900 mb-2">Contract Details</h5>
                                                <div class="grid grid-cols-2 gap-4 text-sm">
                                                    <div>
                                                        <span class="font-medium text-gray-700">Contract:</span>
                                                        <span class="text-gray-600 ml-2">{{ $event['contract']->contract_number }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="font-medium text-gray-700">Employee:</span>
                                                        <span class="text-gray-600 ml-2">{{ $event['contract']->employee->name }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="font-medium text-gray-700">Type:</span>
                                                        <span class="text-gray-600 ml-2">{{ ucfirst(str_replace('_', ' ', $event['contract']->contract_type)) }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="font-medium text-gray-700">Salary:</span>
                                                        <span class="text-gray-600 ml-2">{{ $event['contract']->formatted_salary }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            
                                            {{-- Reminder Details --}}
                                            @if(isset($event['reminder_item']))
                                            <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                                                <h5 class="text-sm font-medium text-gray-900 mb-2">Reminder Details</h5>
                                                <div class="grid grid-cols-2 gap-4 text-sm">
                                                    <div>
                                                        <span class="font-medium text-gray-700">Category:</span>
                                                        <span class="text-gray-600 ml-2">{{ $event['reminder_item']->category->name }}</span>
                                                    </div>
                                                    @if($event['reminder_item']->vendor_supplier)
                                                    <div>
                                                        <span class="font-medium text-gray-700">Vendor:</span>
                                                        <span class="text-gray-600 ml-2">{{ $event['reminder_item']->vendor_supplier }}</span>
                                                    </div>
                                                    @endif
                                                    @if($event['reminder_item']->formatted_amount)
                                                    <div>
                                                        <span class="font-medium text-gray-700">Amount:</span>
                                                        <span class="text-gray-600 ml-2">{{ $event['reminder_item']->formatted_amount }}</span>
                                                    </div>
                                                    @endif
                                                    @if($event['reminder_item']->assignedTo)
                                                    <div>
                                                        <span class="font-medium text-gray-700">Assigned To:</span>
                                                        <span class="text-gray-600 ml-2">{{ $event['reminder_item']->assignedTo->name }}</span>
                                                    </div>
                                                    @endif
                                                </div>
                                                @if($event['reminder_item']->notes)
                                                <div class="mt-3">
                                                    <span class="font-medium text-gray-700">Notes:</span>
                                                    <p class="text-gray-600 mt-1">{{ $event['reminder_item']->notes }}</p>
                                                </div>
                                                @endif
                                            </div>
                                            @endif
                                            
                                            {{-- Actions --}}
                                            <div class="mt-4 flex flex-wrap gap-2">
                                                @if(isset($event['actions']))
                                                    @foreach($event['actions'] as $action)
                                                        @if(isset($action['url']))
                                                            <a href="{{ $action['url'] }}" 
                                                               class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                                {{ $action['label'] }}
                                                            </a>
                                                        @elseif(isset($action['action']))
                                                            <button wire:click="{{ $action['action'] }}({{ $action['id'] }}{{ isset($action['days']) ? ', ' . $action['days'] : '' }})" 
                                                                    class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                                {{ $action['label'] }}
                                                            </button>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <a href="{{ $event['url'] }}" 
                                                       class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                        View Details
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h8a2 2 0 012 2v4m0 0V7a2 2 0 11-4 0V3M8 7V3a2 2 0 014 0v4m0 0v8a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h4z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No events</h3>
                                <p class="mt-1 text-sm text-gray-500">No events scheduled for this date.</p>
                                <div class="mt-6">
                                    <button wire:click="closeEventModal"
                                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Close
                                    </button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="closeEventModal" 
                            type="button" 
                            class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Loading State --}}
    <div wire:loading wire:target="previousMonth,nextMonth,selectDate,toggleReminderCategory" class="fixed inset-0 z-40 bg-black bg-opacity-25 flex items-center justify-center">
        <div class="bg-white rounded-lg p-4 flex items-center space-x-3">
            <svg class="animate-spin h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-sm font-medium text-gray-900">Loading...</span>
        </div>
    </div>
</div>

{{-- Custom Styles --}}
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Custom scrollbar for sidebar areas */
    .max-h-60::-webkit-scrollbar,
    .max-h-80::-webkit-scrollbar,
    .max-h-96::-webkit-scrollbar {
        width: 4px;
    }
    
    .max-h-60::-webkit-scrollbar-track,
    .max-h-80::-webkit-scrollbar-track,
    .max-h-96::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 2px;
    }
    
    .max-h-60::-webkit-scrollbar-thumb,
    .max-h-80::-webkit-scrollbar-thumb,
    .max-h-96::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 2px;
    }
    
    .max-h-60::-webkit-scrollbar-thumb:hover,
    .max-h-80::-webkit-scrollbar-thumb:hover,
    .max-h-96::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Calendar day hover effects */
    .calendar-day {
        transition: all 0.15s ease-in-out;
    }
    
    .calendar-day:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    /* Event item animations */
    .event-item {
        transition: all 0.15s ease-in-out;
    }
    
    .event-item:hover {
        transform: translateX(2px);
    }
</style>

</div>
