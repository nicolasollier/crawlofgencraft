#!/bin/bash

echo "🔄 Vérification de la connexion MySQL..."
until nc -z -v -w30 mysql 3306
do
  echo "⏳ En attente de la connexion MySQL... Un peu de patience !"
  sleep 1
done
echo "✅ MySQL est prêt et opérationnel !"

echo "📦 Installation des dépendances PHP avec Composer..."
composer install
echo "📦 Installation des dépendances Node.js..."
npm install
echo "🔨 Construction des assets..."
npm run build

echo "🔑 Génération de la clé d'application..."
php artisan key:generate
echo "🗄️ Migration de la base de données..."
php artisan migrate --force
echo "🔗 Création des liens symboliques pour le stockage..."
php artisan storage:link

echo "🚀 Démarrage du serveur Laravel..."
php artisan serve --host=0.0.0.0 --port=8000