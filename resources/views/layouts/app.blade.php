
{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('logoV1.png') }}" type="image/png">

    <title>{{ config('app.name', 'Memoirex System') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    
    <!-- Alpine.js -->
    <style>
        .brand-blue { color: #022E64; }
        .brand-pink { color: #DE0D74; }
        .bg-brand-blue { background-color: #022E64; }
        .bg-brand-pink { background-color: #DE0D74; }
        .border-brand-blue { border-color: #022E64; }
        .border-brand-pink { border-color: #DE0D74; }
        .text-brand-blue { color: #022E64; }
        .text-brand-pink { color: #DE0D74; }
        .hover\:bg-brand-blue:hover { background-color: #022E64; }
        .hover\:bg-brand-pink:hover { background-color: #DE0D74; }
        .focus\:ring-brand-blue:focus { --tw-ring-color: #022E64; }
        .focus\:ring-brand-pink:focus { --tw-ring-color: #DE0D74; }
        .from-brand-blue { --tw-gradient-from: #022E64; }
        .to-brand-pink { --tw-gradient-to: #DE0D74; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">
        <!-- Desktop Sidebar -->
        <div class="hidden md:flex md:w-64 md:flex-col">
            <div class="flex flex-col flex-grow pt-5 overflow-y-auto bg-white border-r border-gray-200 shadow-lg">
                <!-- Logo -->
                <div class="flex items-center flex-shrink-0 px-6 mb-2">
                    
                    <!-- <div class="inline-flex items-center justify-center bg-opacity-20 backdrop-filter backdrop-blur-lg mb-4">
                    </div> -->

                    <img class="h-24 justify-center items-center ml-4" src="{{ asset('/logoV1.png') }}" alt="Memoirex Logo" /> 

                    <!-- <div class="ml-3">
                        <h1 class="text-xl font-bold text-brand-blue mb-1">Memoirex</h1>
                        <p class="text-xs text-brand-pink -mt-1 font-medium">Management System</p>
                    </div> -->
                </div>

                <!-- Navigation -->
                <div class="flex-grow flex flex-col">
                    <nav class="flex-1 px-4 space-y-2">
                        <!-- Main Section -->
                        <div class="space-y-1">
                            <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Main</p>
                            
                            <!-- Dashboard -->
                            <a href="{{ route('dashboard') }}" 
                               class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-brand-blue border-r-4 border-brand-blue shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-blue hover:shadow-sm' }}">
                                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-brand-blue' : 'text-gray-400 group-hover:text-brand-blue' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h2a2 2 0 012 2v2H8V5z"></path>
                                </svg>
                                Dashboard
                                @if(request()->routeIs('dashboard'))
                                    <div class="ml-auto w-2 h-2 bg-brand-pink rounded-full"></div>
                                @endif
                            </a>
                        </div>

                        <!-- Employee Management Section -->
                        <div class="space-y-1 pt-4">
                            <p class="px-3 text-xs font-semibold text-brand-pink uppercase tracking-wider">Employee Management</p>
                            
                            <!-- Employee Management -->
                            <a href="{{ route('employment.index') }}" 
                               class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('employment.*') ? 'bg-blue-50 text-brand-blue border-r-4 border-brand-blue shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-blue hover:shadow-sm' }}">
                                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('employment.*') ? 'text-brand-blue' : 'text-gray-400 group-hover:text-brand-blue' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                                Employees
                                @if(request()->routeIs('employment.*'))
                                    <div class="ml-auto w-2 h-2 bg-brand-pink rounded-full"></div>
                                @endif
                            </a>
                        </div>

                        <!-- Contract Management Section -->
                        <div class="space-y-1 pt-4">
                            <p class="px-3 text-xs font-semibold text-brand-pink uppercase tracking-wider">Contract Management</p>
                            
                            <!-- Contract Management -->
                            <a href="{{ route('contract.index') }}" 
                               class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('contract.*') ? 'bg-blue-50 text-brand-blue border-r-4 border-brand-blue shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-blue hover:shadow-sm' }}">
                                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('contract.*') ? 'text-brand-blue' : 'text-gray-400 group-hover:text-brand-blue' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Contracts
                                @if(request()->routeIs('contract.*'))
                                    <div class="ml-auto w-2 h-2 bg-brand-pink rounded-full"></div>
                                @endif
                            </a>

                          

                            <!-- Contract Tracking -->
                            <a href="{{ route('tracking.index') }}" 
                               class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('tracking.*') ? 'bg-blue-50 text-brand-blue border-r-4 border-brand-blue shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-blue hover:shadow-sm' }}">
                                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('tracking.*') ? 'text-brand-blue' : 'text-gray-400 group-hover:text-brand-blue' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                Contract Tracking
                                @if(request()->routeIs('tracking.*'))
                                    <div class="ml-auto w-2 h-2 bg-brand-pink rounded-full"></div>
                                @endif
                            </a>



                            <a href="{{ route('reminders.dashboard') }}" 
                               class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('reminders*') ? 'bg-blue-50 text-brand-blue border-r-4 border-brand-blue shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-blue hover:shadow-sm' }}">
                                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('reminders.*') ? 'text-brand-blue' : 'text-gray-400 group-hover:text-brand-blue' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Reminders Dashboard
                                @if(request()->routeIs('reminders.*'))
                                    <div class="ml-auto w-2 h-2 bg-brand-pink rounded-full"></div>
                                @endif
                            </a>

                            
                        </div>

                        <!-- Notifications & Alerts Section -->
                        <div class="space-y-1 pt-4">
                            <p class="px-3 text-xs font-semibold text-brand-pink uppercase tracking-wider">Notifications & Alerts</p>
                            
                            <!-- Notifications -->
                            <!-- <a href="{{ route('notification.index') }}" 
                               class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('notification.*') ? 'bg-blue-50 text-brand-blue border-r-4 border-brand-blue shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-blue hover:shadow-sm' }}">
                                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('notification.*') ? 'text-brand-blue' : 'text-gray-400 group-hover:text-brand-blue' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM15 17H9a4 4 0 01-4-4V8a4 4 0 014-4h6a4 4 0 014 4v9z"></path>
                                </svg>
                                Notifications
                                <div class="ml-auto flex items-center">
                                    <span class="bg-brand-pink bg-opacity-10 text-brand-pink text-xs px-2 py-1 rounded-full font-medium">3</span>
                                    @if(request()->routeIs('notification.*'))
                                        <div class="ml-2 w-2 h-2 bg-brand-pink rounded-full"></div>
                                    @endif
                                </div>
                            </a> -->

                            <a href="{{ route('promotion.index') }}" 
                               class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('promotion.*') ? 'bg-blue-50 text-brand-blue border-r-4 border-brand-blue shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-blue hover:shadow-sm' }}">
                                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('promotion.*') ? 'text-brand-blue' : 'text-gray-400 group-hover:text-brand-blue' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                Promotions 
                                <div class="ml-auto flex items-center">
                                    <!-- <span class="bg-brand-pink bg-opacity-10 text-brand-pink text-xs px-2 py-1 rounded-full font-medium">3</span> -->
                                    @if(request()->routeIs('promotion.*'))
                                        <div class="ml-2 w-2 h-2 bg-brand-pink rounded-full">  </div>
                                    @endif
                                </div>
                            </a>
                        </div>

                        <!-- Reports & Analytics Section -->
                        <div class="space-y-1 pt-4">
                            <p class="px-3 text-xs font-semibold text-brand-pink uppercase tracking-wider">Reports & Analytics</p>
                            
                            <!-- Reports -->
                            <a href="{{ route('reports.dashboard') }}" 
                               class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('reports.*') ? 'bg-blue-50 text-brand-blue border-r-4 border-brand-blue shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-blue hover:shadow-sm' }}">
                                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('reports.*') ? 'text-brand-blue' : 'text-gray-400 group-hover:text-brand-blue' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Reports
                                @if(request()->routeIs('reports.*'))
                                    <div class="ml-auto w-2 h-2 bg-brand-pink rounded-full"></div>
                                @endif
                            </a>
                        </div>

                        <!-- System Section -->
                        <!-- <div class="space-y-1 pt-4">
                            <p class="px-3 text-xs font-semibold text-brand-pink uppercase tracking-wider">System</p>
                             -->
                            <!-- Settings -->
                            <a href="{{ route('users.index') }}" 
                               class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('users.*') ? 'bg-blue-50 text-brand-blue border-r-4 border-brand-blue shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-blue hover:shadow-sm' }}">
                              
                               <svg class="mr-3 h-5 w-5 {{ request()->routeIs('users.*') ? 'text-brand-blue' : 'text-gray-400 group-hover:text-brand-blue' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                User Management
                                @if(request()->routeIs('users.*'))
                                    <div class="ml-auto w-2 h-2 bg-brand-pink rounded-full"></div>
                                @endif
                            </a>


                        <!-- </div> -->
                    </nav>
                </div>

                <!-- User Profile -->
                <div class="flex-shrink-0 border-t border-gray-200 p-4 bg-gray-50">
                    <div class="flex items-center group hover:bg-white rounded-lg p-2 transition-colors duration-200">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-800 to-blue-700 flex items-center justify-center shadow-md">
                                <span class="text-sm font-semibold text-white">{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</span>
                            </div>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name ?? 'User' }}</p>
                            <div class="flex items-center justify-between">
                                <p class="text-xs text-gray-500">Administrator</p>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-xs text-gray-400 hover:text-brand-pink transition-colors duration-200 flex items-center">
                                        <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile sidebar -->
        <div x-show="sidebarOpen" class="fixed inset-0 flex z-40 md:hidden" x-cloak>
            <div x-show="sidebarOpen" 
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-600 bg-opacity-75"
                 @click="sidebarOpen = false"></div>

            <div x-show="sidebarOpen"
                 x-transition:enter="transition ease-in-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-300 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="relative flex-1 flex flex-col max-w-xs w-full bg-white">
                
                <!-- Mobile sidebar close button -->
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button @click="sidebarOpen = false" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Mobile Navigation -->
                <div class="flex flex-col flex-grow pt-5 overflow-y-auto bg-white shadow-lg">
                    <!-- Mobile Logo -->
                    <div class="flex items-center flex-shrink-0 px-6 mb-2">
                        <img class="h-24 justify-center items-center ml-4" src="{{ asset('/logoV1.png') }}" alt="Memoirex Logo" /> 
                    </div>

                    <!-- Mobile Navigation - Complete Match with Desktop -->
                    <div class="flex-grow flex flex-col">
                        <nav class="flex-1 px-4 space-y-2">
                            <!-- Main Section -->
                            <div class="space-y-1">
                                <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Main</p>
                                
                                <!-- Dashboard -->
                                <a href="{{ route('dashboard') }}" 
                                   @click="sidebarOpen = false"
                                   class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-brand-blue border-r-4 border-brand-blue shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-blue hover:shadow-sm' }}">
                                    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-brand-blue' : 'text-gray-400 group-hover:text-brand-blue' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h2a2 2 0 012 2v2H8V5z"></path>
                                    </svg>
                                    Dashboard
                                    @if(request()->routeIs('dashboard'))
                                        <div class="ml-auto w-2 h-2 bg-brand-pink rounded-full"></div>
                                    @endif
                                </a>
                            </div>

                            <!-- Employee Management Section -->
                            <div class="space-y-1 pt-4">
                                <p class="px-3 text-xs font-semibold text-brand-pink uppercase tracking-wider">Employee Management</p>
                                
                                <!-- Employee Management -->
                                <a href="{{ route('employment.index') }}" 
                                   @click="sidebarOpen = false"
                                   class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('employment.*') ? 'bg-blue-50 text-brand-blue border-r-4 border-brand-blue shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-blue hover:shadow-sm' }}">
                                    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('employment.*') ? 'text-brand-blue' : 'text-gray-400 group-hover:text-brand-blue' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                    Employees
                                    @if(request()->routeIs('employment.*'))
                                        <div class="ml-auto w-2 h-2 bg-brand-pink rounded-full"></div>
                                    @endif
                                </a>
                            </div>

                            <!-- Contract Management Section -->
                            <div class="space-y-1 pt-4">
                                <p class="px-3 text-xs font-semibold text-brand-pink uppercase tracking-wider">Contract Management</p>
                                
                                <!-- Contract Management -->
                                <a href="{{ route('contract.index') }}" 
                                   @click="sidebarOpen = false"
                                   class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('contract.*') ? 'bg-blue-50 text-brand-blue border-r-4 border-brand-blue shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-blue hover:shadow-sm' }}">
                                    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('contract.*') ? 'text-brand-blue' : 'text-gray-400 group-hover:text-brand-blue' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Contracts
                                    @if(request()->routeIs('contract.*'))
                                        <div class="ml-auto w-2 h-2 bg-brand-pink rounded-full"></div>
                                    @endif
                                </a>

                                <!-- Contract Tracking -->
                                <a href="{{ route('tracking.index') }}" 
                                   @click="sidebarOpen = false"
                                   class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('tracking.*') ? 'bg-blue-50 text-brand-blue border-r-4 border-brand-blue shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-blue hover:shadow-sm' }}">
                                    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('tracking.*') ? 'text-brand-blue' : 'text-gray-400 group-hover:text-brand-blue' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    Contract Tracking
                                    @if(request()->routeIs('tracking.*'))
                                        <div class="ml-auto w-2 h-2 bg-brand-pink rounded-full"></div>
                                    @endif
                                </a>

                                <!-- Reminders Dashboard -->
                                <a href="{{ route('reminders.dashboard') }}" 
                                   @click="sidebarOpen = false"
                                   class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('reminders*') ? 'bg-blue-50 text-brand-blue border-r-4 border-brand-blue shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-blue hover:shadow-sm' }}">
                                    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('reminders.*') ? 'text-brand-blue' : 'text-gray-400 group-hover:text-brand-blue' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Reminders Dashboard
                                    @if(request()->routeIs('reminders.*'))
                                        <div class="ml-auto w-2 h-2 bg-brand-pink rounded-full"></div>
                                    @endif
                                </a>
                            </div>

                            <!-- Notifications & Alerts Section -->
                            <div class="space-y-1 pt-4">
                                <p class="px-3 text-xs font-semibold text-brand-pink uppercase tracking-wider">Notifications & Alerts</p>
                                
                                <!-- Promotions -->
                                <a href="{{ route('promotion.index') }}" 
                                   @click="sidebarOpen = false"
                                   class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('promotion.*') ? 'bg-blue-50 text-brand-blue border-r-4 border-brand-blue shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-blue hover:shadow-sm' }}">
                                    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('promotion.*') ? 'text-brand-blue' : 'text-gray-400 group-hover:text-brand-blue' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                    Promotions
                                    @if(request()->routeIs('promotion.*'))
                                        <div class="ml-auto w-2 h-2 bg-brand-pink rounded-full"></div>
                                    @endif
                                </a>
                            </div>

                            <!-- Reports & Analytics Section -->
                            <div class="space-y-1 pt-4">
                                <p class="px-3 text-xs font-semibold text-brand-pink uppercase tracking-wider">Reports & Analytics</p>
                                
                                <!-- Reports -->
                                <a href="{{ route('reports.dashboard') }}" 
                                   @click="sidebarOpen = false"
                                   class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('reports.*') ? 'bg-blue-50 text-brand-blue border-r-4 border-brand-blue shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-blue hover:shadow-sm' }}">
                                    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('reports.*') ? 'text-brand-blue' : 'text-gray-400 group-hover:text-brand-blue' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Reports
                                    @if(request()->routeIs('reports.*'))
                                        <div class="ml-auto w-2 h-2 bg-brand-pink rounded-full"></div>
                                    @endif
                                </a>
                            </div>

                            <!-- User Management -->
                            <a href="{{ route('users.index') }}" 
                               @click="sidebarOpen = false"
                               class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('users.*') ? 'bg-blue-50 text-brand-blue border-r-4 border-brand-blue shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-blue hover:shadow-sm' }}">
                                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('users.*') ? 'text-brand-blue' : 'text-gray-400 group-hover:text-brand-blue' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                User Management
                                @if(request()->routeIs('users.*'))
                                    <div class="ml-auto w-2 h-2 bg-brand-pink rounded-full"></div>
                                @endif
                            </a>
                        </nav>
                    </div>

                    <!-- Mobile User Profile -->
                    <div class="flex-shrink-0 border-t border-gray-200 p-4 bg-gray-50">
                        <div class="flex items-center group hover:bg-white rounded-lg p-2 transition-colors duration-200">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-800 to-blue-700 flex items-center justify-center shadow-md">
                                    <span class="text-sm font-semibold text-white">{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name ?? 'User' }}</p>
                                <div class="flex items-center justify-between">
                                    <p class="text-xs text-gray-500">Administrator</p>
                                    <form method="POST" action="{{ route('logout') }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-xs text-gray-400 hover:text-brand-pink transition-colors duration-200 flex items-center">
                                            <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                            Sign out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex flex-col w-0 flex-1 overflow-hidden">
            <!-- Top bar -->
            <div class="relative z-10 flex-shrink-0 flex h-16 bg-white shadow-sm border-b border-gray-200">
                <!-- Mobile menu button -->
                <button @click="sidebarOpen = true" class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-brand-blue md:hidden hover:bg-gray-50 transition-colors duration-200">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                    </svg>
                </button>
                
                <div class="flex-1 px-4 flex justify-between items-center">
                    <!-- Page title -->
                    <div class="flex-1 flex items-center">
                        <h1 class="text-2xl font-semibold text-brand-blue">
                            @yield('page-title', 'Dashboard')
                        </h1>
                    </div>
                    
                    <!-- Top bar actions -->
                    <div class="ml-4 flex items-center md:ml-6 space-x-4">
                        <!-- User menu dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <div class="flex">
                                <div class="text-sm flex justify-center items-center mx-4 font-bold">                         
                                    {{ auth()->user()->name }}
                                </div>

                                <button @click="open = !open" class="bg-white rounded-full flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue transition-all duration-200">
                                    <div class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-900 to-blue-800 flex items-center justify-center shadow-md">
                                        <span class="text-sm font-semibold text-white">{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</span>
                                    </div>
                                </button>
                            </div>
                            
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                                <div class="py-1">
                                    <div class="px-4 py-2 text-sm text-gray-700 border-b border-gray-100">
                                        <p class="font-medium text-brand-blue">{{ auth()->user()->name ?? 'User' }}</p>
                                        <p class="text-xs text-gray-500">{{ auth()->user()->email ?? 'user@example.com' }}</p>
                                    </div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-brand-pink transition-colors duration-200">
                                            Sign out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page content -->
            <main class="flex-1 relative overflow-y-auto focus:outline-none">
                <!-- Flash messages -->
                @if (session('message'))
                    <div class="m-4">
                        <div class="bg-green-50 border border-green-200 rounded-md p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800">{{ session('message') }}</p>
                                </div>
                                <div class="ml-auto pl-3">
                                    <div class="-mx-1.5 -my-1.5">
                                        <button type="button" class="inline-flex bg-green-50 rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-green-50 focus:ring-green-600" onclick="this.parentElement.parentElement.parentElement.parentElement.remove()">
                                            <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="m-4">
                        <div class="bg-red-50 border border-red-200 rounded-md p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                                </div>
                                <div class="ml-auto pl-3">
                                    <div class="-mx-1.5 -my-1.5">
                                        <button type="button" class="inline-flex bg-red-50 rounded-md p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-50 focus:ring-red-600" onclick="this.parentElement.parentElement.parentElement.parentElement.remove()">
                                            <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="py-6">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html>