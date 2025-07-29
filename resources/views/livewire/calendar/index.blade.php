<div>
{{-- resources/views/livewire/calendar/index.blade.php --}}

<div class="px-4 sm:px-6 lg:px-8">
    {{-- Header --}}
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Contract Calendar</h1>
            <p class="mt-2 text-sm text-gray-700">View contract renewals, expirations, and important dates.</p>
        </div>
    </div>

    {{-- Month Stats --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-3 lg:grid-cols-3 mb-8">
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
                            <dt class="text-sm font-medium text-gray-500 truncate">Renewals Due</dt>
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
                        <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5l-5-5h5v-2a4 4 0 01-4-4V9a3 3 0 013-3h4a3 3 0 013 3v1a4 4 0 01-4 4v2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Notifications Due</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $monthStats['notifications'] }}</dd>
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
                                        class="p-1 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </button>
                                <button wire:click="nextMonth" 
                                        class="p-1 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <button wire:click="goToToday" 
                                    class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Today
                            </button>
                            {{-- Event Type Filters --}}
                            <div class="flex items-center space-x-2">
                                <div class="flex items-center">
                                    <input wire:model.live="showExpirations" 
                                           id="show_expirations" 
                                           type="checkbox" 
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="show_expirations" class="ml-2 block text-sm text-gray-900">
                                        <span class="inline-block w-3 h-3 bg-red-500 rounded-full mr-1"></span>
                                        Expirations
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input wire:model.live="showRenewals" 
                                           id="show_renewals" 
                                           type="checkbox" 
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="show_renewals" class="ml-2 block text-sm text-gray-900">
                                        <span class="inline-block w-3 h-3 bg-yellow-500 rounded-full mr-1"></span>
                                        Renewals
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input wire:model.live="showNotifications" 
                                           id="show_notifications" 
                                           type="checkbox" 
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="show_notifications" class="ml-2 block text-sm text-gray-900">
                                        <span class="inline-block w-3 h-3 bg-blue-500 rounded-full mr-1"></span>
                                        Notifications
                                    </label>
                                </div>
                            </div>
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
                                    hover:bg-gray-100 cursor-pointer"
                             wire:click="selectDate('{{ $day['dateString'] }}')">
                            
                            {{-- Day Number --}}
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-sm font-medium 
                                    {{ $day['isCurrentMonth'] ? 'text-gray-900' : 'text-gray-400' }}
                                    {{ $day['isToday'] ? 'bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs' : '' }}">
                                    {{ $day['day'] }}
                                </span>
                                @if($day['events']->count() > 3)
                                <span class="text-xs text-gray-500">+{{ $day['events']->count() - 3 }}</span>
                                @endif
                            </div>

                            {{-- Events --}}
                            <div class="space-y-1">
                                @foreach($day['events']->take(3) as $event)
                                @php $eventType = $eventTypes[$event['type']] @endphp
                                <div class="group relative">
                                    <div class="flex items-center space-x-1 p-1 rounded text-xs 
                                              bg-{{ $eventType['color'] }}-100 text-{{ $eventType['color'] }}-800 
                                              hover:bg-{{ $eventType['color'] }}-200 transition-colors duration-150">
                                        <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            @if($eventType['icon'] === 'exclamation-triangle')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            @elseif($eventType['icon'] === 'refresh')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            @elseif($eventType['icon'] === 'bell')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5l-5-5h5v-2a4 4 0 01-4-4V9a3 3 0 013-3h4a3 3 0 013 3v1a4 4 0 01-4 4v2z"></path>
                                            @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            @endif
                                        </svg>
                                        <span class="truncate flex-1">{{ $event['title'] }}</span>
                                    </div>
                                    
                                    {{-- Tooltip --}}
                                    <div class="absolute bottom-full left-0 z-10 mb-2 hidden group-hover:block">
                                        <div class="bg-gray-900 text-white text-xs rounded py-1 px-2 whitespace-nowrap">
                                            {{ $event['description'] }}
                                            <div class="absolute top-full left-2 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-gray-900"></div>
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
        <div class="lg:col-span-1">
            {{-- Upcoming Events --}}
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Upcoming Events</h3>
                    <div class="space-y-3">
                        @forelse($upcomingEvents as $event)
                        @php $eventType = $eventTypes[$event['type']] @endphp
                        <div class="flex items-start space-x-3 p-3 rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer"
                             onclick="window.location.href='{{ $event['url'] }}'">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 rounded-full bg-{{ $eventType['color'] }}-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-{{ $eventType['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($eventType['icon'] === 'exclamation-triangle')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                        @elseif($eventType['icon'] === 'refresh')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        @elseif($eventType['icon'] === 'bell')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5l-5-5h5v-2a4 4 0 01-4-4V9a3 3 0 013-3h4a3 3 0 013 3v1a4 4 0 01-4 4v2z"></path>
                                        @endif
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">{{ $event['title'] }}</p>
                                <p class="text-sm text-gray-500 truncate">{{ $event['description'] }}</p>
                                <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($event['date'])->format('M d, Y') }} • {{ $event['time'] }}</p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-6">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h8a2 2 0 012 2v4m0 0V7a2 2 0 11-4 0V3M8 7V3a2 2 0 014 0v4m0 0v8a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h4z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No upcoming events</h3>
                            <p class="mt-1 text-sm text-gray-500">No contract events in the next 30 days.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Legend --}}
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Event Types</h3>
                    <div class="space-y-3">
                        @foreach($eventTypes as $type => $config)
                        <div class="flex items-center space-x-3">
                            <div class="w-4 h-4 rounded bg-{{ $config['color'] }}-500"></div>
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
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="w-full">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Events for {{ \Carbon\Carbon::parse($selectedDate)->format('F j, Y') }}
                                </h3>
                                <button wire:click="closeEventModal" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            
                            @if(count($selectedEvents) > 0)
                            <div class="space-y-4 max-h-96 overflow-y-auto">
                                @foreach($selectedEvents as $event)
                                @php $eventType = $eventTypes[$event['type']] @endphp
                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 rounded-full bg-{{ $eventType['color'] }}-100 flex items-center justify-center">
                                                <svg class="w-5 h-5 text-{{ $eventType['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    @if($eventType['icon'] === 'exclamation-triangle')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                                    @elseif($eventType['icon'] === 'refresh')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                    @elseif($eventType['icon'] === 'bell')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5l-5-5h5v-2a4 4 0 01-4-4V9a3 3 0 013-3h4a3 3 0 013 3v1a4 4 0 01-4 4v2z"></path>
                                                    @else
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    @endif
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between">
                                                <h4 class="text-sm font-medium text-gray-900">{{ $event['title'] }}</h4>
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                    {{ $event['priority'] === 'high' ? 'bg-red-100 text-red-800' : 
                                                       ($event['priority'] === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                                    {{ ucfirst($event['priority']) }} Priority
                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-600 mt-1">{{ $event['description'] }}</p>
                                            <p class="text-xs text-gray-500 mt-2">{{ $event['time'] }}</p>
                                            
                                            {{-- Event-specific details --}}
                                            @if(isset($event['contract']))
                                            <div class="mt-3 p-3 bg-gray-50 rounded-md">
                                                <div class="grid grid-cols-2 gap-4 text-sm">
                                                    <div>
                                                        <span class="font-medium text-gray-700">Contract:</span>
                                                        <span class="text-gray-600">{{ $event['contract']->contract_number }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="font-medium text-gray-700">Type:</span>
                                                        <span class="text-gray-600">{{ ucfirst(str_replace('_', ' ', $event['contract']->contract_type)) }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="font-medium text-gray-700">Salary:</span>
                                                        <span class="text-gray-600">{{ $event['contract']->formatted_salary }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="font-medium text-gray-700">Department:</span>
                                                        <span class="text-gray-600">{{ $event['contract']->employee->department }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            
                                            <div class="mt-3 flex space-x-2">
                                                <a href="{{ $event['url'] }}" 
                                                   class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                                    View Details
                                                </a>
                                                @if($event['type'] === 'contract_expiry' || $event['type'] === 'renewal_due')
                                                <a href="{{ route('contracts.renew', $event['contract']) }}" 
                                                   class="inline-flex items-center px-3 py-1 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                                    Renew Contract
                                                </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-6">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h8a2 2 0 012 2v4m0 0V7a2 2 0 11-4 0V3M8 7V3a2 2 0 014 0v4m0 0v8a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h4z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No events</h3>
                                <p class="mt-1 text-sm text-gray-500">No contract events scheduled for this date.</p>
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
</div>

</div>
