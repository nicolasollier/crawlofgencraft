<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenAIService
{
    public function generateRoomDescription(string $type): array
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
                    'content' => "Génère une réponse JSON avec la structure suivante : {\"description\": \"text\", \"options\": [\"option1\", \"option2\", \"option3\"]}. Génère la description d'une salle de type: $type. La description doit inclure ce qui se passe automatiquement dans la salle, sans offrir de choix au joueur. Les options doivent uniquement concerner la prochaine direction à prendre."
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
}