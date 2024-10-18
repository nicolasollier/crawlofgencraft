<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['dungeon_id', 'room_number', 'type', 'description', 'options', 'health_change'];

    protected $casts = [
        'options' => 'array',
        'item_change' => 'array',
    ];

    public static function generate(string $type, Dungeon $dungeon)
    {
        $llmResponse = self::getLLMResponse($type, $dungeon);

        return new self([
            'dungeon_id' => $dungeon->id,
            'room_number' => $dungeon->room_count + 1,
            'type' => $type,
            'description' => $llmResponse['description'],
            'options' => $llmResponse['options'],
            'health_change' => $llmResponse['health_change'],
        ]);
    }

    private static function getLLMResponse(string $type, Dungeon $dungeon)
    {
        // Here we would call the LLM for now we return a placeholder response
        return [
            'description' => "Vous entrez dans une salle mystérieuse. Les murs sont couverts de symboles anciens et une légère brume flotte dans l'air.",
            'options' => ['Examiner les symboles', 'Avancer prudemment', 'Retourner en arrière'],
            'health_change' => 0,
        ];
    }
}
