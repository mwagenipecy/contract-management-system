<div>
{{-- resources/views/livewire/contracts/create.blade.php --}}

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
                        <span class="ml-4 text-sm font-medium text-gray-500">New Contract</span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="mt-4">
            <h1 class="text-2xl font-bold text-gray-900">Create New Contract</h1>
            <p class="mt-1 text-sm text-gray-600">Fill in the contract details below to create a new employment contract.</p>
        </div>
    </div>

    {{-- Form --}}
    <form wire:submit.prevent="save">
        <div class="space-y-8">
            {{-- Contract Information --}}
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">Contract Information</h3>
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        {{-- Contract Number --}}
                        <div class="sm:col-span-2">
                            <label for="contract_number" class="block text-sm font-medium text-gray-700">Contract Number</label>
                            <div class="mt-1">
                                <input wire:model="contract_number" 
                                       type="text" 
                                       id="contract_number"
                                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('contract_number') border-red-300 @enderror"
                                       readonly>
                            </div>
                            @error('contract_number')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Employee Selection --}}
                        <div class="sm:col-span-4">
                            <label for="employee_id" class="block text-sm font-medium text-gray-700">Employee *</label>
                            <div class="mt-1">
                                <select wire:model.live="employee_id" 
                                        id="employee_id"
                                        required
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('employee_id') border-red-300 @enderror">
                                    <option value="">Select Employee</option>
                                    @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">
                                        {{ $employee->name }} ({{ $employee->employee_id }}) - {{ $employee->position }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('employee_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Selected Employee Info --}}
                        @if($selectedEmployee)
                        <div class="sm:col-span-6">
                            <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-blue-800">Selected Employee</h3>
                                        <div class="mt-2 text-sm text-blue-700">
                                            <p><strong>Name:</strong> {{ $selectedEmployee->name }}</p>
                                            <p><strong>Position:</strong> {{ $selectedEmployee->position }}</p>
                                            <p><strong>Department:</strong> {{ $selectedEmployee->department }}</p>
                                            <p><strong>Email:</strong> {{ $selectedEmployee->email }}</p>
                                            <p><strong>Hire Date:</strong> {{ $selectedEmployee->hire_date->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        {{-- Contract Type --}}
                        <div class="sm:col-span-2">
                            <label for="contract_type" class="block text-sm font-medium text-gray-700">Contract Type *</label>
                            <div class="mt-1">
                                <select wire:model="contract_type" 
                                        id="contract_type"
                                        required
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('contract_type') border-red-300 @enderror">
                                    <option value="full_time">Full Time</option>
                                    <option value="part_time">Part Time</option>
                                    <option value="contract">Contract</option>
                                    <option value="internship">Internship</option>
                                </select>
                            </div>
                            @error('contract_type')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="sm:col-span-2">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                            <div class="mt-1">
                                <select wire:model="status" 
                                        id="status"
                                        required
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('status') border-red-300 @enderror">
                                    <option value="draft">Draft</option>
                                    <option value="active">Active</option>
                                </select>
                            </div>
                            @error('status')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Currency --}}
                        <div class="sm:col-span-2">
                            <label for="currency" class="block text-sm font-medium text-gray-700">Currency *</label>
                            <div class="mt-1">
                                <select wire:model="currency" 
                                        id="currency"
                                        required
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('currency') border-red-300 @enderror">
                                    <option value="USD">USD - US Dollar</option>
                                    <option value="EUR">EUR - Euro</option>
                                    <option value="GBP">GBP - British Pound</option>
                                    <option value="TZS">TZS - Tanzanian Shilling</option>
                                    <option value="KES">KES - Kenyan Shilling</option>
                                </select>
                            </div>
                            @error('currency')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contract Dates --}}
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">Contract Duration</h3>
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        {{-- Start Date --}}
                        <div class="sm:col-span-3">
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date *</label>
                            <div class="mt-1">
                                <input wire:model.live="start_date" 
                                       type="date" 
                                       id="start_date"
                                       required
                                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('start_date') border-red-300 @enderror">
                            </div>
                            @error('start_date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- End Date --}}
                        <div class="sm:col-span-3">
                            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date *</label>
                            <div class="mt-1">
                                <input wire:model="end_date" 
                                       type="date" 
                                       id="end_date"
                                       required
                                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('end_date') border-red-300 @enderror">
                            </div>
                            @error('end_date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Duration Display --}}
                        @if($start_date && $end_date)
                        <div class="sm:col-span-6">
                            <div class="bg-green-50 border border-green-200 rounded-md p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-green-800">Contract Duration</h3>
                                        <div class="mt-2 text-sm text-green-700">
                                            @php
                                                $duration = \Carbon\Carbon::parse($start_date)->diffInDays(\Carbon\Carbon::parse($end_date));
                                                $years = floor($duration / 365);
                                                $months = floor(($duration % 365) / 30);
                                                $days = $duration % 30;
                                            @endphp
                                            <p>
                                                <strong>Total Duration:</strong> 
                                                @if($years > 0) {{ $years }} year{{ $years != 1 ? 's' : '' }} @endif
                                                @if($months > 0) {{ $months }} month{{ $months != 1 ? 's' : '' }} @endif
                                                @if($days > 0) {{ $days }} day{{ $days != 1 ? 's' : '' }} @endif
                                                ({{ $duration }} days)
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Compensation --}}
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">Compensation</h3>
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        {{-- Salary --}}
                        <div class="sm:col-span-3">
                            <label for="salary" class="block text-sm font-medium text-gray-700">Annual Salary *</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">{{ $currency }}</span>
                                </div>
                                <input wire:model="salary" 
                                       type="number" 
                                       id="salary"
                                       step="0.01"
                                       min="0"
                                       required
                                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-12 pr-12 sm:text-sm border-gray-300 rounded-md @error('salary') border-red-300 @enderror"
                                       placeholder="0.00">
                            </div>
                            @error('salary')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Salary Breakdown --}}
                        @if($salary)
                        <div class="sm:col-span-3">
                            <label class="block text-sm font-medium text-gray-700">Salary Breakdown</label>
                            <div class="mt-1 space-y-1">
                                <div class="text-sm text-gray-600">
                                    <span class="font-medium">Monthly:</span> {{ $currency }} {{ number_format($salary / 12, 2) }}
                                </div>
                                <div class="text-sm text-gray-600">
                                    <span class="font-medium">Bi-weekly:</span> {{ $currency }} {{ number_format($salary / 26, 2) }}
                                </div>
                                <div class="text-sm text-gray-600">
                                    <span class="font-medium">Weekly:</span> {{ $currency }} {{ number_format($salary / 52, 2) }}
                                </div>
                                <div class="text-sm text-gray-600">
                                    <span class="font-medium">Daily:</span> {{ $currency }} {{ number_format($salary / 365, 2) }}
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Contract Settings --}}
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">Contract Settings</h3>
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        {{-- Renewal Notice Period --}}
                        <div class="sm:col-span-3">
                            <label for="renewal_notice_period" class="block text-sm font-medium text-gray-700">Renewal Notice Period (Days) *</label>
                            <div class="mt-1">
                                <input wire:model="renewal_notice_period" 
                                       type="number" 
                                       id="renewal_notice_period"
                                       min="1"
                                       max="365"
                                       required
                                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('renewal_notice_period') border-red-300 @enderror">
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Number of days before contract expiry to send renewal notices</p>
                            @error('renewal_notice_period')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Auto Renewal --}}
                        <div class="sm:col-span-3">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input wire:model="auto_renewal" 
                                           id="auto_renewal" 
                                           type="checkbox" 
                                           class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="auto_renewal" class="font-medium text-gray-700">Auto Renewal</label>
                                    <p class="text-gray-500">Automatically renew this contract for the same duration</p>
                                </div>
                            </div>
                            @error('auto_renewal')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Terms and Conditions --}}
                        <div class="sm:col-span-6">
                            <label for="terms_and_conditions" class="block text-sm font-medium text-gray-700">Terms and Conditions</label>
                            <div class="mt-1">
                                <textarea wire:model="terms_and_conditions" 
                                          id="terms_and_conditions"
                                          rows="5"
                                          class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('terms_and_conditions') border-red-300 @enderror"
                                          placeholder="Enter contract terms and conditions..."></textarea>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Maximum 2000 characters</p>
                            @error('terms_and_conditions')
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
                <a href="{{ route('contract.index') }}" 
                   class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </a>
                <button type="submit" 
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Create Contract
                </button>
            </div>
        </div>
    </form>
</div>


</div>
