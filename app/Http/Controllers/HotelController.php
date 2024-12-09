<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::all();
        return response()->json($hotels, 200);
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|unique:hotels',
        'nit' => 'required|unique:hotels',
        'address' => 'required',
        'city' => 'required',
        'number_of_rooms' => 'required|integer',
    ]);

    $hotel = Hotel::create($validated);

    return response()->json($hotel, 201);
}


    public function show(Hotel $hotel)
    {
        return response()->json($hotel, 200);
    }

    public function update(Request $request, Hotel $hotel)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'address' => 'sometimes|string|max:255',
            'city' => 'sometimes|string|max:255',
            'nit' => 'sometimes|string|max:20|unique:hotels,nit,' . $hotel->id,
            'number_of_rooms' => 'sometimes|integer|min:1',
        ]);

        $hotel->update($validated);

        return response()->json($hotel, 200);
    }

    public function destroy(Hotel $hotel)
    {
        $hotel->delete();
        return response()->json(null, 204);
    }
}
