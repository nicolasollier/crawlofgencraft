<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenAIService
{
    private $apiKey;
    private $assistantId;
    private $headers;
    private $baseUrl = 'https://api.openai.com/v1';

    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key');
        $this->assistantId = config('services.openai.assistant_id');
        $this->headers = [
            'Authorization' => 'Bearer ' . $this->apiKey,
            'OpenAI-Beta' => 'assistants=v2',
            'Content-Type' => 'application/json',
        ];
    }

    public function generateRoomDescription(string $type, string $player_action = null): array
    {
        if($player_action) {
            $player_action = "La salle précédente le joueur a choisi l'option: $player_action.";
        };

        $prompt = "Génère une réponse JSON avec la structure suivante : {\"description\": \"text\", \"options\": [\"option1\", \"option2\", \"option3\"]}. Génère la description d'une salle de type: {$type}. La description doit inclure ce qui se passe automatiquement dans la salle, sans offrir de choix au joueur. Les options doivent uniquement concerner la prochaine direction à prendre. {$player_action}";

        $llmResponse = Http::withHeaders($this->headers)
            ->post("{$this->baseUrl}/chat/completions", [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => $prompt],
                ],
            ]);

        $llmResponse = $llmResponse->json();

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