<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

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
        $llmResponse = self::getLLMResponse($type, $dungeon);

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

    private static function getLLMResponse(string $type, Dungeon $dungeon)
    {
        $apiKey = config('services.openai.api_key');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
        ])->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'Tu es un maître de donjon qui génère des descriptions immersives et détaillées de salles pour un donjon dans un format structuré. Les descriptions doivent refléter les événements qui se produisent automatiquement en fonction du type de salle, sans offrir de choix au joueur. Soigne la description pour que le joueur puisse comprendre ce qui se passe dans la salle.'
                        ],
                        [
                            'role' => 'user',
                            'content' => "Génère une réponse JSON avec la structure suivante : {\"description\": \"text\", \"options\": [\"option1\", \"option2\", \"option3\"]}. Génère la description d'une salle de type: $type. La description doit inclure ce qui se passe automatiquement dans la salle, sans offrir de choix au joueur. Les options doivent uniquement concerner la décision à prendre pour accéder à la prochaine salle."
                        ]
                    ],
                ]);

        $llmResponse = $response->json();

        $content = json_decode($llmResponse['choices'][0]['message']['content'], true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Erreur lors du décodage de la réponse JSON : " . json_last_error_msg());
        }

        return [
            'description' => $content['description'],
            'options' => $content['options'],
        ];
    }

    private static function calculateHealthChange(string $type): int
    {
        switch ($type) {
            case 'encounter':
                return -rand(10, 20); // Le joueur perd entre 10 et 20 points de vie
            case 'trap':
                return -rand(5, 15); // Le joueur perd entre 5 et 15 points de vie
            case 'rest':
                return rand(10, 20); // Le joueur gagne entre 10 et 20 points de vie
            default:
                return 0; // Pas de changement de santé pour les autres types de salles
        }
    }

    private static function calculateItemChange(string $type): array
    {
        switch ($type) {
            case 'treasure':
                return ['gold' => rand(10, 50)]; // Le joueur gagne entre 10 et 50 pièces d'or
            case 'item':
                $items = ['potion', 'sword', 'shield', 'key'];
                return [$items[array_rand($items)] => 1]; // Le joueur obtient un objet aléatoire
            default:
                return []; // Pas de changement d'inventaire pour les autres types de salles
        }
    }
}
