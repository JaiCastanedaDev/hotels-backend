<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\RoomAllocationController;

Route::prefix('hotels')->group(function () {
    Route::get('/', [HotelController::class, 'index']);
    Route::post('/', [HotelController::class, 'store']);
    Route::get('/{hotel}', [HotelController::class, 'show']);
    Route::put('/{hotel}', [HotelController::class, 'update']);
    Route::delete('/{hotel}', [HotelController::class, 'destroy']);
});

Route::prefix('room-types')->group(function () {
    Route::get('/', [RoomTypeController::class, 'index']);
});

Route::prefix('room-allocations')->group(function () {
    Route::get('/{hotel}', [RoomAllocationController::class, 'index']);
    Route::post('/{hotel}', [RoomAllocationController::class, 'store']);
    Route::put('/{allocation}', [RoomAllocationController::class, 'update']);
    Route::delete('/{allocation}', [RoomAllocationController::class, 'destroy']);
});
