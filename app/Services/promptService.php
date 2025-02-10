<?php

namespace App\Services;

class PromptService
{
    private $roomTypes = ['encounter', 'trapped', 'treasure', 'enigma', 'empty'];

    public function getRoomDescriptionPrompt(
        string $type,
        ?string $player_action,
        ?string $droppedItem,
        bool $is_success
    ): string {
        $basePrompt = "Vous êtes un maître de donjon d'un univers dark medieval fantasy chargé de générer une "
            .'description immersive pour une salle de donjon. Rappelez-vous que le joueur est un aventurier averti '
            ."et que l'échec fait partie de l'aventure. ";
        $typePrompt = "La salle actuelle est de type : {$type}.";
        $successPrompt = $is_success ? 'Le joueur a réussi cette pièce.' : 'Le joueur a échoué cette pièce.';
        $droppedItemPrompt = $droppedItem
            ? "Cette salle contient un objet spécial : {$droppedItem}. Intégrez naturellement cet objet dans la "
            ."description de la salle, en le plaçant de manière cohérente avec l'environnement."
            : '';
        $descriptionInstructions = 'Créez une description détaillée de cette salle qui correspond à son type. La '
            ."réussite ou l'échec du joueur doit obligatoirement influencer la description de manière positive ou "
            ."négative. Par exemple, si la salle est de type 'encounter', le joueur DOIT perdre ou gagner un "
            ."combat. Si c'est une salle 'trapped', le joueur DOIT éviter ou déclencher un piège qui le blessera. "
            ."N'indiquez pas de nombre précis de points de vie perdus ou gagnés. À la fin de la description, "
            ."mentionnez 3 sorties possibles vers la prochaine salle. Si la salle est de type 'exit', la "
            .'description doit être une description de la sortie du donjon le joueur à survécu à son aventure. Si '
            .'la salle est un playerLost le joueur doit mourrir dans cette pièce.';

        $rules = "Règles à suivre :
        1. La description doit correspondre au type de salle '{$type}'.
        2. Fournissez une description immersive qui reflète le type et le contenu de la salle.
        3. N'incluez pas d'actions ou de choix spécifiques pour le joueur dans la description. ";

        $playerActionPrompt = $player_action
            ? "Prenez en compte l'action précédente du joueur : {$player_action}. "
            .'Assurez-vous que la nouvelle salle offre une continuité logique avec cette action.'
            : '';

        $formatPrompt = 'Générez une réponse JSON avec la structure suivante : '
            .'{"description": "text"}. ';

        return $basePrompt.$typePrompt.$successPrompt.$droppedItemPrompt.$descriptionInstructions
            .$rules.$playerActionPrompt.$formatPrompt;
    }

    public function getRoomOptionsPrompt(string $type, string $description): string
    {
        $basePrompt = "Vous etes un outils chargé de générer 3 options courtes d'action basée sur des sorties d'une "
            .'salle pour un joueur dans un donjon. Le joueur ne peut pas rebrousser chemin ou aller en arrière.';
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

        $formatPrompt = 'Générez une réponse JSON avec la structure suivante : '
            .' {"options": ["option1", "option2", "option3"]}. ';

        return $basePrompt.$typePrompt.$descriptionPrompt.$optionsInstructions.$rules.$examplePrompt
            .$forbiddenActions.$formatPrompt;
    }

    public function getValidRoomTypes(): array
    {
        return $this->roomTypes;
    }
}
