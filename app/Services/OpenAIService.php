<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;

class OpenAIService
{
    public function generateRoomDescription(string $type, string $player_action = null): array
    {
        if ($player_action) {
            $player_action = "La salle précédente le joueur a choisi l'option: $player_action.";
        }

        $prompt = "Génère une réponse JSON avec la structure suivante : {\"description\": \"text\", \"options\": [\"option1\", \"option2\", \"option3\"]}. Génère la description d'une salle de type: {$type}. La description doit inclure ce qui se passe automatiquement dans la salle, sans offrir de choix au joueur. Les options doivent uniquement concerner la prochaine direction à prendre. {$player_action}";

        $result = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => $prompt],
            ],
        ]);

        $content = json_decode($result->choices[0]->message->content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Erreur lors du décodage de la réponse JSON : " . json_last_error_msg());
        }

        return [
            'description' => $content['description'],
            'options' => $content['options'],
        ];
    }
}
