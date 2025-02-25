<?php

namespace App\Models;

use App\Services\DropItemService;
use App\Services\OpenAIService;
use App\Services\PromptService;
use App\Services\RoomGeneratorService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['dungeon_id', 'room_number', 'type', 'description', 'options', 'is_success'];

    protected $casts = [
        'options' => 'array',
        'is_success' => 'boolean',
    ];

    public static function generate(string $type, Dungeon $dungeon, ?string $player_action, bool $is_success)
    {
        $promptService = new PromptService;
        $openAIService = new OpenAIService($promptService);
        $dropItemService = new DropItemService;
        $roomGeneratorService = new RoomGeneratorService($openAIService, $dropItemService);

        return $roomGeneratorService->generateRoom($type, $dungeon, $player_action, $is_success);
    }

    public function handleStatsChange(string $type, bool $is_success, int $character_id)
    {
        $character = Character::find($character_id);

        if (! $is_success) {
            $penalties = [
                'encounter' => ['hp' => 30],
                'trapped' => ['hp' => 30],
                'enigma' => ['mana' => 30],
            ];

            if (isset($penalties[$type])) {
                foreach ($penalties[$type] as $stat => $value) {
                    $character->$stat -= $value;
                }
            }
        }

        $character->hp = max(0, $character->hp);
        $character->mana = max(0, $character->mana);
        $character->save();
    }
}
