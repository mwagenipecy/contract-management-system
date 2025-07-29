<div>
{{-- resources/views/livewire/contracts/renew.blade.php --}}
@section('page-title', 'Renew Contract')

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
                        <a href="{{ route('contracts.show', $contract) }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">{{ $contract->contract_number }}</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-4 text-sm font-medium text-gray-500">Renew</span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="mt-4">
            <h1 class="text-2xl font-bold text-gray-900">Renew Contract</h1>
            <p class="mt-1 text-sm text-gray-600">Extend or modify the contract terms for {{ $contract->employee->name }}</p>
        </div>
    </div>

    {{-- Current Contract Summary --}}
    <div class="bg-white shadow rounded-lg mb-8">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Current Contract Details</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-gray-50 rounded-lg p-4">
                    <dt class="text-sm font-medium text-gray-500">Employee</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $contract->employee->name }}</dd>
                    <dd class="text-xs text-gray-500">{{ $contract->employee->position }}</dd>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <dt class="text-sm font-medium text-gray-500">Contract Number</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $contract->contract_number }}</dd>
                    <dd class="text-xs text-gray-500">{{ ucfirst(str_replace('_', ' ', $contract->contract_type)) }}</dd>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <dt class="text-sm font-medium text-gray-500">Current End Date</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $contract->end_date->format('M d, Y') }}</dd>
                    <dd class="text-xs text-gray-500">
                        @if($contract->isExpired())
                            <span class="text-red-600">Expired {{ $contract->getDaysOverdue() }} days ago</span>
                        @else
                            <span class="text-green-600">{{ $contract->days_until_expiry }} days remaining</span>
                        @endif
                    </dd>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <dt class="text-sm font-medium text-gray-500">Current Salary</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $contract->formatted_salary }}</dd>
                    <dd class="text-xs text-gray-500">Annual</dd>
                </div>
            </div>
        </div>
    </div>

    {{-- Renewal Type Selection --}}
    <div class="bg-white shadow rounded-lg mb-8">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Renewal Type</h3>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div class="relative">
                    <input wire:click="setRenewalType('extend')" 
                           type="radio" 
                           id="extend" 
                           name="renewal_type" 
                           value="extend" 
                           class="sr-only peer"
                           {{ $renewal_type === 'extend' ? 'checked' : '' }}>
                    <label for="extend" class="flex p-5 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:border-indigo-600 peer-checked:text-indigo-600 hover:text-gray-600 hover:bg-gray-100">
                        <div class="block">
                            <div class="w-full text-lg font-semibold">Simple Extension</div>
                            <div class="w-full text-sm">Extend the contract with current terms</div>
                        </div>
                        <svg class="w-5 h-5 ml-3 {{ $renewal_type === 'extend' ? 'text-indigo-600' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </label>
                </div>

                <div class="relative">
                    <input wire:click="setRenewalType('salary_adjustment')" 
                           type="radio" 
                           id="salary_adjustment" 
                           name="renewal_type" 
                           value="salary_adjustment" 
                           class="sr-only peer"
                           {{ $renewal_type === 'salary_adjustment' ? 'checked' : '' }}>
                    <label for="salary_adjustment" class="flex p-5 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:border-indigo-600 peer-checked:text-indigo-600 hover:text-gray-600 hover:bg-gray-100">
                        <div class="block">
                            <div class="w-full text-lg font-semibold">Salary Adjustment</div>
                            <div class="w-full text-sm">Extend with salary changes</div>
                        </div>
                        <svg class="w-5 h-5 ml-3 {{ $renewal_type === 'salary_adjustment' ? 'text-indigo-600' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </label>
                </div>

                <div class="relative">
                    <input wire:click="setRenewalType('new_terms')" 
                           type="radio" 
                           id="new_terms" 
                           name="renewal_type" 
                           value="new_terms" 
                           class="sr-only peer"
                           {{ $renewal_type === 'new_terms' ? 'checked' : '' }}>
                    <label for="new_terms" class="flex p-5 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:border-indigo-600 peer-checked:text-indigo-600 hover:text-gray-600 hover:bg-gray-100">
                        <div class="block">
                            <div class="w-full text-lg font-semibold">New Terms</div>
                            <div class="w-full text-sm">Modify contract terms and conditions</div>
                        </div>
                        <svg class="w-5 h-5 ml-3 {{ $renewal_type === 'new_terms' ? 'text-indigo-600' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </label>
                </div>
            </div>
        </div>
    </div>

    {{-- Renewal Form --}}
    <form wire:submit.prevent="renewContract">
        <div class="space-y-8">
            {{-- Contract Duration --}}
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">Contract Duration</h3>
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        {{-- Duration Selector --}}
                        <div class="sm:col-span-2">
                            <label for="renewal_period_years" class="block text-sm font-medium text-gray-700">Extension Period (Years)</label>
                            <input wire:model.live="renewal_period_years" 
                                   type="number" 
                                   id="renewal_period_years"
                                   min="0"
                                   max="10"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="renewal_period_months" class="block text-sm font-medium text-gray-700">Additional Months</label>
                            <input wire:model.live="renewal_period_months" 
                                   type="number" 
                                   id="renewal_period_months"
                                   min="0"
                                   max="11"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        {{-- New End Date --}}
                        <div class="sm:col-span-2">
                            <label for="new_end_date" class="block text-sm font-medium text-gray-700">New End Date *</label>
                            <input wire:model.live="new_end_date" 
                                   type="date" 
                                   id="new_end_date"
                                   required
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('new_end_date') border-red-300 @enderror">
                            @error('new_end_date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Duration Summary --}}
                        @if($new_duration_days > 0)
                        <div class="sm:col-span-6">
                            <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-blue-800">Contract Extension Summary</h3>
                                        <div class="mt-2 text-sm text-blue-700">
                                            <p><strong>Extension Period:</strong> {{ $new_duration_days }} days ({{ number_format($new_duration_days / 365, 1) }} years)</p>
                                            <p><strong>Original End:</strong> {{ $contract->end_date->format('M d, Y') }}</p>
                                            <p><strong>New End Date:</strong> {{ \Carbon\Carbon::parse($new_end_date)->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Salary Adjustment --}}
            @if($renewal_type === 'salary_adjustment' || $renewal_type === 'new_terms')
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">Salary Adjustment</h3>
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        {{-- Quick Increase Buttons --}}
                        <div class="sm:col-span-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Quick Salary Increases</label>
                            <div class="flex flex-wrap gap-2">
                                <button type="button" wire:click="applySalaryIncrease(3)" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    +3%
                                </button>
                                <button type="button" wire:click="applySalaryIncrease(5)" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    +5%
                                </button>
                                <button type="button" wire:click="applySalaryIncrease(10)" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    +10%
                                </button>
                                <button type="button" wire:click="applySalaryIncrease(15)" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    +15%
                                </button>
                            </div>
                        </div>

                        {{-- Salary Increase Percentage --}}
                        <div class="sm:col-span-2">
                            <label for="salary_increase_percentage" class="block text-sm font-medium text-gray-700">Increase Percentage</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input wire:model.live="salary_increase_percentage" 
                                       type="number" 
                                       id="salary_increase_percentage"
                                       step="0.1"
                                       class="block w-full pr-7 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">%</span>
                                </div>
                            </div>
                        </div>

                        {{-- New Salary --}}
                        <div class="sm:col-span-2">
                            <label for="new_salary" class="block text-sm font-medium text-gray-700">New Annual Salary *</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">{{ $contract->currency }}</span>
                                </div>
                                <input wire:model.live="new_salary" 
                                       type="number" 
                                       id="new_salary"
                                       step="0.01"
                                       min="0"
                                       required
                                       class="block w-full pl-12 pr-12 sm:text-sm border-gray-300 rounded-md @error('new_salary') border-red-300 @enderror">
                            </div>
                            @error('new_salary')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Salary Difference --}}
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Salary Change</label>
                            <div class="mt-1 text-sm {{ $salary_difference >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $salary_difference >= 0 ? '+' : '' }}{{ $contract->currency }} {{ number_format(abs($salary_difference), 2) }}
                                @if($salary_difference != 0)
                                <span class="text-xs text-gray-500">
                                    ({{ $salary_difference >= 0 ? '+' : '' }}{{ number_format($salary_increase_percentage, 1) }}%)
                                </span>
                                @endif
                            </div>
                        </div>

                        {{-- Salary Breakdown --}}
                        @if($new_salary > 0)
                        <div class="sm:col-span-6">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-gray-900 mb-3">New Salary Breakdown</h4>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
                                    <div>
                                        <span class="font-medium text-gray-900">Monthly:</span>
                                        <div class="text-gray-600">{{ $contract->currency }} {{ number_format($new_salary / 12, 2) }}</div>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-900">Bi-weekly:</span>
                                        <div class="text-gray-600">{{ $contract->currency }} {{ number_format($new_salary / 26, 2) }}</div>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-900">Weekly:</span>
                                        <div class="text-gray-600">{{ $contract->currency }} {{ number_format($new_salary / 52, 2) }}</div>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-900">Daily:</span>
                                        <div class="text-gray-600">{{ $contract->currency }} {{ number_format($new_salary / 365, 2) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            {{-- Contract Terms --}}
            @if($renewal_type === 'new_terms')
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">Contract Terms & Conditions</h3>
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        {{-- Terms and Conditions --}}
                        <div class="sm:col-span-6">
                            <label for="new_terms_and_conditions" class="block text-sm font-medium text-gray-700">Terms and Conditions</label>
                            <div class="mt-1">
                                <textarea wire:model="new_terms_and_conditions" 
                                          id="new_terms_and_conditions"
                                          rows="6"
                                          class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('new_terms_and_conditions') border-red-300 @enderror"
                                          placeholder="Enter updated contract terms and conditions..."></textarea>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Maximum 2000 characters</p>
                            @error('new_terms_and_conditions')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Renewal Settings --}}
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">Renewal Settings</h3>
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        {{-- Renewal Notice Period --}}
                        <div class="sm:col-span-2">
                            <label for="renewal_notice_period" class="block text-sm font-medium text-gray-700">Renewal Notice Period (Days) *</label>
                            <input wire:model="renewal_notice_period" 
                                   type="number" 
                                   id="renewal_notice_period"
                                   min="1"
                                   max="365"
                                   required
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('renewal_notice_period') border-red-300 @enderror">
                            @error('renewal_notice_period')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Auto Renewal --}}
                        <div class="sm:col-span-4">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input wire:model="auto_renewal" 
                                           id="auto_renewal" 
                                           type="checkbox" 
                                           class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="auto_renewal" class="font-medium text-gray-700">Enable Auto Renewal</label>
                                    <p class="text-gray-500">Automatically renew this contract for the same duration when it expires</p>
                                </div>
                            </div>
                        </div>

                        {{-- Renewal Notes --}}
                        <div class="sm:col-span-6">
                            <label for="renewal_notes" class="block text-sm font-medium text-gray-700">Renewal Notes</label>
                            <div class="mt-1">
                                <textarea wire:model="renewal_notes" 
                                          id="renewal_notes"
                                          rows="3"
                                          class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('renewal_notes') border-red-300 @enderror"
                                          placeholder="Add notes about this renewal..."></textarea>
                            </div>
                            @error('renewal_notes')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Actions --}}
        <div class="pt-8">
            <div class="flex justify-end space-x-3">
                <a href="{{ route('contracts.show', $contract) }}" 
                   class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </a>
                <button type="submit" 
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Renew Contract
                </button>
            </div>
        </div>
    </form>
</div>

</div>
