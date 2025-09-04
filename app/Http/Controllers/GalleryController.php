<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GalleryController extends Controller
{
    public function search(Request $request)
    {
        $validated = $request->validate([
            'q' => 'required|string|min:1|max:100',
            'page' => 'sometimes|integer|min:1',
            'per_page' => 'sometimes|integer|min:1|max:80',
        ]);

        $query = $validated['q'];
        $page = $validated['page'] ?? 1;
        $perPage = $validated['per_page'] ?? 24;

        $apiKey = config('services.pexels.key');
        if (!$apiKey) {
            return response()->json([
                'message' => 'Pexels API key not configured',
            ], 500);
        }

        $response = Http::withHeaders([
            'Authorization' => $apiKey,
            'Accept' => 'application/json',
        ])->get('https://api.pexels.com/v1/search', [
            'query' => $query,
            'page' => $page,
            'per_page' => $perPage,
        ]);

        if ($response->failed()) {
            return response()->json([
                'message' => 'Failed to fetch images from Pexels',
                'status' => $response->status(),
            ], $response->status() >= 400 ? $response->status() : 502);
        }

        return response()->json($response->json());
    }
}


