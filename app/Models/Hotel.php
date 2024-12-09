<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RoomAllocation;

class Hotel extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'address', 'city', 'nit', 'number_of_rooms'];

    public function roomAllocations()
    {
        return $this->hasMany(RoomAllocation::class);
    }
}
