<?php

namespace App\Services;

use App\Models\Dungeon;
use App\Models\Room;

class DungeonProgressionService
{
    private array $size_map = [
        'small' => 10,
        'medium' => 25,
        'large' => 50,
    ];

    public function progressDungeon(Dungeon $dungeon, string $player_action): void
    {
        $dungeon->room_count++;
        $max_rooms = $this->size_map[$dungeon->size] ?? 10;

        if ($dungeon->character->hp <= 0) {
            $this->createRoom('playerLost', $dungeon, $player_action, false);
        } elseif ($dungeon->room_count >= $max_rooms) {
            $this->createRoom('exit', $dungeon, $player_action, true);
        } else {
            $this->generateRandomRoom($dungeon, $player_action);
        }

        $dungeon->save();
    }

    private function createRoom(string $type, Dungeon $dungeon, string $player_action, bool $is_success): void
    {
        $room = Room::generate($type, $dungeon, $player_action, $is_success);
        $dungeon->rooms()->save($room);
    }

    private function generateRandomRoom(Dungeon $dungeon, string $player_action): void
    {
        if ($dungeon->room_count >= $dungeon->rooms->count()) {
            $room_types = ['encounter', 'trapped', 'treasure', 'enigma', 'empty'];
            $random_room_type = $room_types[array_rand($room_types)];
            $roomIsSuccess = rand(1, 100) <= 50;

            $room = Room::generate($random_room_type, $dungeon, $player_action, $roomIsSuccess);
            $room->handleStatsChange($random_room_type, $roomIsSuccess, $dungeon->character_id);

            $dungeon->rooms()->save($room);
        }
    }
}
