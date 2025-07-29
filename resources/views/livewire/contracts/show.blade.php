<div>
{{-- resources/views/livewire/contracts/show.blade.php --}}
@section('page-title', $contract->contract_number)

<div class="px-4 sm:px-6 lg:px-8">
    {{-- Header --}}
    <div class="mb-8">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-4">
                <li>
                    <div>
                        <a href="{{ route('contract.index') }}" class="text-gray-400 hover:text-gray-500">
                            <svg class="flex-shrink-0 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="sr-only">Contracts</span>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('contract.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Contracts</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-4 text-sm font-medium text-gray-500">{{ $contract->contract_number }}</span>
                    </div>
                </li>
            </ol>
        </nav>
        
        <div class="mt-4 md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h1 class="text-2xl font-bold text-gray-900 sm:truncate">{{ $contract->contract_number }}</h1>
                <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                    <div class="mt-2 flex items-center text-sm text-gray-500">
                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ $contract->employee->name }}
                    </div>
                    <div class="mt-2 flex items-center text-sm text-gray-500">
                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h8a2 2 0 012 2v4m0 0V7a2 2 0 11-4 0V3M8 7V3a2 2 0 014 0v4m0 0v8a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h4z"></path>
                        </svg>
                        {{ ucfirst(str_replace('_', ' ', $contract->contract_type)) }}
                    </div>
                    <div class="mt-2 flex items-center text-sm text-gray-500">
                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h8a2 2 0 012 2v4m0 0V7a2 2 0 11-4 0V3M8 7V3a2 2 0 014 0v4m0 0v8a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h4z"></path>
                        </svg>
                        {{ $contract->start_date->format('M d, Y') }} - {{ $contract->end_date->format('M d, Y') }}
                    </div>
                </div>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
                @if($contract->status === 'draft')
                <button wire:click="activateContract" 
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Activate
                </button>
                @endif

                @if($contract->canBeRenewed())
                <a href="{{ route('contracts.renew', $contract) }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Renew
                </a>
                @endif

                <a href="{{ route('contracts.edit', $contract) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>

                <button wire:click="exportContract" 
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export
                </button>
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
        {{-- Contract Details --}}
        <div class="lg:col-span-2">
            {{-- Contract Status --}}
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Contract Status</h3>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-{{ $contract->status_badge['color'] }}-100 text-{{ $contract->status_badge['color'] }}-800">
                            {{ $contract->status_badge['text'] }}
                        </span>
                    </div>

                    @if($contract->isExpired())
                    <div class="rounded-md bg-red-50 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Contract Expired</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <p>This contract expired {{ $contract->getDaysOverdue() }} days ago on {{ $contract->end_date->format('M d, Y') }}. Please renew or terminate the contract.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @elseif($contract->isExpiringSoon(30))
                    <div class="rounded-md bg-yellow-50 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Contract Expiring Soon</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>This contract will expire in {{ $contract->days_until_expiry }} days on {{ $contract->end_date->format('M d, Y') }}. Consider renewing the contract.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Days Until Expiry</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($contract->isExpired())
                                    <span class="text-red-600 font-medium">Expired {{ $contract->getDaysOverdue() }} days ago</span>
                                @else
                                    <span class="text-green-600 font-medium">{{ $contract->days_until_expiry }} days</span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Contract Duration</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $contract->duration_in_years }} years ({{ $contract->duration }} days)</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Auto Renewal</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $contract->auto_renewal ? 'Enabled' : 'Disabled' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Renewal Notice Period</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $contract->renewal_notice_period }} days</dd>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contract Information --}}
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Contract Information</h3>
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Contract Number</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $contract->contract_number }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Contract Type</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $contract->contract_type)) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Start Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $contract->start_date->format('M d, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">End Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $contract->end_date->format('M d, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Annual Salary</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $contract->formatted_salary }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Monthly Salary</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $contract->currency }} {{ number_format($contract->salary / 12, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Created Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $contract->created_at->format('M d, Y') }}</dd>
                        </div>
                        @if($contract->approved_at)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Approved Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $contract->approved_at->format('M d, Y') }}</dd>
                        </div>
                        @endif
                    </dl>
                </div>
            </div>

            {{-- Terms and Conditions --}}
            @if($contract->terms_and_conditions)
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Terms and Conditions</h3>
                    <div class="prose prose-sm max-w-none">
                        <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $contract->terms_and_conditions }}</p>
                    </div>
                </div>
            </div>
            @endif

            {{-- Contract History --}}
            @if($contract->renewals->count() > 0)
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Renewal History</h3>
                    <div class="space-y-4">
                        @foreach($contract->renewals->sortByDesc('renewal_date') as $renewal)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Renewed on {{ $renewal->renewal_date->format('M d, Y') }}</h4>
                                    <p class="text-sm text-gray-500">by {{ $renewal->createdBy->name ?? 'System' }}</p>
                                </div>
                                <div class="text-right">
                                    @if($renewal->hasSalaryIncrease())
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        +{{ number_format($renewal->salary_increase_percentage, 1) }}% Increase
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-2 grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="font-medium">Period:</span> {{ $renewal->old_end_date->format('M d, Y') }} → {{ $renewal->new_end_date->format('M d, Y') }}
                                </div>
                                <div>
                                    <span class="font-medium">Salary:</span> {{ $contract->currency }} {{ number_format($renewal->old_salary, 2) }} → {{ $contract->currency }} {{ number_format($renewal->new_salary, 2) }}
                                </div>
                            </div>
                            @if($renewal->renewal_notes)
                            <div class="mt-2">
                                <p class="text-sm text-gray-600">{{ $renewal->renewal_notes }}</p>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="lg:col-span-1">
            {{-- Employee Information --}}
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Employee Details</h3>
                    <div class="text-center mb-4">
                        <div class="mx-auto h-16 w-16 rounded-full bg-gray-300 flex items-center justify-center">
                            <span class="text-xl font-medium text-gray-700">{{ substr($contract->employee->name, 0, 2) }}</span>
                        </div>
                        <h4 class="mt-2 text-lg font-medium text-gray-900">{{ $contract->employee->name }}</h4>
                        <p class="text-sm text-gray-500">{{ $contract->employee->position }}</p>
                    </div>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Employee ID</dt>
                            <dd class="text-sm text-gray-900">{{ $contract->employee->employee_id }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Department</dt>
                            <dd class="text-sm text-gray-900">{{ $contract->employee->department }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="text-sm text-gray-900">
                                <a href="mailto:{{ $contract->employee->email }}" class="text-indigo-600 hover:text-indigo-500">
                                    {{ $contract->employee->email }}
                                </a>
                            </dd>
                        </div>
                        @if($contract->employee->phone)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Phone</dt>
                            <dd class="text-sm text-gray-900">
                                <a href="tel:{{ $contract->employee->phone }}" class="text-indigo-600 hover:text-indigo-500">
                                    {{ $contract->employee->phone }}
                                </a>
                            </dd>
                        </div>
                        @endif
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Hire Date</dt>
                            <dd class="text-sm text-gray-900">{{ $contract->employee->hire_date->format('M d, Y') }}</dd>
                        </div>
                    </dl>
                    <div class="mt-4">
                        <a href="{{ route('employees.show', $contract->employee) }}" 
                           class="text-indigo-600 hover:text-indigo-500 text-sm font-medium">
                            View Employee Profile →
                        </a>
                    </div>
                </div>
            </div>

            {{-- Contract Actions --}}
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        @if($contract->status === 'active' && !$contract->isExpired())
                        <button wire:click="suspendContract"
                                wire:confirm="Are you sure you want to suspend this contract?"
                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Suspend Contract
                        </button>
                        @endif

                        <button wire:click="openDeleteModal"
                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-red-300 text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Contract
                        </button>
                    </div>
                </div>
            </div>

            {{-- Related Penalties --}}
            @if($contract->penalties->count() > 0)
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Related Penalties</h3>
                    <div class="space-y-3">
                        @foreach($contract->penalties->take(5) as $penalty)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="text-sm font-medium text-gray-900">${{ number_format($penalty->amount, 2) }}</p>
                                <p class="text-xs text-gray-500">{{ $penalty->reason }}</p>
                                <p class="text-xs text-gray-400">{{ $penalty->applied_date->format('M d, Y') }}</p>
                            </div>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $penalty->status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($penalty->status) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                    @if($contract->penalties->count() > 5)
                    <div class="mt-4 text-center">
                        <a href="{{ route('penalties.index') }}?contract_id={{ $contract->id }}" 
                           class="text-indigo-600 hover:text-indigo-500 text-sm font-medium">
                            View All Penalties →
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            {{-- Recent Notifications --}}
            @if($contract->employee->notifications->count() > 0)
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Notifications</h3>
                    <div class="space-y-3">
                        @foreach($contract->employee->notifications as $notification)
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                @if($notification->type == 'expiry_warning')
                                <div class="h-6 w-6 rounded-full bg-yellow-100 flex items-center justify-center">
                                    <svg class="h-4 w-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                </div>
                                @elseif($notification->type == 'contract_expired')
                                <div class="h-6 w-6 rounded-full bg-red-100 flex items-center justify-center">
                                    <svg class="h-4 w-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                @else
                                <div class="h-6 w-6 rounded-full bg-blue-100 flex items-center justify-center">
                                    <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-gray-900">{{ $notification->title }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $notification->message }}</p>
                                <p class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('notifications.index') }}?employee_id={{ $contract->employee->id }}" 
                           class="text-indigo-600 hover:text-indigo-500 text-sm font-medium">
                            View All Notifications →
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    @if($showDeleteModal)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Delete Contract</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Are you sure you want to delete this contract? This action cannot be undone. All related data including penalties and notifications will also be removed.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="deleteContract" 
                            type="button" 
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Delete Contract
                    </button>
                    <button wire:click="closeDeleteModal" 
                            type="button" 
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

</div>
