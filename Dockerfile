FROM php:8.4-fpm

# set your user name, ex: user=carlos
ARG user=pixelpro3
ARG uid=1000

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Install redis
RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

# Criar diretórios necessários para o sistema de contratos
RUN mkdir -p /var/www/storage/app/contracts/templates \
    && mkdir -p /var/www/storage/app/contracts/generated \
    && mkdir -p /var/www/tmp/docx_debug \
    && chmod -R 777 /var/www/storage \
    && chmod -R 777 /var/www/tmp

# Set working directory
WORKDIR /var/www

# Copy custom configurations PHP
COPY docker/php/custom.ini /usr/local/etc/php/conf.d/custom.ini

# Configurar permissões iniciais para diretórios importantes
RUN chmod -R 775 /var/www/storage/app 2>/dev/null || true

# Comando executado quando o container é iniciado
CMD bash -c "chown -R www-data:www-data /var/www/storage \
    && chmod -R 777 /var/www/storage/app/contracts \
    && chmod -R 777 /var/www/tmp \
    && php-fpm"

USER $user