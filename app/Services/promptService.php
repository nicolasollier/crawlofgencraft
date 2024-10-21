<?php

namespace App\Services;

class PromptService
{
    private $roomTypes = ['encounter', 'trapped', 'treasure', 'enigma', 'empty'];

    public function getRoomDescriptionPrompt(string $type, ?string $player_action): string
    {
        $basePrompt = "Vous êtes un maître de donjon chargé de générer une description immersive pour une salle de donjon. ";
        $typePrompt = "La salle actuelle est de type : {$type}. ";
        $descriptionInstructions = "Créez une description détaillée et atmosphérique pour cette salle qui correspond à son type. Incluez des détails sensoriels et des éléments qui suggèrent des possibilités d'action sans les expliciter. ";

        $rules = "Règles à suivre :
        1. La description doit correspondre au type de salle '{$type}'.
        2. Fournissez une description immersive qui reflète le type et le contenu de la salle.
        3. N'incluez pas d'actions ou de choix spécifiques pour le joueur dans la description.
        4. Concentrez-vous sur l'ambiance, les détails visuels, les sons, les odeurs, et l'atmosphère générale. ";

        $playerActionPrompt = $player_action 
            ? "Prenez en compte l'action précédente du joueur : {$player_action}. Assurez-vous que la nouvelle salle offre une continuité logique avec cette action. "
            : "";

        $formatPrompt = "Générez une réponse JSON avec la structure suivante : {\"description\": \"text\"}. ";

        return $basePrompt . $typePrompt . $descriptionInstructions . $rules . $playerActionPrompt . $formatPrompt;
    }

    public function getRoomOptionsPrompt(string $type, string $description): string
    {
        $basePrompt = "Vous êtes un maître de donjon chargé de générer des options courtes d'action pour un joueur dans une salle de donjon. ";
        $typePrompt = "La salle actuelle est de type : {$type}. ";
        $descriptionPrompt = "Voici la description de la salle : {$description} ";
        $optionsInstructions = "Générez exactement quatre options courtes d'environ 4 mots pour le joueur. ";

        $rules = "Règles à suivre :
        1. Chaque option DOIT explicitement mentionner le déplacement vers une nouvelle salle ou zone.
        2. Les actions qui n'impliquent pas de déplacement vers une nouvelle salle sont strictement interdites.
        3. Les options doivent être cohérentes avec le type de salle et surtout ce que le joueur à pu lire dans la description.
        4. Soyez créatif mais concis dans les options proposées. N'indique pas les points cardinaux ou les directions. ";

        $examplePrompt = "Exemple de structure :
        1. Franchir la porte pour entrer dans la salle suivante
        2. Emprunter le passage secret derrière la tapisserie menant à une nouvelle zone
        3. Descendre l'escalier en colimaçon vers le niveau inférieur
        4. Grimper par la fenêtre pour atteindre une tour adjacente ";

        $forbiddenActions = "Exemple d'actions interdites :
        1. Observer les détails de la salle
        2. Interagir avec les objets de la salle
        3. Examiner à la recherche d'objets dans la salle
        4. Ouvrir le coffre";

        $formatPrompt = "Générez une réponse JSON avec la structure suivante : {\"options\": [\"option1\", \"option2\", \"option3\", \"option4\"]}. ";

        return $basePrompt . $typePrompt . $descriptionPrompt . $optionsInstructions . $rules . $examplePrompt . $forbiddenActions . $formatPrompt;
    }

    public function getValidRoomTypes(): array
    {
        return $this->roomTypes;
    }
}