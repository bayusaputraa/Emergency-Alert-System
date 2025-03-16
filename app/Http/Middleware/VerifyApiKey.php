<?php
// app/Http/Middleware/VerifyApiKey.php
namespace App\Http\Middleware;

use Closure;
use App\Models\Device;
use Illuminate\Http\Request;

class VerifyApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X-API-KEY');

        if (!$apiKey) {
            return response()->json([
                'success' => false,
                'message' => 'API key is missing'
            ], 401);
        }

        // Check if the API key is valid
        $device = Device::where('api_key', $apiKey)->first();

        if (!$device) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid API key'
            ], 401);
        }

        // If device ID is provided in the request, ensure it matches the API key
        if ($request->has('device_id') && $device->device_id !== $request->device_id) {
            return response()->json([
                'success' => false,
                'message' => 'Device ID does not match API key'
            ], 403);
        }

        // Add the device to the request for use in the controller
        $request->merge(['verified_device' => $device]);

        return $next($request);
    }
}
