<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\Device;
use App\Models\Location;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get counts for dashboard stats
        $stats = [
            'total_devices' => Device::count(),
            'active_devices' => Device::where('is_active', true)->count(),
            'total_locations' => Location::count(),
            'pending_alerts' => Alert::where('status', 'pending')->count(),
            'total_alerts_today' => Alert::whereDate('triggered_at', today())->count(),
            'total_alerts_week' => Alert::where('triggered_at', '>=', now()->subDays(7))->count(),
        ];

        // Get recent alerts
        $recentAlerts = Alert::with(['device', 'device.location'])
            ->orderBy('triggered_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard.index', compact('stats', 'recentAlerts'));
    }

    public function alerts(Request $request)
    {
        $query = Alert::with(['device', 'device.location', 'acknowledgedBy']);

        // Filter by status if requested
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by device if requested
        if ($request->has('device_id')) {
            $query->where('device_id', $request->device_id);
        }

        // Filter by location if requested
        if ($request->has('location_id')) {
            $query->whereHas('device', function($q) use ($request) {
                $q->where('location_id', $request->location_id);
            });
        }

        // Filter by date range if requested
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('triggered_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        $alerts = $query->orderBy('triggered_at', 'desc')
            ->paginate(15)
            ->appends($request->all());

        $devices = Device::all();
        $locations = Location::all();

        return view('dashboard.alerts', compact('alerts', 'devices', 'locations'));
    }
}
