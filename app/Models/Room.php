<?php

namespace App\Models;

use App\Services\DropItemService;
use App\Services\OpenAIService;
use App\Services\PromptService;
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

        if ($type === 'playerLost') {
            $description = $openAIService->generateRoomDescription($type, $player_action, true);
            $options = ['options' => ['Recommencer']];
        } elseif ($type === 'treasure' && $is_success) {
            $droppedItem = $dropItemService->dropItem($is_success);
            $description = $openAIService->generateRoomDescription($type, $player_action, true, $droppedItem);

            if ($droppedItem) {
                $character = $dungeon->character;
                $character->inventory()->create([
                    'item_id' => $droppedItem->id,
                    'equipped' => false,
                ]);
            }

            $options = $openAIService->generateRoomOptions($type, $description['description']);
        } elseif ($type === 'exit') {
            $description = $openAIService->generateRoomDescription($type, $player_action, true);
            $options = ['options' => ['Sortir du donjon']];
        } else {
            $description = $openAIService->generateRoomDescription($type, $player_action, $is_success);
            $options = $openAIService->generateRoomOptions($type, $description['description']);
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
