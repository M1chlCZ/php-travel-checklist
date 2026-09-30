<?php

namespace App\Http\Controllers;

use App\Models\ChecklistItem;
use App\Models\Trip;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChecklistItemController extends Controller
{
    public function store(Request $request, Trip $trip): JsonResponse
    {
        $input = $request->validate(['title' => ['required', 'string', 'max:120']]);

        return response()->json($trip->items()->create($input), 201);
    }

    public function update(Request $request, Trip $trip, ChecklistItem $item): JsonResponse
    {
        $input = $request->validate(['completed' => ['required', 'boolean']]);
        $item->update($input);

        return response()->json($item);
    }
}
