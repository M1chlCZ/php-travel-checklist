<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Trip::withCount('items')->orderByDesc('id')->paginate(25));
    }

    public function store(Request $request): JsonResponse
    {
        if (is_string($request->input('destination'))) {
            $request->merge(['destination' => strtoupper(trim($request->input('destination')))]);
        }

        $input = $request->validate([
            'destination' => ['required', 'string', 'regex:/^[A-Z]{2}$/'],
            'departure_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
        ]);

        return response()->json(Trip::create($input), 201);
    }

    public function show(Trip $trip): JsonResponse
    {
        return response()->json($trip->load('items'));
    }
}
