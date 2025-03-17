<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    <!-- Alert Sound -->
    <audio id="alertSound" src="{{ asset('sounds/alert.mp3') }}" preload="auto"></audio>

    <!-- Notification Container -->
    <div id="notificationContainer" class="fixed top-0 right-0 p-4 z-50">
        <!-- Notifications will be dynamically added here -->
    </div>

    <!-- Pusher Notification Script -->
    @if (auth()->check())
        <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Pusher configuration with your credentials
                const pusher = new Pusher('b9d24e5ef3c957645497', {
                    cluster: 'ap1'
                });

                // Subscribe to the emergency alerts channel
                const channel = pusher.subscribe('emergency-alerts');

                // Listen for new emergency alerts
                channel.bind('App\\Events\\NewEmergencyAlert', function(data) {
                    console.log('Alert received:', data); // Debug output

                    // Play alert sound
                    const alertSound = document.getElementById('alertSound');
                    if (alertSound) {
                        alertSound.play().catch(e => console.error('Error playing sound:', e));
                    }

                    // Create toast notification
                    const toast = document.createElement('div');
                    toast.className =
                        'bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden max-w-sm mb-4 transition-all transform duration-500 ease-in-out';
                    toast.innerHTML = `
                <div class="bg-red-500 px-4 py-2 flex justify-between items-center">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span class="text-white font-bold">EMERGENCY ALERT!</span>
                    </div>
                    <button class="text-white hover:text-gray-200" onclick="this.parentElement.parentElement.remove()">×</button>
                </div>
                <div class="px-4 py-3">
                    <p class="text-gray-800 dark:text-gray-200 font-semibold mb-1">
                        Alert from ${data.device_name}
                    </p>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">
                        Location: ${data.location_name}<br>
                        Time: ${new Date().toLocaleTimeString()}
                    </p>
                    <div class="flex justify-end">
                        <a href="/alerts/${data.id}" class="inline-block px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded hover:bg-blue-600">
                            View Details
                        </a>
                    </div>
                </div>
            `;

                    // Add animation
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateX(100%)';

                    // Add to notification container
                    const container = document.getElementById('notificationContainer');
                    if (container) {
                        container.appendChild(toast);

                        // Trigger animation
                        setTimeout(() => {
                            toast.style.opacity = '1';
                            toast.style.transform = 'translateX(0)';
                        }, 10);

                        // Remove after 15 seconds
                        setTimeout(() => {
                            toast.style.opacity = '0';
                            toast.style.transform = 'translateX(100%)';
                            setTimeout(() => {
                                toast.remove();
                            }, 500);
                        }, 15000);
                    }

                    // Also add flashing effect for higher visibility
                    let isFlashing = true;
                    let bgElement;
                    const flashInterval = setInterval(() => {
                        if (isFlashing && toast.parentNode) {
                            bgElement = toast.querySelector('.bg-red-500');
                            if (bgElement) {
                                bgElement.classList.toggle('bg-red-700');
                            }
                        } else {
                            clearInterval(flashInterval);
                        }
                    }, 500);

                    // Stop flashing after 15 seconds
                    setTimeout(() => {
                        isFlashing = false;
                    }, 15000);
                });
            });
        </script>
    @endif
</body>

</html>
