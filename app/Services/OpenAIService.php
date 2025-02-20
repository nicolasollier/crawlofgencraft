<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Auth;

class OpenAIService
{
    private $promptService;
    private $client;

    public function __construct(PromptService $promptService)
    {
        $this->promptService = $promptService;
        $this->initializeClient();
    }

    private function initializeClient()
    {
        if (!Auth::check()) {
            throw new \Exception('Utilisateur non authentifié');
        }

        $apiKey = Auth::user()->openai_api_key;
        if (empty($apiKey)) {
            throw new \Exception('Clé API OpenAI non configurée');
        }

        config(['openai.api_key' => $apiKey]);
    }

    public function generateRoomDescription(
        string $type,
        ?string $player_action,
        bool $is_success,
        ?string $droppedItem = null,
    ): array {
        if ($player_action) {
            $player_action = "La salle précédente le joueur a choisi l'option: $player_action.";
        }

        $prompt = $this->promptService->getRoomDescriptionPrompt($type, $player_action, $droppedItem, $is_success);

        $result = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => $prompt],
            ],
        ]);

        $content = json_decode($result->choices[0]->message->content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Erreur lors du décodage de la réponse JSON : '.json_last_error_msg());
        }

        return [
            'description' => $content['description'],
        ];
    }

    public function generateRoomOptions(string $type, string $description): array
    {
        $prompt = $this->promptService->getRoomOptionsPrompt($type, $description);

        $result = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => $prompt],
            ],
        ]);

        $content = json_decode($result->choices[0]->message->content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Erreur lors du décodage de la réponse JSON : '.json_last_error_msg());
        }

        return [
            'options' => $content['options'],
        ];
    }
}
