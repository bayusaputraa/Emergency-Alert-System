<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Emergency Alerts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Filters -->
                    <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-4 border-b border-gray-200 dark:border-gray-600">
                            <h3 class="text-lg font-bold text-gray-700 dark:text-gray-300">Filter Alerts</h3>
                        </div>
                        <div class="p-6">
                            <form method="GET" action="{{ route('dashboard.alerts') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                                    <select class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full" id="status" name="status">
                                        <option value="">All Statuses</option>
                                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="acknowledged" {{ request('status') === 'acknowledged' ? 'selected' : '' }}>Acknowledged</option>
                                        <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                        <option value="false_alarm" {{ request('status') === 'false_alarm' ? 'selected' : '' }}>False Alarm</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="device_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Device</label>
                                    <select class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full" id="device_id" name="device_id">
                                        <option value="">All Devices</option>
                                        @foreach($devices as $device)
                                            <option value="{{ $device->id }}" {{ request('device_id') == $device->id ? 'selected' : '' }}>
                                                {{ $device->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="location_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Location</label>
                                    <select class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full" id="location_id" name="location_id">
                                        <option value="">All Locations</option>
                                        @foreach($locations as $location)
                                            <option value="{{ $location->id }}" {{ request('location_id') == $location->id ? 'selected' : '' }}>
                                                {{ $location->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Start Date</label>
                                    <input type="date" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full" id="start_date" name="start_date" value="{{ request('start_date') }}">
                                </div>

                                <div>
                                    <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Date</label>
                                    <input type="date" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full" id="end_date" name="end_date" value="{{ request('end_date') }}">
                                </div>

                                <div class="md:col-span-2 lg:col-span-3 flex items-end">
                                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-md hover:bg-blue-600 mr-2">Apply Filters</button>
                                    <a href="{{ route('dashboard.alerts') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm font-medium rounded-md hover:bg-gray-300 dark:hover:bg-gray-500">Reset</a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Alerts List -->
                    <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-4 border-b border-gray-200 dark:border-gray-600">
                            <h3 class="text-lg font-bold text-gray-700 dark:text-gray-300">All Alerts</h3>
                        </div>
                        <div class="p-6">
                            @if($alerts->count() > 0)
                                <div class="space-y-4">
                                    @foreach($alerts as $alert)
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

                                <div class="mt-4 flex justify-center">
                                    {{ $alerts->links() }}
                                </div>
                            @else
                                <p class="text-center text-gray-500 dark:text-gray-400">No alerts found.</p>
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
        // Pusher configuration for real-time alerts
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

            // Reload the page to show the new alert
            setTimeout(() => {
                location.reload();
            }, 5000);
        });
    </script>
    @endpush
</x-app-layout>
