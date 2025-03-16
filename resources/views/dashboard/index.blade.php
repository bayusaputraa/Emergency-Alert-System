<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                        <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-4 border-l-4 border-blue-500">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-xs font-bold text-blue-500 uppercase mb-1">
                                        Total Devices
                                    </div>
                                    <div class="text-xl font-bold text-gray-800 dark:text-gray-200">
                                        {{ $stats['total_devices'] }}
                                    </div>
                                </div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-4 border-l-4 border-green-500">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-xs font-bold text-green-500 uppercase mb-1">
                                        Active Devices
                                    </div>
                                    <div class="text-xl font-bold text-gray-800 dark:text-gray-200">
                                        {{ $stats['active_devices'] }}
                                    </div>
                                </div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-4 border-l-4 border-indigo-500">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-xs font-bold text-indigo-500 uppercase mb-1">
                                        Total Locations
                                    </div>
                                    <div class="text-xl font-bold text-gray-800 dark:text-gray-200">
                                        {{ $stats['total_locations'] }}
                                    </div>
                                </div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-4 border-l-4 border-red-500">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-xs font-bold text-red-500 uppercase mb-1">
                                        Pending Alerts
                                    </div>
                                    <div class="text-xl font-bold text-gray-800 dark:text-gray-200">
                                        {{ $stats['pending_alerts'] }}
                                    </div>
                                </div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Alerts -->
                    <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-4 border-b border-gray-200 dark:border-gray-600 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-700 dark:text-gray-300">Recent Alerts</h3>
                            <a href="{{ route('dashboard.alerts') }}" class="px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-md hover:bg-blue-600">View All</a>
                        </div>
                        <div class="p-6">
                            @if($recentAlerts->count() > 0)
                                <div class="space-y-4">
                                    @foreach($recentAlerts as $alert)
                                        <div class="p-4 border-l-4 {{ $alert->status === 'pending' ? 'border-red-500' : 'border-gray-300' }} bg-white dark:bg-gray-800 rounded shadow-sm">
                                            <div class="flex justify-between">
                                                <div>
                                                    <h4 class="font-bold">{{ $alert->device->name }}</h4>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                                        <span>Location: {{ $alert->device->location->name }}</span><br>
                                                        <span>Triggered: {{ $alert->triggered_at->format('Y-m-d H:i:s') }}</span>
                                                    </p>
                                                </div>
                                                <div>
                                                    <span class="px-2 py-1 text-xs rounded-full {{ $alert->status === 'pending' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800' }}">
                                                        {{ ucfirst($alert->status) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <a href="{{ route('alerts.show', $alert) }}" class="text-sm text-blue-500 hover:underline">View Details</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-center text-gray-500 dark:text-gray-400">No recent alerts found.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script>
        // Enable pusher logging - for development
        Pusher.logToConsole = true;

        const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
        });

        const channel = pusher.subscribe('emergency-alerts');
        channel.bind('App\\Events\\NewEmergencyAlert', function(data) {
            // Play alert sound
            document.getElementById('alertSound').play();

            // Show toast notification
            const toast = document.createElement('div');
            toast.className = 'fixed top-4 right-4 bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden max-w-sm';
            toast.innerHTML = `
                <div class="bg-red-500 px-4 py-2 flex justify-between items-center">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span class="text-white font-bold">Emergency Alert</span>
                    </div>
                    <button class="text-white" onclick="this.parentElement.parentElement.remove()">×</button>
                </div>
                <div class="px-4 py-3">
                    <p class="text-gray-800 dark:text-gray-200 mb-2">
                        <strong>${data.device_name}</strong> at <strong>${data.location_name}</strong> has triggered an emergency alert.
                    </p>
                    <a href="/alerts/${data.id}" class="inline-block px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded hover:bg-blue-600">View Details</a>
                </div>
            `;
            document.body.appendChild(toast);

            // Remove toast after 10 seconds
            setTimeout(() => {
                toast.remove();
            }, 10000);

            // Refresh the page after a short delay to show the new alert
            setTimeout(() => {
                location.reload();
            }, 5000);
        });
    </script>
    @endpush
</x-app-layout>
