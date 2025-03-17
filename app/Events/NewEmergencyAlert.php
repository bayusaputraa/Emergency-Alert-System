<?php
// app/Events/NewEmergencyAlert.php
namespace App\Events;

use App\Models\Alert;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewEmergencyAlert implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $alert;

    /**
     * Create a new event instance.
     *
     * @param Alert $alert
     * @return void
     */
    public function __construct(Alert $alert)
    {
        $this->alert = $alert;
        // Load relationships for broadcasting
        $this->alert->load(['device', 'device.location']);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('emergency-alerts');
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'id' => $this->alert->id,
            'device_name' => $this->alert->device->name,
            'device_id' => $this->alert->device->device_id,
            'location_name' => $this->alert->device->location->name,
            'location_address' => $this->alert->device->location->address,
            // 'triggered_at' => $this->alert->triggered_at->toIso8601String(),
            'triggered_at' => \Carbon\Carbon::parse($this->alert->triggered_at)->toIso8601String(),
            'status' => $this->alert->status,
        ];
    }
}
