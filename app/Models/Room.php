<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['dungeon_id', 'room_number', 'room_type', 'description', 'options', 'item_change', 'health_change'];

    protected $casts = [
        'options' => 'array',
        'item_change' => 'array',
    ];
}
