#!/bin/bash

# Script to start the production environment

# Check if the Nginx config file for prod exists
if [ ! -f docker/nginx/prod/laravel.conf ]; then
    echo "Error: Nginx configuration file for production not found."
    exit 1
fi

# Create symbolic link for Nginx configuration
ln -sf prod/laravel.conf docker/nginx/laravel.conf

# Start production containers in detached mode
echo "Starting Docker containers..."
cp docker-compose.prod.yml docker-compose.yml
docker-compose up

echo "Production environment started!" 