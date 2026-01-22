#!/bin/bash

# Script to start the development environment

# Check if the Nginx config file for dev exists
if [ ! -f docker/nginx/dev/laravel.conf ]; then
    echo "Error: Nginx configuration file for development not found."
    exit 1
fi

# Create symbolic link for Nginx configuration
ln -sf dev/laravel.conf docker/nginx/laravel.conf

# Start development containers
docker compose -f docker-compose.dev.yml up

echo "Development environment started!" 