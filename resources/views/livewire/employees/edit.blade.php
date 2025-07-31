<div>
{{-- resources/views/livewire/employees/edit.blade.php --}}
@section('page-title', 'Edit Employee')

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
                        <a href="{{ route('employees.show', $employee) }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">{{ $employee->name }}</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-4 text-sm font-medium text-gray-500">Edit</span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="mt-4">
            <h1 class="text-2xl font-bold text-gray-900">Edit Employee</h1>
            <p class="mt-1 text-sm text-gray-600">Update {{ $employee->name }}'s information and employment details.</p>
        </div>
    </div>

    {{-- Current Employee Summary --}}
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-8">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Current Employee Information</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <p><strong>Employee ID:</strong> {{ $employee->employee_id }} | <strong>Position:</strong> {{ $employee->position }} | <strong>Department:</strong> {{ $employee->department }}</p>
                    <p><strong>Email:</strong> {{ $employee->email }} | <strong>Status:</strong> 
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-{{ $employee->status_badge['color'] }}-100 text-{{ $employee->status_badge['color'] }}-800">
                            {{ $employee->status_badge['text'] }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Form --}}
    <form wire:submit.prevent="update">
        <div class="space-y-8">
            {{-- Basic Information --}}
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">Basic Information</h3>
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        {{-- Employee ID --}}
                        <div class="sm:col-span-2">
                            <label for="employee_id" class="block text-sm font-medium text-gray-700">Employee ID *</label>
                            <div class="mt-1">
                                <input wire:model="employee_id" 
                                       type="text" 
                                       id="employee_id"
                                       required
                                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('employee_id') border-red-300 @enderror">
                            </div>
                            @error('employee_id')
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
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="terminated">Terminated</option>
                                </select>
                            </div>
                            @error('status')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Last Updated --}}
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                            <div class="mt-1 text-sm text-gray-500">
                                {{ $employee->updated_at->format('M d, Y \a\t g:i A') }}
                            </div>
                        </div>

                        {{-- Full Name --}}
                        <div class="sm:col-span-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name *</label>
                            <div class="mt-1">
                                <input wire:model="name" 
                                       type="text" 
                                       id="name"
                                       required
                                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('name') border-red-300 @enderror">
                            </div>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="sm:col-span-3">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address *</label>
                            <div class="mt-1">
                                <input wire:model="email" 
                                       type="email" 
                                       id="email"
                                       required
                                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('email') border-red-300 @enderror">
                            </div>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div class="sm:col-span-3">
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <div class="mt-1">
                                <input wire:model="phone" 
                                       type="tel" 
                                       id="phone"
                                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('phone') border-red-300 @enderror">
                            </div>
                            @error('phone')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Position --}}
                        <div class="sm:col-span-3">
                            <label for="position" class="block text-sm font-medium text-gray-700">Position *</label>
                            <div class="mt-1">
                                <input wire:model="position" 
                                       type="text" 
                                       id="position"
                                       required
                                       list="common-positions"
                                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('position') border-red-300 @enderror">
                                <datalist id="common-positions">
                                    <option value="Software Engineer">
                                    <option value="Senior Developer">
                                    <option value="Product Manager">
                                    <option value="Marketing Manager">
                                    <option value="Sales Representative">
                                    <option value="UX Designer">
                                    <option value="Project Manager">
                                    <option value="Data Analyst">
                                    <option value="HR Manager">
                                    <option value="Finance Manager">
                                </datalist>
                            </div>
                            @error('position')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Department --}}
                        <div class="sm:col-span-3">
                            <label for="department" class="block text-sm font-medium text-gray-700">Department *</label>
                            <div class="mt-1">
                                <select wire:model="department" 
                                        id="department"
                                        required
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('department') border-red-300 @enderror">
                                    <option value="">Select Department</option>
                                    <option value="Engineering">Engineering</option>
                                    <option value="Marketing">Marketing</option>
                                    <option value="Sales">Sales</option>
                                    <option value="Product">Product</option>
                                    <option value="Design">Design</option>
                                    <option value="Operations">Operations</option>
                                    <option value="Analytics">Analytics</option>
                                    <option value="HR">Human Resources</option>
                                    <option value="Finance">Finance</option>
                                    <option value="Legal">Legal</option>
                                </select>
                            </div>
                            @error('department')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Hire Date --}}
                        <div class="sm:col-span-2">
                            <label for="hire_date" class="block text-sm font-medium text-gray-700">Hire Date *</label>
                            <div class="mt-1">
                                <input wire:model="hire_date" 
                                       type="date" 
                                       id="hire_date"
                                       required
                                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('hire_date') border-red-300 @enderror">
                            </div>
                            @error('hire_date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Address --}}
                        <div class="sm:col-span-6">
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <div class="mt-1">
                                <textarea wire:model="address" 
                                          id="address"
                                          rows="3"
                                          class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('address') border-red-300 @enderror"
                                          placeholder="Enter full address..."></textarea>
                            </div>
                            @error('address')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Emergency Contact --}}
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">Emergency Contact</h3>
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        {{-- Emergency Contact Name --}}
                        <div class="sm:col-span-3">
                            <label for="emergency_contact_name" class="block text-sm font-medium text-gray-700">Contact Name</label>
                            <div class="mt-1">
                                <input wire:model="emergency_contact_name" 
                                       type="text" 
                                       id="emergency_contact_name"
                                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('emergency_contact_name') border-red-300 @enderror">
                            </div>
                            @error('emergency_contact_name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Emergency Contact Phone --}}
                        <div class="sm:col-span-3">
                            <label for="emergency_contact_phone" class="block text-sm font-medium text-gray-700">Contact Phone</label>
                            <div class="mt-1">
                                <input wire:model="emergency_contact_phone" 
                                       type="tel" 
                                       id="emergency_contact_phone"
                                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('emergency_contact_phone') border-red-300 @enderror">
                            </div>
                            @error('emergency_contact_phone')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Employment History Summary --}}
            @if($employee->contracts->count() > 0)
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">Employment Summary</h3>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <dt class="text-sm font-medium text-gray-500">Total Contracts</dt>
                            <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ $employee->contracts->count() }}</dd>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <dt class="text-sm font-medium text-gray-500">Active Contract</dt>
                            <dd class="mt-1 text-2xl font-semibold text-gray-900">
                                @if($employee->hasActiveContract())
                                    <span class="text-green-600">Yes</span>
                                @else
                                    <span class="text-red-600">No</span>
                                @endif
                            </dd>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <dt class="text-sm font-medium text-gray-500">Years of Service</dt>
                            <dd class="mt-1 text-2xl font-semibold text-gray-900">
                                {{ $employee->hire_date->diffInYears(now()) }}
                            </dd>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        {{-- Form Actions --}}
        <div class="pt-8">
            <div class="flex justify-end space-x-3">
                <a href="{{ route('employees.show', $employee) }}" 
                   class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </a>
                <button type="submit" 
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Update Employee
                </button>
            </div>
        </div>
    </form>
</div>

</div>
