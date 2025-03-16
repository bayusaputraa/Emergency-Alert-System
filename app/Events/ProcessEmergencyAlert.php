<?php

namespace App\Listeners;

use App\Events\NewEmergencyAlert;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class ProcessEmergencyAlert implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewEmergencyAlert  $event
     * @return void
     */
    public function handle(NewEmergencyAlert $event)
    {
        $alert = $event->alert;

        // Log the alert
        Log::info("Emergency alert received", [
            'alert_id' => $alert->id,
            'device_id' => $alert->device->device_id,
            'device_name' => $alert->device->name,
            'location' => $alert->device->location->name,
            'triggered_at' => $alert->triggered_at->toIso8601String(),
        ]);

        // Here you can add additional processing such as:
        // - Sending email notifications
        // - Sending SMS alerts
        // - Logging to external services
        // - Triggering automated responses
    }
}
