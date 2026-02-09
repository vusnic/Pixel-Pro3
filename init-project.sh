#!/bin/bash

echo "🚀 Inicializando projeto PixelPro3..."

echo "📦 Instalando dependências PHP..."
composer install --no-interaction --prefer-dist --optimize-autoloader

echo "📦 Instalando dependências Node.js..."
npm install

echo "🔑 Gerando chave da aplicação..."
php artisan key:generate --force

echo "🗄️ Executando migrations..."
php artisan migrate --force

echo "🌱 Executando seeders..."
php artisan db:seed --force

echo "🔗 Criando link simbólico do storage..."
php artisan storage:link

echo "🎨 Compilando assets..."
npm run build

echo "✅ Projeto inicializado com sucesso!"
