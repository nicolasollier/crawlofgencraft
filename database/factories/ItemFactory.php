<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item;

class ItemFactory extends Factory
{
    public function definition(): array
    {
        $itemType = $this->faker->randomElement(['weapon', 'armor', 'misc']);
        
        $itemData = $this->getItemData($itemType);

        return [
            'name' => $itemData['name'],
            'description' => $itemData['description'],
            'item_type' => $itemType,
            'damage_bonus' => $itemData['damageBonus'] ?? 0,
            'armor_bonus' => $itemData['armorBonus'] ?? 0,
            'value' => $this->faker->numberBetween(10, 500),
        ];
    }

    private function getItemData($itemType): array
    {
        $data = [
            'name' => 'Objet Inconnu',
            'description' => 'Un objet mystérieux.',
            'damageBonus' => 0,
            'armorBonus' => 0,
        ];

        switch ($itemType) {
            case 'weapon':
                $data['name'] = $this->faker->randomElement([
                    'Épée de l\'Aube Écarlate', 
                    'Arc Long Elfique', 
                    'Hache du Berserker', 
                    'Dague des Ombres', 
                    'Marteau de Guerre du Tonnerre'
                ]) ?: 'Arme Générique';
                $data['description'] = $this->faker->randomElement([
                    'Une arme finement ouvragée des temps anciens.', 
                    'Forgée dans le feu du dragon, elle luit faiblement dans l\'obscurité.', 
                    'Une arme mortelle maniée par les plus grands guerriers.',
                    'Une arme légère, parfaite pour les attaques furtives.',
                    'Un énorme marteau crépitant d\'énergie foudroyante.'
                ]) ?: 'Une arme standard.';
                $data['damageBonus'] = $this->faker->numberBetween(5, 20);
                break;

            case 'armor':
                $data['name'] = $this->faker->randomElement([
                    'Cuirasse d\'Acier', 
                    'Cotte de Mailles Elfique', 
                    'Bouclier en Peau de Dragon', 
                    'Armure de Cuir du Voleur', 
                    'Armure de Plates du Paladin'
                ]) ?: 'Armure Générique';
                $data['description'] = $this->faker->randomElement([
                    'Une pièce d\'armure solide offrant une forte défense.', 
                    'Légère et flexible, idéale pour des mouvements rapides.', 
                    'Ce bouclier est connu pour résister aux coups les plus puissants.', 
                    'Une armure légère, parfaite pour se fondre dans les ombres.', 
                    'Une armure sacrée, bénie par les dieux pour les justes.'
                ]) ?: 'Une pièce d\'armure standard.';
                $data['armorBonus'] = $this->faker->numberBetween(5, 20);
                break;

            case 'misc':
                $data['name'] = $this->faker->randomElement([
                    'Potion de Guérison', 
                    'Parchemin de Boule de Feu', 
                    'Anneau d\'Invisibilité', 
                    'Sac sans Fond', 
                    'Gemme de Vision Véritable'
                ]) ?: 'Objet Divers Générique';
                $data['description'] = $this->faker->randomElement([
                    'Une potion magique qui restaure la santé.', 
                    'Un parchemin inscrit d\'un ancien sort de feu.', 
                    'Un anneau mystique qui rend son porteur invisible.', 
                    'Un sac enchanté capable de contenir une quantité immense d\'objets.', 
                    'Une gemme qui révèle les vérités cachées et les illusions.'
                ]) ?: 'Un objet divers mystérieux.';
                break;
        }

        return $data;
    }
}