<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('room_allocations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
        $table->foreignId('room_type_id')->constrained()->onDelete('cascade');
        $table->string('accommodation'); // Sencilla, Doble, etc.
        $table->integer('quantity');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_allocations');
    }
};
