<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Location Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('locations.edit', $location) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Location
                </a>
                <a href="{{ route('locations.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-300 focus:bg-gray-700 dark:focus:bg-gray-300 active:bg-gray-900 dark:active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Locations
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-700 dark:text-gray-300 mb-4">Location Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <span class="font-bold">Name:</span> {{ $location->name }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <span class="font-bold">Address:</span> {{ $location->address }}
                                </p>
                                @if($location->description)
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                        <span class="font-bold">Description:</span><br>
                                        {{ $location->description }}
                                    </p>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <span class="font-bold">Contact Person:</span> {{ $location->contact_person ?? 'N/A' }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <span class="font-bold">Contact Phone:</span> {{ $location->contact_phone ?? 'N/A' }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <span class="font-bold">Total Devices:</span> {{ $location->devices->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Devices at this location -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4 border-b border-gray-200 dark:border-gray-600 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-700 dark:text-gray-300">Devices at this Location</h3>
                    <a href="{{ route('devices.create') }}" class="px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-md hover:bg-blue-600">Add Device</a>
                </div>
                <div class="p-6">
                    @if($location->devices->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white dark:bg-gray-800 border">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-left text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-left text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Device ID</th>
                                        <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-left text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-left text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Alerts</th>
                                        <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 text-xs leading-4 font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($location->devices as $device)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-no-wrap">{{ $device->name }}</td>
                                            <td class="px-6 py-4 whitespace-no-wrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                                    {{ $device->device_id }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap">
                                                @if($device->is_active)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                                        Active
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                                        Inactive
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap">
                                                {{ $device->alerts_count ?? 0 }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap text-right text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('devices.show', $device) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                    </a>
                                                    <a href="{{ route('devices.edit', $device) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-gray-500 dark:text-gray-400">No devices found at this location.</p>
                        <div class="mt-4 flex justify-center">
                            <a href="{{ route('devices.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add First Device
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Alerts -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 border-b border-gray-200 dark:border-gray-600">
                    <h3 class="text-lg font-bold text-gray-700 dark:text-gray-300">Recent Alerts at this Location</h3>
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
                                                <span>Triggered: {{ \Carbon\Carbon::parse($alert->triggered_at)->format('Y-m-d H:i:s') }}</span>
                                            </p>
                                        </div>
                                        <div>
                                            <span class="px-2 py-1 text-xs rounded-full {{ 
                                                $alert->status === 'pending' ? 'bg-red-100 text-red-800' : 
                                                ($alert->status === 'acknowledged' ? 'bg-yellow-100 text-yellow-800' : 
                                                ($alert->status === 'resolved' ? 'bg-green-100 text-green-800' : 
                                                'bg-gray-100 text-gray-800')) 
                                            }}">
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
                        <p class="text-center text-gray-500 dark:text-gray-400">No recent alerts at this location.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
