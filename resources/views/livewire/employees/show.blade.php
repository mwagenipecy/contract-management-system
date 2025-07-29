<div>
{{-- resources/views/livewire/employees/show.blade.php --}}

<div class="px-4 sm:px-6 lg:px-8">
    {{-- Header --}}
    <div class="mb-8">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-4">
                <li>
                    <div>
                        <a href="{{ route('employment.index') }}" class="text-gray-400 hover:text-gray-500">
                            <svg class="flex-shrink-0 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            <span class="sr-only">Employees</span>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('employment.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Employees</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-4 text-sm font-medium text-gray-500">{{ $employee->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>
        
        <div class="mt-4 md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h1 class="text-2xl font-bold text-gray-900 sm:truncate">{{ $employee->name }}</h1>
                <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                    <div class="mt-2 flex items-center text-sm text-gray-500">
                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 012-2h2a2 2 0 012 2v2m-4 0a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V8a2 2 0 012-2z"></path>
                        </svg>
                        {{ $employee->employee_id }}
                    </div>
                    <div class="mt-2 flex items-center text-sm text-gray-500">
                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ $employee->position }}
                    </div>
                    <div class="mt-2 flex items-center text-sm text-gray-500">
                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        {{ $employee->department }}
                    </div>
                </div>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
                <a href="{{ route('employees.edit', $employee) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('contracts.create') }}?employee_id={{ $employee->id }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    New Contract
                </a>
            </div>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if (session()->has('message'))
    <div class="rounded-md bg-green-50 p-4 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800">{{ session('message') }}</p>
            </div>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Employee Information --}}
        <div class="lg:col-span-1">
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    {{-- Profile Picture and Basic Info --}}
                    <div class="text-center">
                        <div class="mx-auto h-24 w-24 rounded-full bg-gray-300 flex items-center justify-center mb-4">
                            <span class="text-2xl font-medium text-gray-700">{{ substr($employee->name, 0, 2) }}</span>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">{{ $employee->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $employee->position }}</p>
                        <div class="mt-4">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-{{ $employee->status_badge['color'] }}-100 text-{{ $employee->status_badge['color'] }}-800">
                                {{ $employee->status_badge['text'] }}
                            </span>
                        </div>
                    </div>

                    {{-- Contact Information --}}
                    <div class="mt-6 border-t border-gray-200 pt-6">
                        <h4 class="text-sm font-medium text-gray-900 mb-4">Contact Information</h4>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="text-sm text-gray-900">
                                    <a href="mailto:{{ $employee->email }}" class="text-indigo-600 hover:text-indigo-500">
                                        {{ $employee->email }}
                                    </a>
                                </dd>
                            </div>
                            @if($employee->phone)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                <dd class="text-sm text-gray-900">
                                    <a href="tel:{{ $employee->phone }}" class="text-indigo-600 hover:text-indigo-500">
                                        {{ $employee->phone }}
                                    </a>
                                </dd>
                            </div>
                            @endif
                            @if($employee->address)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Address</dt>
                                <dd class="text-sm text-gray-900">{{ $employee->address }}</dd>
                            </div>
                            @endif
                        </dl>
                    </div>

                    {{-- Emergency Contact --}}
                    @if($employee->emergency_contact_name || $employee->emergency_contact_phone)
                    <div class="mt-6 border-t border-gray-200 pt-6">
                        <h4 class="text-sm font-medium text-gray-900 mb-4">Emergency Contact</h4>
                        <dl class="space-y-3">
                            @if($employee->emergency_contact_name)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Name</dt>
                                <dd class="text-sm text-gray-900">{{ $employee->emergency_contact_name }}</dd>
                            </div>
                            @endif
                            @if($employee->emergency_contact_phone)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                <dd class="text-sm text-gray-900">
                                    <a href="tel:{{ $employee->emergency_contact_phone }}" class="text-indigo-600 hover:text-indigo-500">
                                        {{ $employee->emergency_contact_phone }}
                                    </a>
                                </dd>
                            </div>
                            @endif
                        </dl>
                    </div>
                    @endif

                    {{-- Employment Details --}}
                    <div class="mt-6 border-t border-gray-200 pt-6">
                        <h4 class="text-sm font-medium text-gray-900 mb-4">Employment Details</h4>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Employee ID</dt>
                                <dd class="text-sm text-gray-900">{{ $employee->employee_id }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Department</dt>
                                <dd class="text-sm text-gray-900">{{ $employee->department }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Hire Date</dt>
                                <dd class="text-sm text-gray-900">{{ $employee->hire_date->format('M d, Y') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        {{-- Contracts and Activity --}}
        <div class="lg:col-span-2">
            {{-- Active Contract --}}
            @if($employee->hasActiveContract())
            @php $activeContract = $employee->getCurrentContract(); @endphp
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Active Contract</h3>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-{{ $activeContract->status_badge['color'] }}-100 text-{{ $activeContract->status_badge['color'] }}-800">
                            {{ $activeContract->status_badge['text'] }}
                        </span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Contract Number</dt>
                            <dd class="text-sm text-gray-900">{{ $activeContract->contract_number }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Contract Type</dt>
                            <dd class="text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $activeContract->contract_type)) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Start Date</dt>
                            <dd class="text-sm text-gray-900">{{ $activeContract->start_date->format('M d, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">End Date</dt>
                            <dd class="text-sm text-gray-900">{{ $activeContract->end_date->format('M d, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Salary</dt>
                            <dd class="text-sm text-gray-900">{{ $activeContract->formatted_salary }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Days Until Expiry</dt>
                            <dd class="text-sm text-gray-900">
                                @php $daysLeft = $employee->getContractExpiryDays(); @endphp
                                @if($daysLeft < 0)
                                    <span class="text-red-600 font-medium">Expired {{ abs($daysLeft) }} days ago</span>
                                @elseif($daysLeft <= 7)
                                    <span class="text-yellow-600 font-medium">{{ $daysLeft }} days</span>
                                @else
                                    <span class="text-green-600 font-medium">{{ $daysLeft }} days</span>
                                @endif
                            </dd>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <a href="{{ route('contracts.show', $activeContract) }}" 
                           class="text-indigo-600 hover:text-indigo-500 text-sm font-medium">
                            View Contract Details →
                        </a>
                    </div>
                </div>
            </div>
            @endif

            {{-- Contract History --}}
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Contract History</h3>
                    @if($employee->contracts->count() > 0)
                    <div class="space-y-4">
                        @foreach($employee->contracts->sortByDesc('created_at') as $contract)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">{{ $contract->contract_number }}</h4>
                                    <p class="text-sm text-gray-500">{{ ucfirst(str_replace('_', ' ', $contract->contract_type)) }}</p>
                                    <p class="text-xs text-gray-400 mt-1">
                                        {{ $contract->start_date->format('M d, Y') }} - {{ $contract->end_date->format('M d, Y') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-{{ $contract->status_badge['color'] }}-100 text-{{ $contract->status_badge['color'] }}-800">
                                        {{ $contract->status_badge['text'] }}
                                    </span>
                                    <p class="text-sm text-gray-500 mt-1">{{ $contract->formatted_salary }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-6">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No contracts</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new contract for this employee.</p>
                        <div class="mt-6">
                            <a href="{{ route('contracts.create') }}?employee_id={{ $employee->id }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                New Contract
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Penalties --}}
            @if($employee->penalties->count() > 0)
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Penalties</h3>
                    <div class="space-y-3">
                        @foreach($employee->penalties->take(5) as $penalty)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="text-sm font-medium text-gray-900">${{ number_format($penalty->amount, 2) }}</p>
                                <p class="text-sm text-gray-500">{{ $penalty->reason }}</p>
                                <p class="text-xs text-gray-400">{{ $penalty->applied_date->format('M d, Y') }}</p>
                            </div>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $penalty->status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($penalty->status) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                    @if($employee->penalties->count() > 5)
                    <div class="mt-4 text-center">
                        <a href="{{ route('penalties.index') }}?employee_id={{ $employee->id }}" 
                           class="text-indigo-600 hover:text-indigo-500 text-sm font-medium">
                            View All Penalties →
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            {{-- Recent Notifications --}}
            @if($employee->notifications->count() > 0)
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Notifications</h3>
                    <div class="space-y-3">
                        @foreach($employee->notifications->take(5) as $notification)
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                @if($notification->type == 'expiry_warning')
                                <div class="h-8 w-8 rounded-full bg-yellow-100 flex items-center justify-center">
                                    <svg class="h-5 w-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                </div>
                                @elseif($notification->type == 'contract_expired')
                                <div class="h-8 w-8 rounded-full bg-red-100 flex items-center justify-center">
                                    <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                @else
                                <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $notification->title }}</p>
                                <p class="text-sm text-gray-500">{{ $notification->message }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if($employee->notifications->count() > 5)
                    <div class="mt-4 text-center">
                        <a href="{{ route('notifications.index') }}?employee_id={{ $employee->id }}" 
                           class="text-indigo-600 hover:text-indigo-500 text-sm font-medium">
                            View All Notifications →
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

</div>
