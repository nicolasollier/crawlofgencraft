<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'item_type',
        'damage_bonus',
        'armor_bonus',
        'value',
        'rarity',
    ];

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }
}
