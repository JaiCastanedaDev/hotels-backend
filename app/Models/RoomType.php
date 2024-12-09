<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoomType extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'allowed_accommodations'];

    protected $casts = [
        'allowed_accommodations' => 'array',
    ];
}
