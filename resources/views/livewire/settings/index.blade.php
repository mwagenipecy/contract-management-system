<div>
{{-- resources/views/livewire/settings/index.blade.php --}}
@section('page-title', 'Settings')

<div class="px-4 sm:px-6 lg:px-8">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Settings</h1>
        <p class="mt-2 text-sm text-gray-700">Configure system settings and preferences for the contract management system.</p>
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

    <div class="bg-white shadow rounded-lg">
        {{-- Tabs --}}
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 px-6">
                <button wire:click="setActiveTab('general')"
                        class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'general' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    General
                </button>
                <button wire:click="setActiveTab('notifications')"
                        class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'notifications' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5l-5-5h5v-2a4 4 0 01-4-4V9a3 3 0 013-3h4a3 3 0 013 3v1a4 4 0 01-4 4v2z"></path>
                    </svg>
                    Notifications
                </button>
                <button wire:click="setActiveTab('penalties')"
                        class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'penalties' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Penalties
                </button>
                <button wire:click="setActiveTab('contracts')"
                        class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'contracts' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Contracts
                </button>
                <button wire:click="setActiveTab('email')"
                        class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === 'email' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Email
                </button>
            </nav>
        </div>

        <div class="p-6">
            {{-- General Settings Tab --}}
            @if($activeTab === 'general')
            <form wire:submit.prevent="saveGeneralSettings">
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">General Settings</h3>
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            {{-- Penalty Rate --}}
                            <div class="sm:col-span-2">
                                <label for="penalty_rate_per_day" class="block text-sm font-medium text-gray-700">Penalty Rate *</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input wire:model="penalty_rate_per_day" 
                                           type="number" 
                                           id="penalty_rate_per_day"
                                           step="0.01"
                                           min="0"
                                           required
                                           class="block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md"
                                           placeholder="50.00">
                                </div>
                                @error('penalty_rate_per_day') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- Penalty Type --}}
                            <div class="sm:col-span-2">
                                <label for="penalty_type" class="block text-sm font-medium text-gray-700">Penalty Type *</label>
                                <select wire:model="penalty_type" 
                                        id="penalty_type"
                                        required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="daily">Daily Rate</option>
                                    <option value="fixed">Fixed Amount</option>
                                </select>
                                @error('penalty_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- Grace Period --}}
                            <div class="sm:col-span-2">
                                <label for="grace_period_days" class="block text-sm font-medium text-gray-700">Grace Period (Days) *</label>
                                <input wire:model="grace_period_days" 
                                       type="number" 
                                       id="grace_period_days"
                                       min="0"
                                       required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error('grace_period_days') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- Penalty Currency --}}
                            <div class="sm:col-span-2">
                                <label for="penalty_currency" class="block text-sm font-medium text-gray-700">Penalty Currency *</label>
                                <select wire:model="penalty_currency" 
                                        id="penalty_currency"
                                        required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="USD">USD - US Dollar</option>
                                    <option value="EUR">EUR - Euro</option>
                                    <option value="GBP">GBP - British Pound</option>
                                    <option value="TZS">TZS - Tanzanian Shilling</option>
                                    <option value="KES">KES - Kenyan Shilling</option>
                                </select>
                                @error('penalty_currency') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- Auto Apply Penalties --}}
                            <div class="sm:col-span-6">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input wire:model="auto_apply_penalties" 
                                               id="auto_apply_penalties" 
                                               type="checkbox" 
                                               class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="auto_apply_penalties" class="font-medium text-gray-700">Auto Apply Penalties</label>
                                        <p class="text-gray-500">Automatically apply penalties when contracts expire beyond grace period</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-5">
                    <div class="flex justify-end">
                        <button type="submit" 
                                class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save Penalty Settings
                        </button>
                    </div>
                </div>
            </form>

            {{-- Contract Settings Tab --}}
            @elseif($activeTab === 'contracts')
            <form wire:submit.prevent="saveContractSettings">
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Contract Settings</h3>
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            {{-- Default Contract Duration --}}
                            <div class="sm:col-span-2">
                                <label for="default_contract_duration_years" class="block text-sm font-medium text-gray-700">Default Duration (Years) *</label>
                                <input wire:model="default_contract_duration_years" 
                                       type="number" 
                                       id="default_contract_duration_years"
                                       min="1"
                                       required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error('default_contract_duration_years') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- Default Renewal Notice Period --}}
                            <div class="sm:col-span-2">
                                <label for="default_renewal_notice_period" class="block text-sm font-medium text-gray-700">Renewal Notice Period (Days) *</label>
                                <input wire:model="default_renewal_notice_period" 
                                       type="number" 
                                       id="default_renewal_notice_period"
                                       min="1"
                                       required
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error('default_renewal_notice_period') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- Contract Number Prefix --}}
                            <div class="sm:col-span-2">
                                <label for="contract_number_prefix" class="block text-sm font-medium text-gray-700">Contract Number Prefix *</label>
                                <input wire:model="contract_number_prefix" 
                                       type="text" 
                                       id="contract_number_prefix"
                                       required
                                       maxlength="10"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error('contract_number_prefix') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- Auto Renewal --}}
                            <div class="sm:col-span-6">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input wire:model="auto_renewal_enabled" 
                                               id="auto_renewal_enabled" 
                                               type="checkbox" 
                                               class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="auto_renewal_enabled" class="font-medium text-gray-700">Enable Auto Renewal by Default</label>
                                        <p class="text-gray-500">New contracts will have auto-renewal enabled by default</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-5">
                    <div class="flex justify-end">
                        <button type="submit" 
                                class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save Contract Settings
                        </button>
                    </div>
                </div>
            </form>

            {{-- Email Settings Tab --}}
            @elseif($activeTab === 'email')
            <form wire:submit.prevent="saveEmailSettings">
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Email Configuration</h3>
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            {{-- SMTP Host --}}
                            <div class="sm:col-span-3">
                                <label for="smtp_host" class="block text-sm font-medium text-gray-700">SMTP Host</label>
                                <input wire:model="smtp_host" 
                                       type="text" 
                                       id="smtp_host"
                                       placeholder="smtp.gmail.com"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error('smtp_host') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- SMTP Port --}}
                            <div class="sm:col-span-1">
                                <label for="smtp_port" class="block text-sm font-medium text-gray-700">SMTP Port</label>
                                <input wire:model="smtp_port" 
                                       type="number" 
                                       id="smtp_port"
                                       min="1"
                                       max="65535"
                                       placeholder="587"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error('smtp_port') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- SMTP Encryption --}}
                            <div class="sm:col-span-2">
                                <label for="smtp_encryption" class="block text-sm font-medium text-gray-700">Encryption</label>
                                <select wire:model="smtp_encryption" 
                                        id="smtp_encryption"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">None</option>
                                    <option value="tls">TLS</option>
                                    <option value="ssl">SSL</option>
                                </select>
                                @error('smtp_encryption') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- SMTP Username --}}
                            <div class="sm:col-span-3">
                                <label for="smtp_username" class="block text-sm font-medium text-gray-700">SMTP Username</label>
                                <input wire:model="smtp_username" 
                                       type="text" 
                                       id="smtp_username"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error('smtp_username') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- SMTP Password --}}
                            <div class="sm:col-span-3">
                                <label for="smtp_password" class="block text-sm font-medium text-gray-700">SMTP Password</label>
                                <input wire:model="smtp_password" 
                                       type="password" 
                                       id="smtp_password"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error('smtp_password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-5">
                    <div class="flex justify-end space-x-3">
                        <button type="button" 
                                wire:click="testEmailConfiguration"
                                class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Test Configuration
                        </button>
                        <button type="submit" 
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save Email Settings
                        </button>
                    </div>
                </div>
            </form>
            @endif
        </div>
    </div>
</div>