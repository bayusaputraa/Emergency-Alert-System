<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::with('location')->orderBy('name')->paginate(15);
        return view('devices.index', compact('devices'));
    }

    public function create()
    {
        $locations = Location::orderBy('name')->get();
        return view('devices.create', compact('locations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location_id' => 'required|exists:locations,id',
            'description' => 'nullable|string',
        ]);

        // Generate unique device ID and API key
        $validated['device_id'] = 'DEV-' . Str::upper(Str::random(8));
        $validated['api_key'] = Device::generateApiKey();
        $validated['is_active'] = $request->has('is_active');

        Device::create($validated);

        return redirect()->route('devices.index')
            ->with('success', 'Device created successfully.');
    }

    public function show(Device $device)
    {
        $device->load(['location', 'alerts' => function($query) {
            $query->latest('triggered_at')->limit(10);
        }]);

        return view('devices.show', compact('device'));
    }

    public function edit(Device $device)
    {
        $locations = Location::orderBy('name')->get();
        return view('devices.edit', compact('device', 'locations'));
    }

    public function update(Request $request, Device $device)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location_id' => 'required|exists:locations,id',
            'description' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $device->update($validated);

        return redirect()->route('devices.index')
            ->with('success', 'Device updated successfully.');
    }

    public function destroy(Device $device)
    {
        // Check if device has any alerts before deletion
        if ($device->alerts()->count() > 0) {
            return redirect()->route('devices.index')
                ->with('error', 'Cannot delete device with associated alerts.');
        }

        $device->delete();

        return redirect()->route('devices.index')
            ->with('success', 'Device deleted successfully.');
    }

    public function regenerateApiKey(Device $device)
    {
        $device->api_key = Device::generateApiKey();
        $device->save();

        return redirect()->route('devices.edit', $device)
            ->with('success', 'API key regenerated successfully.');
    }
}
