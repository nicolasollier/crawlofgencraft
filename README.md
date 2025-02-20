
![preview](https://github.com/user-attachments/assets/c5fa8f6d-1742-470f-9949-bde9bcf8d22e)



## À propos de Crawl of Gencraft

Crawl of Gencraft est un jeu d'aventure textuel unique où chaque donjon est généré dynamiquement par l'intelligence artificielle. Le jeu combine :

- Un système de génération de donjons par IA
- Une gestion d'inventaire et de marchand
- Des combats au tour par tour
- Une personnalisation poussée des personnages
- Une expérience narrative unique à chaque partie

## Fonctionnalités principales

- **Donjons générés par IA** : Chaque salle, monstre et trésor est créé dynamiquement
- **Système d'alignement** : 9 alignements différents influençant l'histoire
- **Gestion d'équipement** : Large variété d'armes et d'armures
- **Système de commerce** : Interaction avec un marchand pour acheter/vendre
- **Progression de personnage** : Statistiques et équipement évolutifs

## Prérequis techniques

- PHP 8.3
- Composer
- Node.js & NPM
- Une clé API OpenAI valide

## Installation

1. Clonez le repository
2. Générez une clef d'app avec `php artisan key:generate`
2. Installez les dépendances avec `composer install && npm install`
4. Exécutez les migrations avec `php artisan migrate && php artisan db:seed`
5. Démarrez le serveur backend avec `php artisan serve`
6. Démarrez le serveur frontend avec `npm run dev`
