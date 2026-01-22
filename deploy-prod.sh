#!/bin/bash

# Script para preparar o projeto para deploy em produção

echo "Preparando configurações para ambiente de produção..."

# Backup da configuração atual do Nginx
cp docker/nginx/laravel.conf docker/nginx/laravel.conf.bak

# Criar configuração otimizada para produção
cat > docker/nginx/laravel.conf << 'EOL'
server {
    listen 80;
    server_name pxp3.com www.pxp3.com;
    root /var/www/pixelpro3/public;
 
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    add_header X-XSS-Protection "1; mode=block";
 
    index index.php;
 
    charset utf-8;
 
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
 
    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }
 
    error_page 404 /index.php;
 
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_buffer_size 16k;
        fastcgi_buffers 4 16k;
    }
 
    location ~ /\.(?!well-known).* {
        deny all;
    }
    
    # Configurações de cache para arquivos estáticos
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|webp|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, no-transform";
        access_log off;
    }
    
    # Gzip compression
    gzip on;
    gzip_comp_level 5;
    gzip_min_length 256;
    gzip_proxied any;
    gzip_vary on;
    gzip_types
        application/atom+xml
        application/javascript
        application/json
        application/ld+json
        application/manifest+json
        application/rss+xml
        application/vnd.geo+json
        application/vnd.ms-fontobject
        application/x-font-ttf
        application/x-web-app-manifest+json
        application/xhtml+xml
        application/xml
        font/opentype
        image/bmp
        image/svg+xml
        image/x-icon
        text/cache-manifest
        text/css
        text/plain
        text/vcard
        text/vnd.rim.location.xloc
        text/vtt
        text/x-component
        text/x-cross-domain-policy;
}
EOL

echo "Configuração de produção criada."
echo "Execute ./restore-dev.sh para restaurar a configuração de desenvolvimento."

# Aqui você pode adicionar mais etapas de preparação para produção, como:
# - Otimização do .env
# - Compilação de assets com npm run build
# - Etc. 