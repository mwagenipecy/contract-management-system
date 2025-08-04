<div>
    {{-- Loading Overlay --}}
    <!-- <div wire:loading.class="opacity-50 pointer-events-none" class="min-h-screen bg-gray-50 transition-opacity duration-200"> -->
       

    {{-- Header Section --}}
<div class="bg-white mb-4 shadow-sm border-b border-gray-200">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-6">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-r from-brand-blue to-brand-pink rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h1 class="text-2xl font-bold text-brand-blue">Promotions & Announcements</h1>
                            <p class="text-sm text-gray-500">Create and manage employee communications, updates, and announcements</p>
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <button wire:click="openCreateModal" 
                            wire:loading.attr="disabled"
                            class="inline-flex items-center bg-blue-800  px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-brand-blue to-brand-pink hover:from-brand-blue/90 hover:to-brand-pink/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue transition-all duration-200 disabled:opacity-50">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create Announcement
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>




{{-- Stats Overview --}}
<div class="mb-8">
    <div class="grid mb-6 mx-4 grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-6">
        {{-- Total --}}
        <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow-sm rounded-xl overflow-hidden border border-gray-100 hover:shadow-md transition-shadow duration-200">
            <div>
                <div class="absolute bg-brand-blue rounded-lg p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <p class="ml-16 text-sm font-medium text-gray-500 truncate">Total</p>
            </div>
            <div class="ml-16 flex items-baseline pb-6 sm:pb-7">
                <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total'] ?? 0) }}</p>
            </div>
        </div>

        {{-- Active --}}
        <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow-sm rounded-xl overflow-hidden border border-gray-100 hover:shadow-md transition-shadow duration-200">
            <div>
                <div class="absolute bg-green-500 rounded-lg p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="ml-16 text-sm font-medium text-gray-500 truncate">Active</p>
            </div>
            <div class="ml-16 flex items-baseline pb-6 sm:pb-7">
                <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['active'] ?? 0) }}</p>
            </div>
        </div>

        {{-- Sent --}}
        <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow-sm rounded-xl overflow-hidden border border-gray-100 hover:shadow-md transition-shadow duration-200">
            <div>
                <div class="absolute bg-brand-pink rounded-lg p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </div>
                <p class="ml-16 text-sm font-medium text-gray-500 truncate">Sent</p>
            </div>
            <div class="ml-16 flex items-baseline pb-6 sm:pb-7">
                <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['sent'] ?? 0) }}</p>
            </div>
        </div>

        {{-- Scheduled --}}
        <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow-sm rounded-xl overflow-hidden border border-gray-100 hover:shadow-md transition-shadow duration-200">
            <div>
                <div class="absolute bg-yellow-500 rounded-lg p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="ml-16 text-sm font-medium text-gray-500 truncate">Scheduled</p>
            </div>
            <div class="ml-16 flex items-baseline pb-6 sm:pb-7">
                <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['scheduled'] ?? 0) }}</p>
                @if(($stats['scheduled'] ?? 0) > 0)
                <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                    Pending
                </span>
                @endif
            </div>
        </div>

        {{-- Draft --}}
        <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow-sm rounded-xl overflow-hidden border border-gray-100 hover:shadow-md transition-shadow duration-200">
            <div>
                <div class="absolute bg-gray-500 rounded-lg p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                </div>
                <p class="ml-16 text-sm font-medium text-gray-500 truncate">Draft</p>
            </div>
            <div class="ml-16 flex items-baseline pb-6 sm:pb-7">
                <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['draft'] ?? 0) }}</p>
            </div>
        </div>

        {{-- This Month --}}
        <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow-sm rounded-xl overflow-hidden border border-gray-100 hover:shadow-md transition-shadow duration-200">
            <div>
                <div class="absolute bg-purple-500 rounded-lg p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <p class="ml-16 text-sm font-medium text-gray-500 truncate">This Month</p>
            </div>
            <div class="ml-16 flex items-baseline pb-6 sm:pb-7">
                <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['this_month'] ?? 0) }}</p>
            </div>
        </div>
    </div>
</div>





{{-- Tab Navigation --}}
<div class="border-b p-2 border-gray-200 bg-gray-50">
    <nav class="flex space-x-8 px-6" aria-label="Tabs">
        <button wire:click="setTab('active')" 
                class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap transition-colors duration-200 {{ $activeTab === 'active' ? 'border-brand-blue text-brand-blue' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                Active
                @if(($stats['active'] ?? 0) > 0)
                <span class="ml-2 bg-blue-100 text-brand-blue py-0.5 px-2.5 rounded-full text-xs font-medium">{{ $stats['active'] }}</span>
                @endif
            </span>
        </button>
        
        <button wire:click="setTab('sent')" 
                class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap transition-colors duration-200 {{ $activeTab === 'sent' ? 'border-brand-pink text-brand-pink' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
                Sent
                @if(($stats['sent'] ?? 0) > 0)
                <span class="ml-2 bg-pink-100 text-brand-pink py-0.5 px-2.5 rounded-full text-xs font-medium">{{ $stats['sent'] }}</span>
                @endif
            </span>
        </button>
        
        <button wire:click="setTab('scheduled')" 
                class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap transition-colors duration-200 {{ $activeTab === 'scheduled' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Scheduled
                @if(($stats['scheduled'] ?? 0) > 0)
                <span class="ml-2 bg-yellow-100 text-yellow-600 py-0.5 px-2.5 rounded-full text-xs font-medium">{{ $stats['scheduled'] }}</span>
                @endif
            </span>
        </button>
        
        <button wire:click="setTab('draft')" 
                class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap transition-colors duration-200 {{ $activeTab === 'draft' ? 'border-gray-500 text-gray-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                </svg>
                Drafts
                @if(($stats['draft'] ?? 0) > 0)
                <span class="ml-2 bg-gray-100 text-gray-600 py-0.5 px-2.5 rounded-full text-xs font-medium">{{ $stats['draft'] }}</span>
                @endif
            </span>
        </button>
        
        <button wire:click="setTab('archived')" 
                class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap transition-colors duration-200 {{ $activeTab === 'archived' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8l4 4 4-4m0 0L9 4m4 4v12"></path>
                </svg>
                Archived
            </span>
        </button>
    </nav>
</div>




{{-- Filters Section --}}
<div class="bg-white p-2  px-6 py-4 border-b border-gray-200">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        {{-- Search --}}
        <div class="relative">
            <label for="search" class="sr-only">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text" id="search" 
                       class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-2 focus:ring-brand-blue focus:border-transparent transition duration-150 ease-in-out sm:text-sm"
                       placeholder="Search announcements...">
            </div>
        </div>

        {{-- Type Filter --}}
        <div>
            <label for="filterType" class="sr-only">Filter by type</label>
            <select wire:model.live="filterType" id="filterType" 
                    class="block w-full px-3 py-2.5 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-brand-blue focus:border-transparent sm:text-sm">
                <option value="">All Types</option>
                <option value="promotion"> Promotion</option>
                <option value="announcement"> Announcement</option>
                <option value="update"> Update</option>
                <option value="alert"> Alert</option>
                <option value="celebration"> Celebration</option>
            </select>
        </div>

        {{-- Priority Filter --}}
        <div>
            <label for="filterPriority" class="sr-only">Filter by priority</label>
            <select wire:model.live="filterPriority" id="filterPriority"
                    class="block w-full px-3 py-2.5 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-brand-blue focus:border-transparent sm:text-sm">
                <option value="">All Priorities</option>
                <option value="urgent"> Urgent</option>
                <option value="high">High</option>
                <option value="medium"> Medium</option>
                <option value="low"> Low</option>
            </select>
        </div>

        {{-- Clear Filters --}}
        <div class="flex items-center">
            @if($search || $filterType || $filterPriority)
            <button wire:click="clearFilters" 
                    class="inline-flex items-center px-4 py-2.5 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue transition-colors duration-200">
                <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Clear Filters
            </button>
            @endif
        </div>
    </div>
</div>






{{-- Bulk Actions --}}
@if(!empty($selectedPromotions))
<div class="bg-gradient-to-r mx-4 from-blue-50 to-pink-50 px-6 py-4 border-b border-blue-200">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-brand-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <span class="ml-2 text-sm font-medium text-brand-blue">
                {{ count($selectedPromotions) }} {{ Str::plural('item', count($selectedPromotions)) }} selected
            </span>
        </div>
        <div class="flex space-x-2">
            <button wire:click="bulkActivate" 
                    wire:loading.attr="disabled"
                    wire:confirm="Are you sure you want to activate the selected promotions?"
                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200 disabled:opacity-50">
                <svg class="-ml-0.5 mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span wire:loading.remove wire:target="bulkActivate">Activate</span>
                <span wire:loading wire:target="bulkActivate">Processing...</span>
            </button>
            
            <button wire:click="bulkDeactivate" 
                    wire:loading.attr="disabled"
                    wire:confirm="Are you sure you want to deactivate the selected promotions?"
                    class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue transition-colors duration-200 disabled:opacity-50">
                <svg class="-ml-0.5 mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                </svg>
                <span wire:loading.remove wire:target="bulkDeactivate">Deactivate</span>
                <span wire:loading wire:target="bulkDeactivate">Processing...</span>
            </button>
            
            <button wire:click="bulkDelete" 
                    wire:loading.attr="disabled"
                    wire:confirm="Are you sure you want to delete the selected promotions? This action cannot be undone."
                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200 disabled:opacity-50">
                <svg class="-ml-0.5 mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                <span wire:loading wire:target="bulkDelete">Deleting...</span>
            </button>
        </div>
    </div>
</div>
@endif



{{-- Promotions List --}}
<div class="divide-y mx-4 divide-gray-200">
    @if($promotions && count($promotions) > 0)
        {{-- Select All Header --}}
        <div class="px-6 py-4 bg-gray-50">
            <label class="inline-flex items-center">
                <input wire:model.live="selectAll" type="checkbox" 
                       class="rounded border-gray-300 text-brand-blue shadow-sm focus:border-brand-blue focus:ring focus:ring-brand-blue focus:ring-opacity-50">
                <span class="ml-2 text-sm font-medium text-gray-700">Select All</span>
            </label>
        </div>

        @foreach($promotions as $promotion)
        <div class="px-6 py-6 hover:bg-gray-50 transition-colors duration-150">
            <div class="flex items-start justify-between">
                <div class="flex items-start space-x-4 flex-1">
                    {{-- Checkbox --}}
                    <div class="flex-shrink-0 mt-1">
                        <input wire:model.live="selectedPromotions" value="{{ $promotion->id }}" type="checkbox" 
                               class="rounded border-gray-300 text-brand-blue shadow-sm focus:border-brand-blue focus:ring focus:ring-brand-blue focus:ring-opacity-50">
                    </div>
                    
                    {{-- Content --}}
                    <div class="flex-1 min-w-0">
                        {{-- Header with badges --}}
                        <div class="flex items-center space-x-3 mb-3 flex-wrap">
                            <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $promotion->title }}</h3>
                            
                            {{-- Type Badge --}}
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                @if($promotion->type === 'promotion') bg-green-100 text-green-800
                                @elseif($promotion->type === 'announcement') bg-blue-100 text-blue-800
                                @elseif($promotion->type === 'update') bg-purple-100 text-purple-800
                                @elseif($promotion->type === 'alert') bg-red-100 text-red-800
                                @elseif($promotion->type === 'celebration') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                @switch($promotion->type)
                                    @case('promotion')  @break
                                    @case('announcement')  @break
                                    @case('update')  @break
                                    @case('alert')  @break
                                    @case('celebration') @break
                                @endswitch
                                {{ ucfirst($promotion->type) }}
                            </span>

                            {{-- Priority Badge --}}
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                @if($promotion->priority === 'urgent') bg-red-100 text-red-800
                                @elseif($promotion->priority === 'high') bg-orange-100 text-orange-800
                                @elseif($promotion->priority === 'medium') bg-yellow-100 text-yellow-800
                                @elseif($promotion->priority === 'low') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                @switch($promotion->priority)
                                    @case('urgent')  @break
                                    @case('high')  @break
                                    @case('medium')  @break
                                    @case('low')  @break
                                @endswitch
                                {{ ucfirst($promotion->priority) }}
                            </span>

                            {{-- Status Badge --}}
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                @if($promotion->status === 'sent') bg-green-100 text-green-800
                                @elseif($promotion->status === 'scheduled') bg-yellow-100 text-yellow-800
                                @elseif($promotion->status === 'draft') bg-gray-100 text-gray-800
                                @elseif($promotion->status === 'cancelled') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                @switch($promotion->status)
                                    @case('sent')  Sent @break
                                    @case('scheduled')  Scheduled @break
                                    @case('draft') Draft @break
                                    @case('cancelled')  Cancelled @break
                                    @default {{ ucfirst($promotion->status) }}
                                @endswitch
                            </span>

                            {{-- Active/Inactive Badge --}}
                            @if(!$promotion->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                ⚫ Inactive
                            </span>
                            @endif

                            {{-- Attachments Indicator --}}
                            @if($promotion->hasAttachments())
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                </svg>
                                {{ $promotion->getAttachmentCount() }}
                            </span>
                            @endif
                        </div>

                        {{-- Description --}}
                        <p class="text-sm text-gray-500 mb-2 line-clamp-2">{{ $promotion->content_preview }}</p>
                        
                        {{-- Meta Info --}}
                        <div class="flex items-center space-x-4 text-xs text-gray-400 flex-wrap">
                            <span class="flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ $promotion->createdBy->name ?? 'System' }}
                            </span>
                            
                            <span>•</span>
                            
                            <span class="flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $promotion->created_at->format('M d, Y') }}
                            </span>
                            
                            @if($promotion->sent_at)
                            <span>•</span>
                            <span class="flex items-center text-green-600">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Sent {{ $promotion->sent_at->format('M d, Y H:i') }}
                            </span>
                            @endif
                            
                            @if($promotion->scheduled_at && $promotion->status === 'scheduled')
                            <span>•</span>
                            <span class="flex items-center text-yellow-600 font-medium">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Scheduled for {{ $promotion->scheduled_at->format('M d, Y H:i') }}
                            </span>
                            @endif
                            
                            <span>•</span>
                            <span class="flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                {{ number_format($promotion->total_recipients ?? 0) }} recipients
                            </span>
                            
                            @if($promotion->actual_recipients)
                            <span class="text-green-600">({{ number_format($promotion->actual_recipients) }} delivered)</span>
                            @endif
                            
                            <span>•</span>
                            <span class="flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                {{ $promotion->delivery_methods_text }}
                            </span>
                        </div>

                        {{-- Delivery Stats for Sent Promotions --}}
                        @if($promotion->isSent())
                        @php $deliveryStats = $promotion->getDeliveryStats(); @endphp
                        @if($deliveryStats['total'] > 0)
                        <div class="mt-2 flex items-center space-x-4 text-xs">
                            <span class="flex items-center text-green-600">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ $deliveryStats['sent'] }} sent
                            </span>
                            @if($deliveryStats['failed'] > 0)
                            <span class="flex items-center text-red-600">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                {{ $deliveryStats['failed'] }} failed
                            </span>
                            @endif
                            @if($deliveryStats['pending'] > 0)
                            <span class="flex items-center text-yellow-600">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $deliveryStats['pending'] }} pending
                            </span>
                            @endif
                            <span class="text-gray-500">{{ $deliveryStats['success_rate'] }}% success rate</span>
                        </div>
                        @endif
                        @endif
                    </div>
                </div>

                {{-- Actions --}}
{{-- Promotion Actions --}}
<div class="flex items-center space-x-2 flex-wrap">
    {{-- Preview Button --}}
    <button wire:click="previewPromotion({{ $promotion->id }})"
            class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue transition-colors duration-200">
        <svg class="-ml-0.5 mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
        </svg>
        Preview
    </button>

    {{-- Edit Button --}}
    @if($promotion->canBeEdited())
    <button wire:click="editPromotion({{ $promotion->id }})"
            class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue transition-colors duration-200">
        <svg class="-ml-0.5 mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
        </svg>
        Edit
    </button>
    @endif

    {{-- Send Button --}}
    @if($promotion->canBeSent())
    <button wire:click="openSendModal({{ $promotion->id }})"
            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-brand-blue hover:bg-brand-blue/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue transition-colors duration-200">
        <svg class="-ml-0.5 mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
        </svg>
        Send Now
    </button>
    @endif

    {{-- Toggle Status Button --}}
    <button wire:click="toggleStatus({{ $promotion->id }})"
            wire:loading.attr="disabled"
            wire:target="toggleStatus({{ $promotion->id }})"
            class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue transition-colors duration-200 disabled:opacity-50">
        @if($promotion->is_active)
        <svg class="-ml-0.5 mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
        </svg>
        <span wire:loading.remove wire:target="toggleStatus({{ $promotion->id }})">Deactivate</span>
        @else
        <svg class="-ml-0.5 mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span wire:loading.remove wire:target="toggleStatus({{ $promotion->id }})">Activate</span>
        @endif
        <span wire:loading wire:target="toggleStatus({{ $promotion->id }})" class="flex items-center">
            <svg class="animate-spin -ml-1 mr-1 h-3 w-3" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Processing...
        </span>
    </button>

    {{-- Dropdown Menu --}}
    <div class="relative inline-block text-left" x-data="{ open: false }">
        <button @click="open = !open" 
                class="inline-flex items-center px-2 py-1.5 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue transition-colors duration-200">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
            </svg>
        </button>

        <div x-show="open" @click.away="open = false" x-transition
             class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
            
            {{-- Duplicate --}}
            <button wire:click="duplicatePromotion({{ $promotion->id }})" @click="open = false"
                    class="flex items-center w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
                Duplicate
            </button>
            
            {{-- Delivery Report (for sent promotions) --}}
            @if($promotion->isSent())
            <a href="" 
               target="_blank" 
               @click="open = false"
               class="flex items-center w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Delivery Report
            </a>
            @endif
            
            {{-- Schedule (for draft promotions) --}}
            @if($promotion->status === 'draft')
            <button wire:click="schedulePromotion({{ $promotion->id }})" @click="open = false"
                    class="flex items-center w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Schedule
            </button>
            @endif
            
            {{-- Cancel Schedule (for scheduled promotions) --}}
            @if($promotion->status === 'scheduled')
            <button wire:click="cancelSchedule({{ $promotion->id }})" 
                    wire:confirm="Are you sure you want to cancel the scheduled delivery?"
                    @click="open = false"
                    class="flex items-center w-full text-left px-4 py-2 text-sm text-orange-600 hover:bg-orange-50 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Cancel Schedule
            </button>
            @endif
            
            {{-- Delete --}}
            <button wire:click="deletePromotion({{ $promotion->id }})" 
                    wire:confirm="Are you sure you want to delete this promotion? This action cannot be undone."
                    @click="open = false"
                    class="flex items-center w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Delete
            </button>
        </div>
    </div>
</div>



</div>
        </div>
        @endforeach

        {{-- Pagination --}}
        <div class="px-6 py-4 bg-white border-t border-gray-200">
            {{ $promotions->links() }}
        </div>
    @else
        {{-- No Promotions --}}
    {{-- Empty State --}}
<div class="px-6 py-16 text-center text-gray-500">
    <div class="max-w-md mx-auto">
        <svg class="mx-auto h-24 w-24 text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
        </svg>
        
        <h3 class="text-xl font-medium text-gray-900 mb-2">
            @if($search || $filterType || $filterPriority)
                No matching announcements found
            @else
                No announcements yet
            @endif
        </h3>
        
        <p class="text-sm text-gray-500 mb-8 leading-relaxed">
            @if($search || $filterType || $filterPriority)
                Try adjusting your search criteria or filters to find what you're looking for.
            @else
                Get started by creating your first announcement to communicate with your team. You can send updates, promotions, alerts, and more.
            @endif
        </p>

        <div class="space-y-3">
            @if($search || $filterType || $filterPriority)
                <button wire:click="clearFilters" 
                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue transition-colors duration-200">
                    <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Clear Filters
                </button>
            @else
                <button wire:click="openCreateModal" 
                        class="inline-flex bg-blue-800 items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gradient-to-r from-brand-blue to-brand-pink hover:from-brand-blue/90 hover:to-brand-pink/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue transition-all duration-200 shadow-lg hover:shadow-xl">
                    <svg class="-ml-1 mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Create Your First Announcement
                </button>
                
                <div class="mt-6 text-xs text-gray-400">
                    <p> Pro tip: You can schedule announcements for later delivery</p>
                </div>
            @endif
        </div>
        
        @if(!($search || $filterType || $filterPriority))
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4 text-left">
            <div class="bg-blue-50 rounded-lg p-4">
                <div class="flex items-center mb-2">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                        </svg>
                    </div>
                    <h4 class="text-sm font-medium text-blue-900">Announcements</h4>
                </div>
                <p class="text-xs text-blue-700">Share company news, updates, and important information with your team.</p>
            </div>
            
            <div class="bg-green-50 rounded-lg p-4">
                <div class="flex items-center mb-2">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </div>
                    <h4 class="text-sm font-medium text-green-900">Multi-Channel</h4>
                </div>
                <p class="text-xs text-green-700">Send via email and SMS to ensure your message reaches everyone.</p>
            </div>
            
            <div class="bg-purple-50 rounded-lg p-4">
                <div class="flex items-center mb-2">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h4 class="text-sm font-medium text-purple-900">Schedule</h4>
                </div>
                <p class="text-xs text-purple-700">Plan your communications and schedule them for optimal timing.</p>
            </div>
        </div>
        @endif
    </div>
</div>



    @endif
</div>



{{-- Loading Spinner Overlay --}}
<div wire:loading.flex class="fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-25 backdrop-blur-sm">
    <div class="bg-white rounded-xl p-8 shadow-2xl max-w-sm mx-4">
        <div class="flex flex-col items-center space-y-4">
            <div class="relative">
                <div class="w-16 h-16 border-4 border-gray-200 rounded-full"></div>
                <div class="absolute top-0 left-0 w-16 h-16 border-4 border-brand-blue border-t-transparent rounded-full animate-spin"></div>
            </div>
            
            <div class="text-center">
                <h3 class="text-lg font-medium text-gray-900 mb-1">Processing...</h3>
                <p class="text-sm text-gray-500">Please wait while we handle your request</p>
            </div>
            
            <div class="flex items-center space-x-1">
                <div class="w-2 h-2 bg-brand-blue rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                <div class="w-2 h-2 bg-brand-blue rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                <div class="w-2 h-2 bg-brand-blue rounded-full animate-bounce" style="animation-delay: 300ms"></div>
            </div>
        </div>
    </div>
</div>



{{-- Flash Messages --}}
@if (session()->has('message'))
<div x-data="{ show: true }" 
     x-show="show" 
     x-transition:enter="transform ease-out duration-300 transition"
     x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
     x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
     x-transition:leave="transition ease-in duration-100"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     x-init="setTimeout(() => show = false, 5000)"
     class="fixed top-4 right-4 z-50 max-w-sm w-full">
    <div class="bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg border border-green-600">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-3 flex-1">
                <p class="text-sm font-medium">{{ session('message') }}</p>
            </div>
            <div class="ml-4 flex-shrink-0">
                <button @click="show = false" class="inline-flex text-green-200 hover:text-white focus:outline-none">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
@endif

@if (session()->has('error'))
<div x-data="{ show: true }" 
     x-show="show" 
     x-transition:enter="transform ease-out duration-300 transition"
     x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
     x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
     x-transition:leave="transition ease-in duration-100"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     x-init="setTimeout(() => show = false, 7000)"
     class="fixed top-4 right-4 z-50 max-w-sm w-full">
    <div class="bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg border border-red-600">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-3 flex-1">
                <p class="text-sm font-medium">{{ session('error') }}</p>
            </div>
            <div class="ml-4 flex-shrink-0">
                <button @click="show = false" class="inline-flex text-red-200 hover:text-white focus:outline-none">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
@endif

@if (session()->has('warning'))
<div x-data="{ show: true }" 
     x-show="show" 
     x-transition:enter="transform ease-out duration-300 transition"
     x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
     x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
     x-transition:leave="transition ease-in duration-100"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     x-init="setTimeout(() => show = false, 6000)"
     class="fixed top-4 right-4 z-50 max-w-sm w-full">
    <div class="bg-yellow-500 text-white px-6 py-4 rounded-lg shadow-lg border border-yellow-600">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.383 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <div class="ml-3 flex-1">
                <p class="text-sm font-medium">{{ session('warning') }}</p>
            </div>
            <div class="ml-4 flex-shrink-0">
                <button @click="show = false" class="inline-flex text-yellow-200 hover:text-white focus:outline-none">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
@endif


{{-- Create/Edit Modal --}} 
@if($showCreateModal)
<div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm" wire:click="closeCreateModal"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-5xl sm:w-full">
            <form wire:submit.prevent="savePromotion">
                <div class="bg-white px-6 pt-6 pb-4 sm:p-8 sm:pb-4">
                    {{-- Modal Header --}}
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-xl font-bold text-brand-blue" id="modal-title">
                                {{ $editingPromotion ? '✏️ Edit Announcement' : ' Create New Announcement' }}
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $editingPromotion ? 'Update your existing announcement' : 'Share important information with your team' }}
                            </p>
                        </div>
                        <button type="button" wire:click="closeCreateModal" 
                                class="text-gray-400 hover:text-gray-600 p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        {{-- Left Column - Main Content --}}
                        <div class="lg:col-span-2 space-y-6">
                            {{-- Title --}}
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                     Title <span class="text-red-500">*</span>
                                </label>
                                <input wire:model.live="promotionForm.title" type="text" id="title"
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-brand-blue focus:border-brand-blue transition-colors sm:text-sm"
                                       placeholder="Enter a compelling title for your announcement"
                                       maxlength="255">
                                @error('promotionForm.title') 
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p> 
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">{{ strlen($promotionForm['title'] ?? '') }}/255 characters</p>
                            </div>

                            {{-- Content --}}
                            <div>
                                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                                     Content <span class="text-red-500">*</span>
                                </label>
                                <textarea wire:model.live="promotionForm.content" id="content" rows="8"
                                          class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-brand-blue focus:border-brand-blue transition-colors sm:text-sm resize-none"
                                          placeholder="Write your announcement content here. Be clear and engaging to ensure your message is well received."
                                          style="min-height: 200px;"></textarea>
                                @error('promotionForm.content') 
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p> 
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">
                                    {{ number_format(strlen($promotionForm['content'] ?? '')) }} characters
                                    @if(strlen($promotionForm['content'] ?? '') > 160)
                                    • SMS will be truncated to 160 characters
                                    @endif
                                </p>
                            </div>

                            {{-- Attachments --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3"> Attachments (Optional)</label>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-brand-blue transition-colors duration-200 bg-gray-50 hover:bg-blue-50">
                                    <div class="text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="mt-4">
                                            <label for="attachments" class="cursor-pointer">
                                                <span class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-brand-blue hover:bg-brand-blue/90 transition-colors">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                                    </svg>
                                                    Choose Files
                                                </span>
                                                <input wire:model="attachments" id="attachments" type="file" multiple
                                                       accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.xlsx,.xls" class="sr-only">
                                            </label>
                                        </div>
                                        <p class="mt-2 text-xs text-gray-500">
                                            or drag and drop files here<br>
                                            <span class="text-gray-400">PDF, DOC, DOCX, JPG, PNG, XLSX, XLS up to 10MB each</span>
                                        </p>
                                    </div>
                                </div>
                                
                                @error('attachments.*') 
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p> 
                                @enderror
                                
                                {{-- Show uploaded files --}}
                                @if($attachments)
                                <div class="mt-3 space-y-2">
                                    <h4 class="text-sm font-medium text-gray-700">Selected Files:</h4>
                                    @foreach($attachments as $index => $attachment)
                                    <div class="flex items-center justify-between p-3 bg-white border border-gray-200 rounded-lg">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $attachment->getClientOriginalName() }}</p>
                                                <p class="text-xs text-gray-500">{{ number_format($attachment->getSize() / 1024, 1) }} KB</p>
                                            </div>
                                        </div>
                                        <button type="button" class="text-red-400 hover:text-red-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- Right Column - Settings --}}
                        <div class="space-y-6 bg-gray-50 p-6 rounded-xl">
                            <h4 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Settings</h4>
                            
                            {{-- Type and Priority --}}
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                                    <select wire:model.live="promotionForm.type" id="type"
                                            class="block w-full px-3 py-2 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-brand-blue focus:border-brand-blue sm:text-sm">
                                        <option value="announcement"> Announcement</option>
                                        <option value="promotion"> Promotion</option>
                                        <option value="update"> Update</option>
                                        <option value="alert"> Alert</option>
                                        <option value="celebration"> Celebration</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">Priority</label>
                                    <select wire:model.live="promotionForm.priority" id="priority"
                                            class="block w-full px-3 py-2 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-brand-blue focus:border-brand-blue sm:text-sm">
                                        <option value="low"> Low</option>
                                        <option value="medium"> Medium</option>
                                        <option value="high"> High</option>
                                        <option value="urgent"> Urgent</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Recipients --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3"> Recipients</label>
                                <div class="space-y-3">
                                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                        <input wire:model.live="promotionForm.recipient_type" type="radio" value="selected_employees"
                                               class="form-radio text-brand-blue focus:ring-brand-blue">
                                        <span class="ml-3 text-sm text-gray-700"> Selected Employees</span>
                                    </label>
                                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                        <input wire:model.live="promotionForm.recipient_type" type="radio" value="departments"
                                               class="form-radio text-brand-blue focus:ring-brand-blue">
                                        <span class="ml-3 text-sm text-gray-700"> Departments</span>
                                    </label>
                                </div>

                                {{-- Employee Selection --}}
                                @if($promotionForm['recipient_type'] === 'selected_employees')
                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Employees</label>
                                    <div class="max-h-40 overflow-y-auto border border-gray-300 rounded-lg p-3 bg-white space-y-2">
                                        @forelse($employees as $employee)
                                        <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                                            <input wire:model.live="promotionForm.selected_employees" type="checkbox" value="{{ $employee->id }}"
                                                   class="form-checkbox text-brand-blue focus:ring-brand-blue">
                                            <div class="ml-3 flex-1">
                                                <p class="text-sm font-medium text-gray-900">{{ $employee->name }}</p>
                                                @if($employee->email)
                                                <p class="text-xs text-gray-500">{{ $employee->email }}</p>
                                                @endif
                                            </div>
                                        </label>
                                        @empty
                                        <p class="text-sm text-gray-500 text-center py-4">No employees found</p>
                                        @endforelse
                                    </div>
                                </div>
                                @endif

                                {{-- Department Selection --}}
                                @if($promotionForm['recipient_type'] === 'departments')
                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Departments</label>
                                    <div class="max-h-40 overflow-y-auto border border-gray-300 rounded-lg p-3 bg-white space-y-2">
                                        @forelse($departments as $department)
                                        <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                                            <input wire:model.live="promotionForm.selected_departments" type="checkbox" value="{{ $department->id }}"
                                                   class="form-checkbox text-brand-blue focus:ring-brand-blue">
                                            <div class="ml-3 flex-1">
                                                <p class="text-sm font-medium text-gray-900">{{ $department->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $department->employee_count }} employees</p>
                                            </div>
                                        </label>
                                        @empty
                                        <p class="text-sm text-gray-500 text-center py-4">No departments found</p>
                                        @endforelse
                                    </div>
                                </div>
                                @endif
                            </div>

                            {{-- Delivery Methods --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3"> Delivery Methods</label>
                                <div class="space-y-3">
                                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                        <input wire:model.live="promotionForm.delivery_methods" type="checkbox" value="email"
                                               class="form-checkbox text-brand-blue focus:ring-brand-blue">
                                        <span class="ml-3 text-sm text-gray-700"> Email</span>
                                    </label>
                                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                        <input wire:model.live="promotionForm.delivery_methods" type="checkbox" value="sms"
                                               class="form-checkbox text-brand-blue focus:ring-brand-blue">
                                        <span class="ml-3 text-sm text-gray-700"> SMS</span>
                                    </label>
                                </div>
                                @error('promotionForm.delivery_methods') 
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p> 
                                @enderror
                            </div>

                            {{-- Date Range --}}
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                                    <input wire:model.live="promotionForm.start_date" type="date" id="start_date"
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-brand-blue focus:border-brand-blue sm:text-sm">
                                    @error('promotionForm.start_date') 
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                                    @enderror
                                </div>
                                <div>
                                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2"> End Date</label>
                                    <input wire:model.live="promotionForm.end_date" type="date" id="end_date"
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-brand-blue focus:border-brand-blue sm:text-sm">
                                    @error('promotionForm.end_date') 
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                                    @enderror
                                </div>
                            </div>

                            {{-- Schedule Delivery --}}
                            <div class="border-t border-gray-200 pt-4">
                                <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                    <input wire:model.live="promotionForm.schedule_delivery" type="checkbox"
                                           class="form-checkbox text-brand-blue focus:ring-brand-blue">
                                    <span class="ml-3 text-sm font-medium text-gray-700"> Schedule for later delivery</span>
                                </label>
                                
                                @if($promotionForm['schedule_delivery'])
                                <div class="mt-3">
                                    <label for="scheduled_at" class="block text-sm font-medium text-gray-700 mb-2">Schedule Date & Time</label>
                                    <input wire:model.live="promotionForm.scheduled_at" type="datetime-local" id="scheduled_at"
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-brand-blue focus:border-brand-blue sm:text-sm">
                                    @error('promotionForm.scheduled_at') 
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                                    @enderror
                                </div>
                                @endif
                            </div>

                            {{-- Recipient Stats --}}
                            @if($recipientStats['total'] > 0)
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-blue-900 mb-2"> Recipient Summary</h4>
                                <div class="text-sm text-blue-700 space-y-1">
                                    <div class="flex justify-between">
                                        <span>Total Recipients:</span>
                                        <span class="font-semibold">{{ number_format($recipientStats['total']) }}</span>
                                    </div>
                                    @if(isset($recipientStats['by_method']['email']))
                                    <div class="flex justify-between">
                                        <span> Email Recipients:</span>
                                        <span class="font-semibold">{{ number_format($recipientStats['by_method']['email']) }}</span>
                                    </div>
                                    @endif
                                    @if(isset($recipientStats['by_method']['sms']))
                                    <div class="flex justify-between">
                                        <span> SMS Recipients:</span>
                                        <span class="font-semibold">{{ number_format($recipientStats['by_method']['sms']) }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                {{-- Modal Footer --}}
                <div class="bg-gray-50 px-6 py-4 sm:px-8 sm:flex sm:flex-row-reverse border-t border-gray-200">
                    <button type="submit"
                            wire:loading.attr="disabled"
                            class="w-full inline-flex bg-blue-800 justify-center items-center rounded-lg border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-brand-blue to-brand-pink text-base font-medium text-white hover:from-brand-blue/90 hover:to-brand-pink/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50 transition-all duration-200">
                        <span wire:loading.remove>
                            {{ $editingPromotion ? ' Update' : ' Create' }} Announcement
                        </span>
                        <span wire:loading class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                        </span>
                    </button>
                    <button type="button" wire:click="closeCreateModal"
                            class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-200">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif



{{-- Send Modal --}}
@if($showSendModal && $sendingPromotion)
<div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-6 pt-6 pb-4 sm:p-8 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-full bg-gradient-to-r from-brand-blue to-brand-pink sm:mx-0 sm:h-12 sm:w-12">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-1">
                        <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">
                             Send Announcement
                        </h3>
                        <div class="mt-4">
                            <p class="text-sm text-gray-600 mb-4">
                                Are you ready to send "<strong class="text-gray-900">{{ $sendingPromotion->title }}</strong>" to 
                                <strong class="text-brand-blue">{{ number_format($sendingPromotion->total_recipients) }}</strong> recipients?
                            </p>
                            
                            {{-- Delivery Summary --}}
                            <div class="bg-gradient-to-r from-blue-50 to-pink-50 rounded-lg p-4 border border-blue-200">
                                <h4 class="text-sm font-semibold text-gray-900 mb-3"> Delivery Summary</h4>
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="text-gray-600">Type:</span>
                                        <div class="font-medium text-gray-900 flex items-center mt-1">
                                            @switch($sendingPromotion->type)
                                                @case('promotion')  @break
                                                @case('announcement')  @break
                                                @case('update')  @break
                                                @case('alert')  @break
                                                @case('celebration')  @break
                                            @endswitch
                                            {{ ucfirst($sendingPromotion->type) }}
                                        </div>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Priority:</span>
                                        <div class="font-medium text-gray-900 flex items-center mt-1">
                                            @switch($sendingPromotion->priority)
                                                @case('urgent')  @break
                                                @case('high') @break
                                                @case('medium')  @break
                                                @case('low')  @break
                                            @endswitch
                                            {{ ucfirst($sendingPromotion->priority) }}
                                        </div>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Methods:</span>
                                        <div class="font-medium text-gray-900 mt-1">
                                            {{ $sendingPromotion->delivery_methods_text }}
                                        </div>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Recipients:</span>
                                        <div class="font-medium text-gray-900 mt-1">
                                            {{ $sendingPromotion->recipient_type_text }}
                                        </div>
                                    </div>
                                </div>

                                {{-- Content Preview --}}
                                <div class="mt-4 pt-3 border-t border-blue-200">
                                    <span class="text-gray-600 text-sm">Content Preview:</span>
                                    <div class="mt-1 p-2 bg-white rounded border text-sm text-gray-700 max-h-20 overflow-y-auto">
                                        {{ Str::limit($sendingPromotion->content, 150) }}
                                    </div>
                                </div>

                                {{-- Attachments --}}
                                @if($sendingPromotion->hasAttachments())
                                <div class="mt-3 pt-3 border-t border-blue-200">
                                    <span class="text-gray-600 text-sm">Attachments:</span>
                                    <div class="mt-1 text-sm text-gray-700">
                                         {{ $sendingPromotion->getAttachmentCount() }} file(s) will be included
                                    </div>
                                </div>
                                @endif
                            </div>
                            
                            {{-- Warning --}}
                            <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.383 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-yellow-800">Important Notice</p>
                                        <p class="text-xs text-yellow-700 mt-1">
                                             This action cannot be undone. The announcement will be sent immediately to all recipients via the selected delivery methods.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Modal Footer --}}
            <div class="bg-gray-50 px-6 py-4 sm:px-8 sm:flex sm:flex-row-reverse border-t border-gray-200">
                <button wire:click="sendPromotionNow" type="button"
                        wire:loading.attr="disabled"
                        class="w-full inline-flex justify-center items-center rounded-lg border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-base font-medium text-white hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50 transition-all duration-200">
                    <span wire:loading.remove class="flex items-center">
                        <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Send Now
                    </span>
                    <span wire:loading class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Sending...
                    </span>
                </button>
                <button wire:click="closeSendModal" type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-200">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
@endif




{{-- Preview Modal --}}
@if($showPreviewModal && $previewData)
<div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm" wire:click="closePreviewModal"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <div class="bg-white px-6 pt-6 pb-4 sm:p-8 sm:pb-4">
                {{-- Modal Header --}}
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-brand-blue">
                             Announcement Preview
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">Preview how your announcement will appear to recipients</p>
                    </div>
                    <button type="button" wire:click="closePreviewModal" 
                            class="text-gray-400 hover:text-gray-600 p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                {{-- Preview Content --}}
                <div class="border border-gray-200 rounded-xl p-8 bg-gradient-to-br from-gray-50 via-white to-blue-50">
                    {{-- Email Preview --}}
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        {{-- Email Header --}}
                        <div class="bg-gradient-to-r from-brand-blue to-brand-pink px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-white font-semibold">{{ config('app.name') }}</h4>
                                        <p class="text-white text-opacity-80 text-sm">Employee Communications</p>
                                    </div>
                                </div>
                                <div class="text-white text-opacity-80 text-sm">
                                    {{ now()->format('M d, Y') }}
                                </div>
                            </div>
                        </div>

                        {{-- Email Body --}}
                        <div class="px-6 py-6">
                            {{-- Title and Badges --}}
                            <div class="mb-4">
                                <h2 class="text-2xl font-bold text-gray-900 mb-3">{{ $previewData->title }}</h2>
                                <div class="flex items-center space-x-2 flex-wrap">
                                    {{-- Type Badge --}}
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                        @if($previewData->type === 'promotion') bg-green-100 text-green-800
                                        @elseif($previewData->type === 'announcement') bg-blue-100 text-blue-800
                                        @elseif($previewData->type === 'update') bg-purple-100 text-purple-800
                                        @elseif($previewData->type === 'alert') bg-red-100 text-red-800
                                        @elseif($previewData->type === 'celebration') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        @switch($previewData->type)
                                            @case('promotion') @break
                                            @case('announcement')  @break
                                            @case('update')  @break
                                            @case('alert')  @break
                                            @case('celebration')  @break
                                        @endswitch
                                        {{ ucfirst($previewData->priority) }} Priority
                                    </span>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="prose max-w-none mb-6">
                                <div class="text-gray-700 whitespace-pre-line leading-relaxed text-base">{{ $previewData->content }}</div>
                            </div>

                            {{-- Attachments --}}
                            @if($previewData->attachments)
                            <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                                <h4 class="text-sm font-semibold text-blue-900 mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                    </svg>
                                    Attachments
                                </h4>
                                <div class="space-y-2">
                                    @foreach($previewData->attachments as $attachment)
                                    <div class="flex items-center justify-between p-2 bg-white rounded border">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-blue-100 rounded flex items-center justify-center">
                                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $attachment['name'] }}</p>
                                                <p class="text-xs text-gray-500">{{ number_format($attachment['size'] / 1024, 1) }} KB</p>
                                            </div>
                                        </div>
                                        <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">Download</button>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            {{-- Footer --}}
                            <div class="pt-4 border-t border-gray-200">
                                <p class="text-sm text-gray-600">
                                    Best regards,<br>
                                    <strong>{{ config('app.name') }} Team</strong>
                                </p>
                                <p class="text-xs text-gray-400 mt-2">
                                    This message was sent via {{ config('app.name') }} Employee Communications System
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Meta Information --}}
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <h4 class="text-sm font-semibold text-gray-900 mb-3"> Delivery Information</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Recipients:</span>
                                    <span class="font-medium">{{ number_format($previewData->total_recipients ?? 0) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Methods:</span>
                                    <span class="font-medium">{{ implode(', ', $previewData->delivery_methods ?? []) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Created by:</span>
                                    <span class="font-medium">{{ $previewData->createdBy->name ?? 'System' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <h4 class="text-sm font-semibold text-gray-900 mb-3"> Schedule Information</h4>
                            <div class="space-y-2 text-sm">
                                @if($previewData->start_date)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Start Date:</span>
                                    <span class="font-medium">{{ $previewData->start_date->format('M d, Y') }}</span>
                                </div>
                                @endif
                                @if($previewData->end_date)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">End Date:</span>
                                    <span class="font-medium">{{ $previewData->end_date->format('M d, Y') }}</span>
                                </div>
                                @endif
                                @if($previewData->scheduled_at)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Scheduled:</span>
                                    <span class="font-medium text-yellow-600">{{ $previewData->scheduled_at->format('M d, Y H:i') }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- SMS Preview (if SMS is enabled) --}}
                    @if(in_array('sms', $previewData->delivery_methods ?? []))
                    <div class="mt-6">
                        <h4 class="text-sm font-semibold text-gray-900 mb-3">📱 SMS Preview</h4>
                        <div class="bg-gray-900 rounded-lg p-4 max-w-sm">
                            <div class="bg-blue-500 rounded-lg p-3 text-white text-sm">
                                @php
                                    $smsContent = $previewData->title . ': ' . strip_tags($previewData->content);
                                    $smsContent = Str::limit($smsContent, 140) . ' - ' . config('app.name');
                                @endphp
                                {{ $smsContent }}
                            </div>
                            <p class="text-xs text-gray-400 mt-2">SMS preview (160 character limit)</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            
            {{-- Modal Footer --}}
            <div class="bg-gray-50 px-6 py-4 sm:px-8 sm:flex sm:flex-row-reverse border-t border-gray-200">
                @if($previewData->canBeSent() && !$previewData->id)
                <button wire:click="$set('showPreviewModal', false); openSendModal({{ $previewData->id ?? 'temp' }})" type="button"
                        class="w-full inline-flex justify-center items-center rounded-lg border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-base font-medium text-white hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-200">
                    <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    Send Now
                </button>
                @endif
                
                @if($previewData->canBeEdited())
                <button wire:click="$set('showPreviewModal', false); editPromotion({{ $previewData->id }})" type="button"
                        class="mt-3 w-full inline-flex justify-center items-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-200">
                    <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                    Edit
                </button>
                @endif
                
                <button wire:click="closePreviewModal" type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-200">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
@endif

</div>


