<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class GeocodeController extends Controller
{
    /**
     * Make request to mapbox.
     * Route: GET / (name: geocode)
     *
     * @return JsonResponse
     */
    public function geocode(Request $request): JsonResponse
    {
        $address = $request->string('address')->trim()->toString();
        $accessToken = config('services.mapbox.token');

        if ($address === '' || blank($accessToken)) {
            return response()->json(['features' => []], 422);
        }

        $response = Http::get(
            'https://api.mapbox.com/geocoding/v5/mapbox.places/' . rawurlencode($address) . '.json',
            ['access_token' => $accessToken]
        );

        return response()->json($response->json(), $response->status());
    }
}
