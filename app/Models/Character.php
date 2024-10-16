<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'hp',
        'mana',
        'gold',
        'strength',
        'agility',
        'intelligence',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }
}
