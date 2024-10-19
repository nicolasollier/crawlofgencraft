<?php

namespace App\Models;

use App\Services\OpenAIService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['dungeon_id', 'room_number', 'type', 'description', 'options', 'health_change', 'item_change'];

    protected $casts = [
        'options' => 'array',
        'item_change' => 'array',
    ];

    public static function generate(string $type, Dungeon $dungeon)
    {
        $openAIService = new OpenAIService();
        $llmResponse = $openAIService->generateRoomDescription($type);

        $healthChange = self::calculateHealthChange($type);
        $itemChange = self::calculateItemChange($type);

        return new self([
            'dungeon_id' => $dungeon->id,
            'room_number' => $dungeon->room_count + 1,
            'type' => $type,
            'description' => $llmResponse['description'],
            'options' => $llmResponse['options'],
            'health_change' => $healthChange,
            'item_change' => $itemChange,
        ]);
    }

    private static function calculateHealthChange(string $type): int
    {
        switch ($type) {
            case 'encounter':
                return -rand(10, 20);
            case 'trapped':
                return -rand(5, 15);
            default:
                return 0;
        }
    }

    private static function calculateItemChange(string $type): array
    {
        switch ($type) {
            case 'treasure':
                return ['gold' => rand(10, 50)];
            default:
                return [];
        }
    }
}
