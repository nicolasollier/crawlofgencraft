<?php

namespace App\Services;

class PromptService
{
    private $roomTypes = ['encounter', 'trapped', 'treasure', 'enigma', 'empty'];

    public function getRoomDescriptionPrompt(string $type, ?string $player_action): string
    {
        $basePrompt = "Vous êtes un maître de donjon chargé de générer une description immersive pour une salle de donjon. ";
        $typePrompt = "La salle actuelle est de type : {$type}. ";
        $descriptionInstructions = "Créez une description détaillée et atmosphérique pour cette salle qui correspond à son type. A la fin de la description, indiquez 3 sorties vers la prochaine salle possible.";

        $rules = "Règles à suivre :
        1. La description doit correspondre au type de salle '{$type}'.
        2. Fournissez une description immersive qui reflète le type et le contenu de la salle.
        3. N'incluez pas d'actions ou de choix spécifiques pour le joueur dans la description. ";

        $playerActionPrompt = $player_action 
            ? "Prenez en compte l'action précédente du joueur : {$player_action}. Assurez-vous que la nouvelle salle offre une continuité logique avec cette action. "
            : "";

        $formatPrompt = "Générez une réponse JSON avec la structure suivante : {\"description\": \"text\"}. ";

        return $basePrompt . $typePrompt . $descriptionInstructions . $rules . $playerActionPrompt . $formatPrompt;
    }

    public function getRoomOptionsPrompt(string $type, string $description): string
    {
        $basePrompt = "Vous etes un outils chargé de générer 3 options courtes d'action basée sur des sorties d'une salle pour un joueur dans un donjon. Le joueur ne peut pas rebrousser chemin ou aller en arrière.";
        $typePrompt = "La salle actuelle est de type : {$type}. ";
        $descriptionPrompt = "Voici la description de la salle : {$description} ";
        $optionsInstructions = "Générez exactement quatre options courtes d'environ 4 mots pour le joueur. ";

        $rules = "Règles à suivre :
        1. Chaque option DOIT explicitement mentionner le déplacement vers une nouvelle salle ou zone.
        2. Les actions qui n'impliquent pas de déplacement vers une nouvelle salle sont strictement interdites.
        3. Ne soit pas créatif, les options doivent être courtes et concises. ";

        $examplePrompt = "Exemple d'options' :
        1. Franchir la porte pour entrer dans la salle suivante
        2. Emprunter le passage secret derrière la tapisserie menant à une nouvelle zone
        3. Descendre l'escalier en colimaçon vers le niveau inférieur
        4. Grimper par la fenêtre pour atteindre une tour adjacente ";

        $forbiddenActions = "Exemple d'actions interdites :
        1. Observer les détails de la salle
        2. Interagir avec les objets de la salle
        3. Examiner des détails dans la salle
        4. Ouvrir un coffre ";

        $formatPrompt = "Générez une réponse JSON avec la structure suivante : {\"options\": [\"option1\", \"option2\", \"option3\"]}. ";

        return $basePrompt . $typePrompt . $descriptionPrompt . $optionsInstructions . $rules . $examplePrompt . $forbiddenActions . $formatPrompt;
    }

    public function getValidRoomTypes(): array
    {
        return $this->roomTypes;
    }
}