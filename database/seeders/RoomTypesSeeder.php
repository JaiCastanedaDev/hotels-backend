<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


namespace Database\Seeders;


class RoomTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('room_types')->insert([
            [
                'id' => 1,
                'name' => "Estandar",
                'allowed_accommodations' => ["sencilla", "doble"],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'=> 2,
                'name'=> 'Junior',
                'allowed_accommodations' => ["sencilla", "doble", "triple"],
                "created_at"=> Carbon::now(),
                "updated_at"=> Carbon::now(),
            ],
            [
                "id"=> 3,
                'name'=> 'Suite',
                'allowed_accommodations'=> ["sencilla", "doble", "triple"],
                "created_at"=> Carbon::now(),
                "updated_at"=> Carbon::now(),
            ],
        ]);
    }
}