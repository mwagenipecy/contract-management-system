<div>
<div class="min-h-screen bg-gray-50" wire:poll.30s>
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Reports Dashboard</h1>
                    <p class="text-gray-600 mt-1">Monitor alerts, contracts, and system performance</p>
                </div>
                
                <!-- Filters -->
                <div class="flex space-x-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Time Range</label>
                        <select wire:model.live="dateRange" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="7">Last 7 days</option>
                            <option value="30">Last 30 days</option>
                            <option value="90">Last 90 days</option>
                            <option value="365">Last year</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                        <select wire:model.live="selectedDepartment" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="all">All Departments</option>
                            @foreach($this->departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Key Metrics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Employee Stats -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-600">Total Employees</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $this->employeeStats['total'] }}</p>
                        <p class="text-sm text-green-600">{{ $this->employeeStats['active_percentage'] }}% Active</p>
                    </div>
                </div>
            </div>

            <!-- Contract Stats -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-600">Active Contracts</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $this->contractStats['active'] }}</p>
                        @if($this->contractStats['expiring_soon'] > 0)
                            <p class="text-sm text-red-600">{{ $this->contractStats['expiring_soon'] }} Expiring Soon</p>
                        @else
                            <p class="text-sm text-green-600">All contracts current</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Promotion Stats -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-600">Notifications Sent</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $this->promotionStats['sent'] }}</p>
                        <p class="text-sm text-green-600">{{ $this->promotionStats['success_rate'] }}% Success Rate</p>
                    </div>
                </div>
            </div>

            <!-- Reminder Stats -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-600">Pending Reminders</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $this->reminderStats['pending'] }}</p>
                        @if($this->reminderStats['overdue'] > 0)
                            <p class="text-sm text-red-600">{{ $this->reminderStats['overdue'] }} Overdue</p>
                        @else
                            <p class="text-sm text-green-600">All up to date</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Promotion Trends Chart -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Notification Trends</h3>
                <div class="h-80">
                    <canvas id="promotionTrendsChart"></canvas>
                </div>
            </div>

            <!-- Department Breakdown -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Department Overview</h3>
                <div class="h-80">
                    <canvas id="departmentChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Notification Methods & Recent Alerts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Notification Methods -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Notification Methods Performance</h3>
                <div class="space-y-4">
                    @foreach($this->notificationMethods as $method)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="p-2 bg-indigo-100 rounded-lg mr-3">
                                    @if($method['type'] === 'Sms')
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $method['type'] }}</p>
                                    <p class="text-sm text-gray-600">{{ $method['sent'] }}/{{ $method['total'] }} sent</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-semibold {{ $method['success_rate'] >= 90 ? 'text-green-600' : ($method['success_rate'] >= 70 ? 'text-yellow-600' : 'text-red-600') }}">
                                    {{ $method['success_rate'] }}%
                                </p>
                                <p class="text-sm text-gray-500">Success Rate</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Recent Alerts -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Alerts</h3>
                <div class="space-y-3 max-h-80 overflow-y-auto">
                    @forelse($this->recentAlerts as $alert)
                        <div class="flex items-start p-3 rounded-lg {{ $alert['severity'] === 'danger' ? 'bg-red-50 border-l-4 border-red-400' : ($alert['severity'] === 'warning' ? 'bg-yellow-50 border-l-4 border-yellow-400' : 'bg-blue-50 border-l-4 border-blue-400') }}">
                            <div class="flex-shrink-0 mr-3 mt-1">
                                @if($alert['severity'] === 'danger')
                                    <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                @elseif($alert['severity'] === 'warning')
                                    <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium {{ $alert['severity'] === 'danger' ? 'text-red-800' : ($alert['severity'] === 'warning' ? 'text-yellow-800' : 'text-blue-800') }}">
                                    {{ $alert['title'] }}
                                </p>
                                <p class="text-sm {{ $alert['severity'] === 'danger' ? 'text-red-700' : ($alert['severity'] === 'warning' ? 'text-yellow-700' : 'text-blue-700') }} mt-1">
                                    {{ $alert['message'] }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ \Carbon\Carbon::parse($alert['date'])->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No alerts</h3>
                            <p class="mt-1 text-sm text-gray-500">Everything looks good! No recent alerts to display.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Scripts -->
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let promotionChart, departmentChart;

            function initCharts() {
                // Promotion Trends Chart
                const promotionCtx = document.getElementById('promotionTrendsChart').getContext('2d');
                const promotionData = @json($this->promotionTrends);
                
                if (promotionChart) {
                    promotionChart.destroy();
                }

                promotionChart = new Chart(promotionCtx, {
                    type: 'line',
                    data: {
                        labels: promotionData.map(item => item.date),
                        datasets: [{
                            label: 'Sent',
                            data: promotionData.map(item => item.sent),
                            borderColor: 'rgb(34, 197, 94)',
                            backgroundColor: 'rgba(34, 197, 94, 0.1)',
                            tension: 0.4
                        }, {
                            label: 'Failed',
                            data: promotionData.map(item => item.failed),
                            borderColor: 'rgb(239, 68, 68)',
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });

                // Department Chart
                const departmentCtx = document.getElementById('departmentChart').getContext('2d');
                const departmentData = @json($this->departmentBreakdown);
                
                if (departmentChart) {
                    departmentChart.destroy();
                }

                departmentChart = new Chart(departmentCtx, {
                    type: 'doughnut',
                    data: {
                        labels: departmentData.map(item => item.name),
                        datasets: [{
                            data: departmentData.map(item => item.employees),
                            backgroundColor: [
                                'rgb(59, 130, 246)',
                                'rgb(16, 185, 129)',
                                'rgb(245, 158, 11)',
                                'rgb(239, 68, 68)',
                                'rgb(168, 85, 247)',
                                'rgb(236, 72, 153)'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }

            // Initialize charts
            initCharts();

            // Listen for chart refresh events
            Livewire.on('refreshCharts', () => {
                setTimeout(() => {
                    initCharts();
                }, 100);
            });
        });
    </script>
    @endpush
</div>

</div>
