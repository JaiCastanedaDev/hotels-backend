<?php

namespace App\Http\Controllers;

use App\Models\RoomType;

class RoomTypeController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::all();
        return response()->json($roomTypes, 200);
    }
}
