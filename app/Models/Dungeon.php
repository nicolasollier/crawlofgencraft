<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dungeon extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'size', 'room_count'];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function character()
    {
        return $this->belongsTo(Character::class);
    }
}
