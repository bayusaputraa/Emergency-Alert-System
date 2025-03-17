<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Device Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('devices.edit', $device) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Device
                </a>
                <a href="{{ route('devices.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-300 focus:bg-gray-700 dark:focus:bg-gray-300 active:bg-gray-900 dark:active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Devices
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Device Details -->
                <div class="md:col-span-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div class="mb-6">
                                <h3 class="text-lg font-bold text-gray-700 dark:text-gray-300 mb-4">Device Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <span class="font-bold">Name:</span> {{ $device->name }}
                                        </p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <span class="font-bold">Device ID:</span>
                                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                                {{ $device->device_id }}
                                            </span>
                                        </p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                            <span class="font-bold">Status:</span>
                                            @if($device->is_active)
                                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                                    Active
                                                </span>
                                            @else
                                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                                    Inactive
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <span class="font-bold">Location:</span>
                                            <a href="{{ route('locations.show', $device->location) }}" class="text-blue-500 hover:underline">
                                                {{ $device->location->name }}
                                            </a>
                                        </p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <span class="font-bold">Address:</span> {{ $device->location->address }}
                                        </p>
                                    </div>
                                </div>
                                @if($device->description)
                                    <div class="mt-4">
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <span class="font-bold">Description:</span><br>
                                            {{ $device->description }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- API Key Information -->
                <div class="md:col-span-1">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">API Key</h3>

                            <div class="bg-yellow-50 dark:bg-yellow-900 p-4 rounded-md mb-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700 dark:text-yellow-200">
                                            This API key is required for device authentication.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <x-input-label for="api_key" :value="__('API Key')" />
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <x-text-input id="api_key" class="flex-1" type="text" :value="$device->api_key" readonly />
                                    <button type="button" id="copyApiKey" class="inline-flex items-center px-3 py-2 border border-l-0 border-gray-300 dark:border-gray-700 rounded-r-md bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('devices.edit', $device) }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                    </svg>
                                    Edit Device & Regenerate API Key
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Alerts -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-4 border-b border-gray-200 dark:border-gray-600">
                    <h3 class="text-lg font-bold text-gray-700 dark:text-gray-300">Recent Alerts</h3>
                </div>
                <div class="p-6">
                    @if($device->alerts->count() > 0)
                        <div class="space-y-4">
                            @foreach($device->alerts as $alert)
                                <div class="p-4 border-l-4 {{ $alert->status === 'pending' ? 'border-red-500' : 'border-gray-300' }} bg-white dark:bg-gray-800 rounded shadow-sm">
                                    <div class="flex justify-between">
                                        <div>
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
                        <p class="text-center text-gray-500 dark:text-gray-400">No alerts for this device yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('copyApiKey').addEventListener('click', function() {
            const apiKeyInput = document.getElementById('api_key');
            apiKeyInput.select();
            document.execCommand('copy');

            // Change button content temporarily to show success
            const originalContent = this.innerHTML;
            this.innerHTML = `
                <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            `;

            setTimeout(() => {
                this.innerHTML = originalContent;
            }, 2000);
        });
    </script>
    @endpush
</x-app-layout>
