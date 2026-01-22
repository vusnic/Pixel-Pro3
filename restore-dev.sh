#!/bin/bash

# Script para restaurar o projeto para ambiente de desenvolvimento

echo "Restaurando configurações para ambiente de desenvolvimento..."

# Verificar se existe o backup da configuração do Nginx
if [ -f docker/nginx/laravel.conf.bak ]; then
    # Restaurar do backup
    cp docker/nginx/laravel.conf.bak docker/nginx/laravel.conf
    echo "Configuração do Nginx restaurada do backup."
else
    # Criar configuração padrão para desenvolvimento
    cat > docker/nginx/laravel.conf << 'EOL'
server {
    listen 80;
    index index.php;
    root /var/www/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    add_header X-XSS-Protection "1; mode=block";

    client_max_body_size 51g;
    client_body_buffer_size 512k;
    client_body_in_file_only clean;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
        gzip_static on;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass app:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param PATH_INFO $fastcgi_path_info;
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

    error_log  /var/log/nginx/error.log;
    access_log /var/log/nginx/access.log;
}
EOL
    echo "Configuração do Nginx restaurada para desenvolvimento."
fi

echo "Ambiente de desenvolvimento restaurado."

# Aqui você pode adicionar mais etapas de restauração para desenvolvimento, como:
# - Restaurar .env.example
# - Etc. 