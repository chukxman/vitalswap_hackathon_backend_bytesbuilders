<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

class FeeController extends Controller
{
    private $baseUrl = 'https://2kbbumlxz3.execute-api.us-east-1.amazonaws.com/default';

    public function getFees()
    {
        try {
            $response = Http::get("{$this->baseUrl}/fee");
            if ($response->successful()) {
                return response()->json($response->json(), 200);
            }
            return response()->json([
                'error' => 'Failed to fetch fee data',
                'status' => $response->status()
            ], $response->status());
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Server Error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getExchangeRate(Request $request)
    {
        $validated = $request->validate([
            'from' => 'required|string|size:3',
            'to' => 'required|string|size:3'
        ]);

        try {
            $url = "{$this->baseUrl}/exchange";
            $response = Http::get($url, [
                'from' => $validated['from'],
                'to' => $validated['to']
            ]);

            if ($response->successful()) {
                return response()->json($response->json(), 200);
            }

            return response()->json([
                'error' => 'Failed to fetch exchange rate',
                'status' => $response->status()
            ], $response->status());
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Server Error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
