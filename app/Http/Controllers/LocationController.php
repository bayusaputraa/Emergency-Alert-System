<?php

// app/Http/Controllers/LocationController.php
namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Alert; // Tambahkan ini
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::withCount('devices')->orderBy('name')->paginate(15);
        return view('locations.index', compact('locations'));
    }

    public function create()
    {
        return view('locations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'description' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
        ]);

        Location::create($validated);

        return redirect()->route('locations.index')
            ->with('success', 'Location created successfully.');
    }

    public function show(Location $location)
    {
        $location->load(['devices' => function($query) {
            $query->withCount('alerts');
        }]);

        // Get recent alerts for this location
        $recentAlerts = Alert::whereHas('device', function($query) use ($location) {
            $query->where('location_id', $location->id);
        })->with('device')
          ->orderBy('triggered_at', 'desc')
          ->limit(10)
          ->get();

        return view('locations.show', compact('location', 'recentAlerts'));
    }

    public function edit(Location $location)
    {
        return view('locations.edit', compact('location'));
    }

    public function update(Request $request, Location $location)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'description' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
        ]);

        $location->update($validated);

        return redirect()->route('locations.index')
            ->with('success', 'Location updated successfully.');
    }

    public function destroy(Location $location)
    {
        // Check if location has any devices before deletion
        if ($location->devices()->count() > 0) {
            return redirect()->route('locations.index')
                ->with('error', 'Cannot delete location with associated devices.');
        }

        $location->delete();

        return redirect()->route('locations.index')
            ->with('success', 'Location deleted successfully.');
    }
}
