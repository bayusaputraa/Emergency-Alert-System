<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Alert Details') }}
            </h2>
            <a href="{{ route('dashboard.alerts') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-300 focus:bg-gray-700 dark:focus:bg-gray-300 active:bg-gray-900 dark:active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Alerts
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Alert Details -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Alert Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <span class="font-bold">Device:</span> {{ $alert->device->name }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <span class="font-bold">Device ID:</span> {{ $alert->device->device_id }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <span class="font-bold">Location:</span> {{ $alert->device->location->name }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <span class="font-bold">Address:</span> {{ $alert->device->location->address }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{-- <span class="font-bold">Triggered At:</span> {{ $alert->triggered_at->format('Y-m-d H:i:s') }} --}}
                                    <span>Triggered:
                                        {{ \Carbon\Carbon::parse($alert->triggered_at)->format('Y-m-d H:i:s') }}</span>
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <span class="font-bold">Status:</span>
                                    <span
                                        class="px-2 py-1 text-xs rounded-full {{ $alert->status === 'pending' ? 'bg-red-100 text-red-800' : ($alert->status === 'acknowledged' ? 'bg-yellow-100 text-yellow-800' : ($alert->status === 'resolved' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800')) }}">
                                        {{ ucfirst($alert->status) }}
                                    </span>
                                </p>
                                @if ($alert->status !== 'pending')
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{-- <span class="font-bold">Acknowledged At:</span> {{ $alert->acknowledged_at ? $alert->acknowledged_at->format('Y-m-d H:i:s') : 'N/A' }} --}}
                                        <span class="font-bold">Acknowledged At:</span>
                                        {{ $alert->acknowledged_at ? \Carbon\Carbon::parse($alert->acknowledged_at)->format('Y-m-d H:i:s') : 'N/A' }}
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        <span class="font-bold">Acknowledged By:</span>
                                        {{ $alert->acknowledgedBy ? $alert->acknowledgedBy->name : 'N/A' }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Alert Actions -->
                    @if ($alert->status === 'pending')
                        <div class="mt-6 p-4 bg-white dark:bg-gray-700 border rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Update Alert Status
                            </h3>
                            <form method="POST" action="{{ route('alerts.acknowledge', $alert) }}">
                                @csrf
                                <div class="mb-4">
                                    <x-input-label for="status" :value="__('Status')" />
                                    <select id="status" name="status"
                                        class="block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                        required>
                                        <option value="">Select Status</option>
                                        <option value="acknowledged">Acknowledged</option>
                                        <option value="resolved">Resolved</option>
                                        <option value="false_alarm">False Alarm</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <x-input-label for="notes" :value="__('Notes (Optional)')" />
                                    <textarea id="notes" name="notes" rows="3"
                                        class="block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                                </div>

                                <div class="flex justify-end">
                                    <x-primary-button>
                                        {{ __('Update Status') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    @elseif($alert->status !== 'resolved' && $alert->status !== 'false_alarm')
                        <div class="mt-6 p-4 bg-white dark:bg-gray-700 border rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Resolve Alert</h3>
                            <form method="POST" action="{{ route('alerts.acknowledge', $alert) }}">
                                @csrf
                                <input type="hidden" name="status" value="resolved">

                                <div class="mb-4">
                                    <x-input-label for="notes" :value="__('Resolution Notes (Optional)')" />
                                    <textarea id="notes" name="notes" rows="3"
                                        class="block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                                </div>

                                <div class="flex justify-end">
                                    <x-primary-button>
                                        {{ __('Mark as Resolved') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    @endif

                    <!-- Additional Notes -->
                    @if ($alert->notes)
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Notes</h3>
                            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <p class="text-gray-700 dark:text-gray-300">{{ $alert->notes }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
