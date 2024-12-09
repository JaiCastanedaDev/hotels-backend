<?php

namespace App\Http\Controllers;

use App\Models\RoomAllocation;
use App\Models\RoomType;
use App\Models\Hotel;
use Illuminate\Http\Request;

class RoomAllocationController extends Controller
{
    public function index(Hotel $hotel)
    {
        $allocations = $hotel->roomAllocations()->with('roomType')->get();
        return response()->json($allocations, 200);
    }

    public function store(Request $request, $hotelId)
{
    $validated = $request->validate([
        'allocations' => 'required|array|min:1',
        'allocations.*.room_type_id' => 'required|exists:room_types,id',
        'allocations.*.accommodation' => 'required|string',
        'allocations.*.quantity' => 'required|integer|min:1',
    ]);

    $hotel = Hotel::findOrFail($hotelId);
    $hotel->roomAllocations()->delete();


    $totalAssigned = array_sum(array_column($validated['allocations'], 'quantity'));

    if ($totalAssigned > $hotel->number_of_rooms) {
        return response()->json([
            'error' => 'La suma total de habitaciones asignadas excede la capacidad del hotel.',
        ], 422);
    }

    $allocationsCheck = [];
    foreach ($validated['allocations'] as $allocation) {
        $key = $allocation['room_type_id'] . '-' . $allocation['accommodation'];
        if (isset($allocationsCheck[$key])) {
            return response()->json([
                'error' => "Ya existe una asignación para el tipo de habitación '{$allocation['room_type_id']}' y la acomodación '{$allocation['accommodation']}'.",
            ], 422);
        }
        $allocationsCheck[$key] = true;
    }

    $existingAllocations = $hotel->roomAllocations()
        ->pluck('accommodation', 'room_type_id')
        ->toArray();

    foreach ($validated['allocations'] as $allocation) {
        if (isset($existingAllocations[$allocation['room_type_id']]) &&
            $existingAllocations[$allocation['room_type_id']] === $allocation['accommodation']) {
            $roomTypeName = RoomType::findOrFail($allocation['room_type_id'])->name;
            return response()->json([
                'error' => "El tipo de habitación '{$roomTypeName}' ya tiene la acomodación '{$allocation['accommodation']}' asignada.",
            ], 422);
        }
    }


    foreach ($validated['allocations'] as $allocation) {
        $hotel->roomAllocations()->create([
            'room_type_id' => $allocation['room_type_id'],
            'accommodation' => $allocation['accommodation'],
            'quantity' => $allocation['quantity'],
        ]);
    }

    return response()->json(['message' => 'Asignaciones guardadas exitosamente.']);
}


    public function update(Request $request, RoomAllocation $allocation)
    {
        $validated = $request->validate([
            'quantity' => 'sometimes|integer|min:1',
            'accommodation' => 'sometimes|string',
        ]);

        if (isset($validated['accommodation'])) {
            $roomType = $allocation->roomType;

            if (!in_array($validated['accommodation'], $roomType->allowed_accommodations)) {
                return response()->json([
                    'error' => 'Invalid accommodation for the selected room type.'
                ], 422);
            }
        }

        $allocation->update($validated);

        return response()->json($allocation, 200);
    }

    public function destroy(RoomAllocation $allocation)
    {
        $allocation->delete();
        return response()->json(null, 204);
    }
}
