<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Hotel;


class RoomAllocation extends Model
{
    use HasFactory;
    protected $fillable = ['hotel_id', 'room_type_id', 'accommodation', 'quantity'];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }
}
