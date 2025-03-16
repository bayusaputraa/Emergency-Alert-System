<?php

// app/Http/Controllers/AlertController.php
namespace App\Http\Controllers;

use App\Models\Alert;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    public function index()
    {
        $alerts = Alert::with(['device', 'device.location'])
            ->orderBy('triggered_at', 'desc')
            ->paginate(15);

        return view('alerts.index', compact('alerts'));
    }

    public function show(Alert $alert)
    {
        $alert->load(['device', 'device.location', 'acknowledgedBy']);
        return view('alerts.show', compact('alert'));
    }

    public function acknowledge(Request $request, Alert $alert)
    {
        $validated = $request->validate([
            'notes' => 'nullable|string',
            'status' => 'required|in:acknowledged,resolved,false_alarm',
        ]);

        $alert->status = $validated['status'];
        $alert->notes = $validated['notes'];
        $alert->acknowledged_at = now();
        $alert->acknowledged_by = auth()->id();
        $alert->save();

        return redirect()->back()
            ->with('success', 'Alert has been acknowledged.');
    }
}
