FROM php:8.2-fpm

# Установка системных зависимостей для PHP-расширений
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libicu-dev \
    libcurl4-openssl-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pdo_mysql mbstring gd zip xml curl bcmath intl opcache exif \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Установка Composer прямо в образ приложения
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Настройка рабочего директории
WORKDIR /var/www

# Настройка прав
RUN chown -R www-data:www-data /var/www