<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Alert;
use Illuminate\Http\Request;
use App\Events\NewEmergencyAlert;

class AlertApiController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'device_id' => 'required|string|exists:devices,device_id',
            ]);

            // Find the device
            $device = Device::where('device_id', $request->device_id)->first();

            if (!$device) {
                return response()->json([
                    'success' => false,
                    'message' => 'Device not found'
                ], 404);
            }

            if (!$device->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Device is inactive'
                ], 403);
            }

            // Create a new alert
            $alert = Alert::create([
                'device_id' => $device->id,
                'triggered_at' => now(),
                'status' => 'pending'
            ]);

            // Broadcast the event for real-time notifications
            event(new NewEmergencyAlert($alert));

            return response()->json([
                'success' => true,
                'message' => 'Emergency alert received',
                'alert_id' => $alert->id
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error processing alert: ' . $e->getMessage()
            ], 500);
        }
    }
}
