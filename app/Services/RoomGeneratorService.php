<?php

namespace App\Services;

use App\Models\Dungeon;
use App\Models\Room;

class RoomGeneratorService
{
    public function __construct(
        private OpenAIService $openAIService,
        private DropItemService $dropItemService
    ) {
    }

    public function generateRoom(string $type, Dungeon $dungeon, ?string $player_action, bool $is_success): Room
    {
        if ($type === 'playerLost') {
            $description = $this->openAIService->generateRoomDescription($type, $player_action, true);
            $options = ['options' => ['Recommencer']];
        } elseif ($type === 'treasure' && $is_success) {
            $droppedItem = $this->dropItemService->dropItem($is_success);
            $description = $this->openAIService->generateRoomDescription($type, $player_action, true, $droppedItem);

            if ($droppedItem) {
                $character = $dungeon->character;
                $character->inventory()->create([
                    'item_id' => $droppedItem->id,
                    'equipped' => false,
                ]);
            }

            $options = $this->openAIService->generateRoomOptions($type, $description['description']);
        } elseif ($type === 'exit') {
            $description = $this->openAIService->generateRoomDescription($type, $player_action, true);
            $options = ['options' => ['Sortir du donjon']];
        } else {
            $description = $this->openAIService->generateRoomDescription($type, $player_action, $is_success);
            $options = $this->openAIService->generateRoomOptions($type, $description['description']);
        }

        return new Room([
            'dungeon_id' => $dungeon->id,
            'room_number' => $dungeon->room_count + 1,
            'type' => $type,
            'description' => $description['description'],
            'options' => $options['options'],
            'is_success' => $is_success,
        ]);
    }
}
