<div>



<div class="min-h-screen bg-gray-50">
    {{-- Header Section --}}
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-brand-blue to-brand-pink hover:from-brand-blue/90 hover:to-brand-pink/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue transition-all duration-200">
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

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Stats Overview --}}
        <div class="mb-8">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-6">
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

        {{-- Main Content Card --}}
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
            {{-- Tab Navigation --}}
            <div class="border-b border-gray-200 bg-gray-50">
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

            {{-- Filters --}}
            <div class="bg-white px-6 py-4 border-b border-gray-200">
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
                            <input wire:model.live.live="search" type="text" id="search" 
                                   class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-2 focus:ring-brand-blue focus:border-transparent transition duration-150 ease-in-out sm:text-sm"
                                   placeholder="Search announcements...">
                        </div>
                    </div>

                    {{-- Type Filter --}}
                    <div>
                        <label for="filterType" class="sr-only">Filter by type</label>
                        <select wire:model.live.live="filterType" id="filterType" 
                                class="block w-full px-3 py-2.5 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-brand-blue focus:border-transparent sm:text-sm">
                            <option value="">All Types</option>
                            <option value="promotion">Promotion</option>
                            <option value="announcement">Announcement</option>
                            <option value="update">Update</option>
                            <option value="alert">Alert</option>
                            <option value="celebration">Celebration</option>
                        </select>
                    </div>

                    {{-- Priority Filter --}}
                    <div>
                        <label for="filterPriority" class="sr-only">Filter by priority</label>
                        <select wire:model.live.live="filterPriority" id="filterPriority"
                                class="block w-full px-3 py-2.5 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-brand-blue focus:border-transparent sm:text-sm">
                            <option value="">All Priorities</option>
                            <option value="urgent">Urgent</option>
                            <option value="high">High</option>
                            <option value="medium">Medium</option>
                            <option value="low">Low</option>
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
            <div class="bg-gradient-to-r from-blue-50 to-pink-50 px-6 py-4 border-b border-blue-200">
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
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                            <svg class="-ml-0.5 mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Activate
                        </button>
                        <button wire:click="bulkDeactivate" 
                                class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue transition-colors duration-200">
                            <svg class="-ml-0.5 mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14L5 9m0 0l5-5m-5 5h12"></path>
                            </svg>
                            Deactivate
                        </button>
                        <button wire:click="bulkDelete" 
                                onclick="return confirm('Delete selected items?')"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                            <svg class="-ml-0.5 mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete
                        </button>
                    </div>
                </div>
            </div>
            @endif

            {{-- Promotions List --}}
            <div class="divide-y divide-gray-200">
                @if($promotions && count($promotions) > 0)
                    {{-- Select All Header --}}
                    <div class="px-6 py-4 bg-gray-50">
                        <label class="inline-flex items-center">
                            <input wire:model.live.live="selectAll" type="checkbox" 
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
                                    <div class="flex items-center space-x-3 mb-3">
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
                                            @if($promotion->status === 'sent') Sent
                                            @elseif($promotion->status === 'scheduled') Scheduled
                                            @elseif($promotion->status === 'draft') Draft
                                            @elseif($promotion->status === 'cancelled') Cancelled
                                            @else {{ ucfirst($promotion->status) }}
                                            @endif
                                        </span>

                                        {{-- Active/Inactive Badge --}}
                                        @if(!$promotion->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Inactive
                                        </span>
                                        @endif
                                    </div>

                                    {{-- Description --}}
                                    <p class="text-sm text-gray-500 mb-2">{{ Str::limit(strip_tags($promotion->content), 120) }}</p>
                                    
                                    {{-- Meta Info --}}
                                    <div class="flex items-center space-x-4 text-xs text-gray-400">
                                        <span>Created by {{ $promotion->createdBy->name ?? 'System' }}</span>
                                        <span>•</span>
                                        <span>{{ $promotion->created_at->format('M d, Y') }}</span>
                                        @if($promotion->sent_at)
                                        <span>•</span>
                                        <span>Sent {{ $promotion->sent_at->format('M d, Y H:i') }}</span>
                                        @endif
                                        @if($promotion->scheduled_at && $promotion->status === 'scheduled')
                                        <span>•</span>
                                        <span>Scheduled for {{ $promotion->scheduled_at->format('M d, Y H:i') }}</span>
                                        @endif
                                        <span>•</span>
                                        <span>{{ $promotion->total_recipients ?? 0 }} recipients</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="flex items-center space-x-2">
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
                                @if($promotion->status === 'draft' || $promotion->status === 'scheduled')
                                <button wire:click="editPromotion({{ $promotion->id }})"
                                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue transition-colors duration-200">
                                    <svg class="-ml-0.5 mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                    Edit
                                </button>
                                @endif

                                {{-- Send Button --}}
                                @if($promotion->status === 'draft')
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
                                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue transition-colors duration-200">
                                    @if($promotion->is_active)
                                    <svg class="-ml-0.5 mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9V6a2 2 0 114 0v3a2 2 0 01-2 2H8a2 2 0 01-2-2V7a2 2 0 012-2h2z"></path>
                                    </svg>
                                    Deactivate
                                    @else
                                    <svg class="-ml-0.5 mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                    </svg>
                                    Activate
                                    @endif
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
                                        <button wire:click="duplicatePromotion({{ $promotion->id }})" @click="open = false"
                                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                            </svg>
                                            Duplicate
                                        </button>
                                        <button wire:click="deletePromotion({{ $promotion->id }})" @click="open = false"
                                                onclick="return confirm('Are you sure you want to delete this promotion?')"
                                                class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                            <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    <div class="px-6 py-12 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No announcements found</h3>
                        <p class="text-sm text-gray-500 mb-6">Get started by creating your first announcement to communicate with your team.</p>
                        <button wire:click="openCreateModal" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-brand-blue to-brand-pink hover:from-brand-blue/90 hover:to-brand-pink/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Create Your First Announcement
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Create/Edit Modal --}}
    @if($showCreateModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeCreateModal"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                <form wire:submit.prevent="savePromotion">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="w-full">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-lg leading-6 font-medium text-brand-blue" id="modal-title">
                                        {{ $editingPromotion ? 'Edit Announcement' : 'Create New Announcement' }}
                                    </h3>
                                    <button type="button" wire:click="closeCreateModal" class="text-gray-400 hover:text-gray-600">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>

                                <div class="space-y-6">
                                    {{-- Title --}}
                                    <div>
                                        <label for="title" class="block text-sm font-medium text-gray-700">
                                            Title <span class="text-red-500">*</span>
                                        </label>
                                        <input wire:model.live="promotionForm.title" type="text" id="title"
                                               class="mt-1 focus:ring-brand-blue focus:border-brand-blue block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                               placeholder="Enter announcement title">
                                        @error('promotionForm.title') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>

                                    {{-- Type and Priority --}}
                                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                        <div>
                                            <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                                            <select wire:model.live="promotionForm.type" id="type"
                                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-brand-blue focus:border-brand-blue sm:text-sm">
                                                <option value="announcement">Announcement</option>
                                                <option value="promotion">Promotion</option>
                                                <option value="update">Update</option>
                                                <option value="alert">Alert</option>
                                                <option value="celebration">Celebration</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
                                            <select wire:model.live="promotionForm.priority" id="priority"
                                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-brand-blue focus:border-brand-blue sm:text-sm">
                                                <option value="low">Low</option>
                                                <option value="medium">Medium</option>
                                                <option value="high">High</option>
                                                <option value="urgent">Urgent</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Content --}}
                                    <div>
                                        <label for="content" class="block text-sm font-medium text-gray-700">
                                            Content <span class="text-red-500">*</span>
                                        </label>
                                        <textarea wire:model.live="promotionForm.content" id="content" rows="6"
                                                  class="mt-1 shadow-sm focus:ring-brand-blue focus:border-brand-blue block w-full sm:text-sm border-gray-300 rounded-md"
                                                  placeholder="Enter your announcement content..."></textarea>
                                        @error('promotionForm.content') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>

                                    {{-- Recipients --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Recipients</label>
                                        <div class="space-y-2">
                                            <label class="inline-flex items-center">
                                                <input wire:model.live="promotionForm.recipient_type" type="radio" value="all_employees"
                                                       class="form-radio text-brand-blue focus:ring-brand-blue">
                                                <span class="ml-2 text-sm text-gray-700">All Employees</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input wire:model.live="promotionForm.recipient_type" type="radio" value="selected_employees"
                                                       class="form-radio text-brand-blue focus:ring-brand-blue">
                                                <span class="ml-2 text-sm text-gray-700">Selected Employees</span>
                                            </label>
                                           
                                        </div>

                                        {{-- Employee Selection --}}
                                        @if($promotionForm['recipient_type'] === 'selected_employees')
                                        <div class="mt-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Employees</label>
                                            <div class="max-h-40 overflow-y-auto border border-gray-300 rounded-md p-2">
                                                @foreach($employees as $employee)
                                                <label class="flex items-center py-1">
                                                    <input wire:model.live="promotionForm.selected_employees" type="checkbox" value="{{ $employee->id }}"
                                                           class="form-checkbox text-brand-blue focus:ring-brand-blue">
                                                    <span class="ml-2 text-sm text-gray-700">{{ $employee->name }}</span>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif

                                        {{-- Department Selection --}}
                                        @if($promotionForm['recipient_type'] === 'departments')
                                        <div class="mt-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Departments</label>
                                            <div class="max-h-40 overflow-y-auto border border-gray-300 rounded-md p-2">
                                                @foreach($departments as $department)
                                                <label class="flex items-center py-1">
                                                    <input wire:model.live="promotionForm.selected_departments" type="checkbox" value="{{ $department->id }}"
                                                           class="form-checkbox text-brand-blue focus:ring-brand-blue">
                                                    <span class="ml-2 text-sm text-gray-700">{{ $department->name }}</span>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif
                                    </div>

                                    {{-- Delivery Methods --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Delivery Methods</label>
                                        <div class="space-y-2">
                                            <label class="inline-flex items-center">
                                                <input wire:model.live="promotionForm.delivery_methods" type="checkbox" value="email"
                                                       class="form-checkbox text-brand-blue focus:ring-brand-blue">
                                                <span class="ml-2 text-sm text-gray-700">Email</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input wire:model.live="promotionForm.delivery_methods" type="checkbox" value="sms"
                                                       class="form-checkbox text-brand-blue focus:ring-brand-blue">
                                                <span class="ml-2 text-sm text-gray-700">SMS</span>
                                            </label>
                                           
                                        </div>
                                    </div>

                                    {{-- Attachments --}}
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Attachments</label>
                                        <input wire:model.live="attachments" type="file" multiple
                                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.xlsx,.xls"
                                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-brand-blue file:text-white hover:file:bg-brand-blue/90">
                                        <p class="mt-1 text-xs text-gray-500">Max 10MB per file. Supported formats: PDF, DOC, DOCX, JPG, PNG, XLSX, XLS</p>
                                        @error('attachments.*') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>

                                    {{-- Date Range --}}
                                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                        <div>
                                            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                            <input wire:model.live="promotionForm.start_date" type="date" id="start_date"
                                                   class="mt-1 focus:ring-brand-blue focus:border-brand-blue block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                        <div>
                                            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                                            <input wire:model.live="promotionForm.end_date" type="date" id="end_date"
                                                   class="mt-1 focus:ring-brand-blue focus:border-brand-blue block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                    </div>

                                    {{-- Schedule Delivery --}}
                                    <div>
                                        <label class="inline-flex items-center">
                                            <input wire:model.live="promotionForm.schedule_delivery" type="checkbox"
                                                   class="form-checkbox text-brand-blue focus:ring-brand-blue">
                                            <span class="ml-2 text-sm text-gray-700">Schedule for later delivery</span>
                                        </label>
                                        
                                        @if($promotionForm['schedule_delivery'])
                                        <div class="mt-3">
                                            <label for="scheduled_at" class="block text-sm font-medium text-gray-700">Schedule Date & Time</label>
                                            <input wire:model.live="promotionForm.scheduled_at" type="datetime-local" id="scheduled_at"
                                                   class="mt-1 focus:ring-brand-blue focus:border-brand-blue block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            @error('promotionForm.scheduled_at') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                        </div>
                                        @endif
                                    </div>

                                    {{-- Recipient Stats --}}
                                    @if($recipientStats['total'] > 0)
                                    <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                                        <h4 class="text-sm font-medium text-blue-900 mb-2">Recipient Summary</h4>
                                        <div class="text-sm text-blue-700">
                                            <p>Total Recipients: <span class="font-semibold">{{ $recipientStats['total'] }}</span></p>
                                            @if(isset($recipientStats['by_method']['email']))
                                            <p>Email Recipients: <span class="font-semibold">{{ $recipientStats['by_method']['email'] }}</span></p>
                                            @endif
                                            @if(isset($recipientStats['by_method']['sms']))
                                            <p>SMS Recipients: <span class="font-semibold">{{ $recipientStats['by_method']['sms'] }}</span></p>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gradient-to-r from-brand-blue to-brand-pink text-base font-medium text-white hover:from-brand-blue/90 hover:to-brand-pink/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue sm:ml-3 sm:w-auto sm:text-sm">
                            {{ $editingPromotion ? 'Update' : 'Create' }} Announcement
                        </button>
                        <button type="button" wire:click="closeCreateModal"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
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
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-brand-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Send Announcement
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Are you sure you want to send "{{ $sendingPromotion->title }}" to {{ $sendingPromotion->total_recipients }} recipients?
                                </p>
                                <div class="mt-4 bg-gray-50 rounded-md p-3">
                                    <h4 class="text-sm font-medium text-gray-900">Delivery Methods:</h4>
                                    <ul class="mt-1 text-sm text-gray-600">
                                        @foreach($sendingPromotion->delivery_methods as $method)
                                        <li>• {{ ucfirst($method) }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="sendPromotionNow" type="button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-brand-blue text-base font-medium text-white hover:bg-brand-blue/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue sm:ml-3 sm:w-auto sm:text-sm">
                        Send Now
                    </button>
                    <button wire:click="closeSendModal" type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
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
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closePreviewModal"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg leading-6 font-medium text-brand-blue">
                            Announcement Preview
                        </h3>
                        <button type="button" wire:click="closePreviewModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    {{-- Preview Content --}}
                    <div class="border border-gray-200 rounded-lg p-6 bg-gray-50">
                        <div class="mb-4">
                            <h2 class="text-xl font-bold text-gray-900">{{ $previewData->title }}</h2>
                            <div class="flex items-center space-x-2 mt-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($previewData->type === 'promotion') bg-green-100 text-green-800
                                    @elseif($previewData->type === 'announcement') bg-blue-100 text-blue-800
                                    @elseif($previewData->type === 'update') bg-purple-100 text-purple-800
                                    @elseif($previewData->type === 'alert') bg-red-100 text-red-800
                                    @elseif($previewData->type === 'celebration') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($previewData->type) }}
                                </span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($previewData->priority === 'urgent') bg-red-100 text-red-800
                                    @elseif($previewData->priority === 'high') bg-orange-100 text-orange-800
                                    @elseif($previewData->priority === 'medium') bg-yellow-100 text-yellow-800
                                    @elseif($previewData->priority === 'low') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($previewData->priority) }} Priority
                                </span>
                            </div>
                        </div>

                        <div class="prose max-w-none">
                            <p class="text-gray-700 whitespace-pre-line">{{ $previewData->content }}</p>
                        </div>

                        @if($previewData->attachments)
                        <div class="mt-4">
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Attachments:</h4>
                            <ul class="text-sm text-gray-600">
                                @foreach($previewData->attachments as $attachment)
                                <li>• {{ $attachment['name'] }} ({{ number_format($attachment['size'] / 1024, 1) }} KB)</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <div class="grid grid-cols-2 gap-4 text-sm text-gray-500">
                                <div>
                                    <span class="font-medium">Recipients:</span> {{ $previewData->total_recipients ?? 0 }}
                                </div>
                                <div>
                                    <span class="font-medium">Methods:</span> {{ implode(', ', $previewData->delivery_methods ?? []) }}
                                </div>
                                @if($previewData->start_date)
                                <div>
                                    <span class="font-medium">Start:</span> {{ $previewData->start_date->format('M d, Y') }}
                                </div>
                                @endif
                                @if($previewData->end_date)
                                <div>
                                    <span class="font-medium">End:</span> {{ $previewData->end_date->format('M d, Y') }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="closePreviewModal" type="button"
                            class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue sm:ml-3 sm:w-auto sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

{{-- Flash Messages --}}
@if (session()->has('message'))
<div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
     class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
    {{ session('message') }}
</div>
@endif

@if (session()->has('error'))
<div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
     class="fixed top-4 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
    {{ session('error') }}
</div>
@endif

<style>
.brand-blue { color: #022E64; }
.brand-pink { color: #DE0D74; }
.bg-brand-blue { background-color: #022E64; }
.bg-brand-pink { background-color: #DE0D74; }
.border-brand-blue { border-color: #022E64; }
.border-brand-pink { border-color: #DE0D74; }
.text-brand-blue { color: #022E64; }
.text-brand-pink { color: #DE0D74; }
.focus\:ring-brand-blue:focus { --tw-ring-color: #022E64; }
.focus\:ring-brand-pink:focus { --tw-ring-color: #DE0D74; }
.focus\:border-brand-blue:focus { border-color: #022E64; }
.focus\:border-brand-pink:focus { border-color: #DE0D74; }
</style>

<script>
// AlpineJS for dropdown functionality
document.addEventListener('alpine:init', () => {
    Alpine.data('dropdown', () => ({
        open: false,
        toggle() {
            this.open = !this.open
        },
        close() {
            this.open = false
        }
    }))
})
</script>




</div>



