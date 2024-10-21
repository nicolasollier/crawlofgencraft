<?php

namespace App\Models;

use App\Services\OpenAIService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\PromptService;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['dungeon_id', 'room_number', 'type', 'description', 'options'];

    protected $casts = [
        'options' => 'array',
    ];

    public static function generate(string $type, Dungeon $dungeon, string $player_action = null)
    {
        $promptService = new PromptService();
        $openAIService = new OpenAIService($promptService);

        $description = $openAIService->generateRoomDescription($type, $player_action);
        $options = $openAIService->generateRoomOptions($type, $description['description']);

        return new self([
            'dungeon_id' => $dungeon->id,
            'room_number' => $dungeon->room_count + 1,
            'type' => $type,
            'description' => $description['description'],
            'options' => $options['options'],
        ]);
    }
}
