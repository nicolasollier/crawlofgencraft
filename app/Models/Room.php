<?php

namespace App\Models;

use App\Services\OpenAIService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\PromptService;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['dungeon_id', 'room_number', 'type', 'description', 'options', 'is_success'];

    protected $casts = [
        'options' => 'array',
        'is_success' => 'boolean',
    ];

    public static function generate(string $type, Dungeon $dungeon, string $player_action = null, bool $is_success)
    {
        $promptService = new PromptService();
        $openAIService = new OpenAIService($promptService);

        $description = $openAIService->generateRoomDescription($type, $player_action, $is_success);

        if ($type !== 'exit') {
            $options = $openAIService->generateRoomOptions($type, $description['description']);
        } else {
            $options = ['options' => ['Sortir du donjon']];
        }

        return new self([
            'dungeon_id' => $dungeon->id,
            'room_number' => $dungeon->room_count + 1,
            'type' => $type,
            'description' => $description['description'],
            'options' => $options['options'],
            'is_success' => $is_success,
        ]);
    }

    public function handleHealthChange(string $type, bool $is_success, int $character_id)
    {
        $character = Character::find($character_id);

        if (!$is_success) {
            switch ($type) {
                case 'encounter':
                    $character->hp -= 10;
                    break;
                case 'trapped':
                    $character->hp -= 20;
                    break;
            }
        }

        $character->hp = max(0, $character->hp);
        $character->save();
    }
}
