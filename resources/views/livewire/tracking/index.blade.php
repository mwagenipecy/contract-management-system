<div>
{{-- resources/views/livewire/tracking/index.blade.php --}}
@section('page-title', 'Contract Tracking')

<div class="px-4 sm:px-6 lg:px-8">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Contract Tracking</h1>
        <p class="mt-2 text-sm text-gray-700">Monitor contract expirations, renewals, and track contract lifecycle.</p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Expiring (7 days)</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['expiring_7_days'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-orange-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Expiring (30 days)</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['expiring_30_days'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Expired</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['expired_total'] }}</dd>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Pending Renewals</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['pending_renewals'] }}</dd>
                        </dl>
                    </div>
                </div>
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

    {{-- Tabs --}}
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <button wire:click="setTab('expiring_soon')"
                            class="py-2 px-1 border-b-2 font-medium text-sm {{ $selectedTab === 'expiring_soon' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Expiring Soon
                        <span class="ml-2 bg-gray-100 text-gray-900 hidden sm:inline-block py-0.5 px-2.5 rounded-full text-xs font-medium">
                            {{ $expiringContracts->count() }}
                        </span>
                    </button>
                    <button wire:click="setTab('expired')"
                            class="py-2 px-1 border-b-2 font-medium text-sm {{ $selectedTab === 'expired' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Expired
                        <span class="ml-2 bg-gray-100 text-gray-900 hidden sm:inline-block py-0.5 px-2.5 rounded-full text-xs font-medium">
                            {{ $expiredContracts->count() }}
                        </span>
                    </button>
                    <button wire:click="setTab('pending_renewals')"
                            class="py-2 px-1 border-b-2 font-medium text-sm {{ $selectedTab === 'pending_renewals' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Pending Renewals
                        <span class="ml-2 bg-gray-100 text-gray-900 hidden sm:inline-block py-0.5 px-2.5 rounded-full text-xs font-medium">
                            {{ $pendingRenewals->count() }}
                        </span>
                    </button>
                    <button wire:click="setTab('upcoming_starts')"
                            class="py-2 px-1 border-b-2 font-medium text-sm {{ $selectedTab === 'upcoming_starts' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Upcoming Starts
                        <span class="ml-2 bg-gray-100 text-gray-900 hidden sm:inline-block py-0.5 px-2.5 rounded-full text-xs font-medium">
                            {{ $upcomingStarts->count() }}
                        </span>
                    </button>
                </nav>
            </div>

            <div class="mt-6">
                {{-- Expiring Soon Tab --}}
                @if($selectedTab === 'expiring_soon')
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Contracts Expiring Soon</h3>
                        <div class="flex items-center space-x-2">
                            <label for="filterDays" class="text-sm text-gray-700">Show contracts expiring within:</label>
                            <select wire:model.live="filterDays" id="filterDays" class="text-sm border-gray-300 rounded-md">
                                <option value="7">7 days</option>
                                <option value="15">15 days</option>
                                <option value="30">30 days</option>
                                <option value="60">60 days</option>
                            </select>
                        </div>
                    </div>
                    
                    @forelse($expiringContracts as $contract)
                    <div class="border border-gray-200 rounded-lg p-4 {{ $contract->days_until_expiry <= 7 ? 'bg-red-50 border-red-200' : ($contract->days_until_expiry <= 15 ? 'bg-yellow-50 border-yellow-200' : 'bg-white') }}">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                        <span class="text-sm font-medium text-gray-700">{{ substr($contract->employee->name, 0, 2) }}</span>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">{{ $contract->employee->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $contract->employee->position }} • {{ $contract->contract_number }}</p>
                                    <p class="text-xs text-gray-400">{{ ucfirst(str_replace('_', ' ', $contract->contract_type)) }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="flex items-center space-x-2">
                                    @if($contract->days_until_expiry <= 0)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            Expired
                                        </span>
                                    @elseif($contract->days_until_expiry <= 7)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            {{ $contract->days_until_expiry }} days left
                                        </span>
                                    @elseif($contract->days_until_expiry <= 15)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            {{ $contract->days_until_expiry }} days left
                                        </span>
                                    @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ $contract->days_until_expiry }} days left
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Expires {{ $contract->end_date->format('M d, Y') }}</p>
                                <div class="mt-2 flex space-x-2">
                                    <button wire:click="markForRenewal({{ $contract->id }})"
                                            class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded hover:bg-blue-200">
                                        Mark for Renewal
                                    </button>
                                    <button wire:click="extendContract({{ $contract->id }})"
                                            class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded hover:bg-green-200">
                                        Extend 1 Year
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-6">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No expiring contracts</h3>
                        <p class="mt-1 text-sm text-gray-500">Great! No contracts are expiring in the next {{ $filterDays }} days.</p>
                    </div>
                    @endforelse
                </div>

                {{-- Expired Tab --}}
                @elseif($selectedTab === 'expired')
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900">Expired Contracts</h3>
                    
                    @forelse($expiredContracts as $contract)
                    <div class="border border-red-200 rounded-lg p-4 bg-red-50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                        <span class="text-sm font-medium text-gray-700">{{ substr($contract->employee->name, 0, 2) }}</span>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">{{ $contract->employee->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $contract->employee->position }} • {{ $contract->contract_number }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    Expired {{ $contract->getDaysOverdue() }} days ago
                                </span>
                                <p class="text-xs text-gray-500 mt-1">Expired {{ $contract->end_date->format('M d, Y') }}</p>
                                <div class="mt-2 flex space-x-2">
                                    <button wire:click="markForRenewal({{ $contract->id }})"
                                            class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded hover:bg-blue-200">
                                        Renew Contract
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-6">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No expired contracts</h3>
                        <p class="mt-1 text-sm text-gray-500">All contracts are current.</p>
                    </div>
                    @endforelse
                </div>

                {{-- Pending Renewals Tab --}}
                @elseif($selectedTab === 'pending_renewals')
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900">Pending Renewals</h3>
                    
                    @forelse($pendingRenewals as $contract)
                    <div class="border border-purple-200 rounded-lg p-4 bg-purple-50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                        <span class="text-sm font-medium text-gray-700">{{ substr($contract->employee->name, 0, 2) }}</span>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">{{ $contract->employee->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $contract->employee->position }} • {{ $contract->contract_number }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                    Pending Renewal
                                </span>
                                <p class="text-xs text-gray-500 mt-1">Original expiry: {{ $contract->end_date->format('M d, Y') }}</p>
                                <div class="mt-2">
                                    <a href="{{ route('contracts.renew', $contract) }}"
                                       class="text-xs bg-indigo-100 text-indigo-800 px-2 py-1 rounded hover:bg-indigo-200">
                                        Process Renewal
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-6">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No pending renewals</h3>
                        <p class="mt-1 text-sm text-gray-500">All renewals have been processed.</p>
                    </div>
                    @endforelse
                </div>

                {{-- Upcoming Starts Tab --}}
                @elseif($selectedTab === 'upcoming_starts')
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900">Upcoming Contract Starts</h3>
                    
                    @forelse($upcomingStarts as $contract)
                    <div class="border border-blue-200 rounded-lg p-4 bg-blue-50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                        <span class="text-sm font-medium text-gray-700">{{ substr($contract->employee->name, 0, 2) }}</span>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">{{ $contract->employee->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $contract->employee->position }} • {{ $contract->contract_number }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Starts {{ $contract->start_date->diffForHumans() }}
                                </span>
                                <p class="text-xs text-gray-500 mt-1">Start date: {{ $contract->start_date->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-6">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h8a2 2 0 012 2v4m0 0V7a2 2 0 11-4 0V3M8 7V3a2 2 0 014 0v4m0 0v8a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h4z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No upcoming starts</h3>
                        <p class="mt-1 text-sm text-gray-500">No contracts are scheduled to start in the future.</p>
                    </div>
                    @endforelse
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

</div>
