FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    netcat-traditional \
    libzip-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./
COPY package.json package-lock.json ./
COPY .env.example .env

RUN composer install --no-scripts --no-autoloader
RUN npm ci

COPY . .

RUN composer dump-autoload
RUN php artisan key:generate
RUN npm run build

COPY docker/docker-init.sh /usr/local/bin/docker-init.sh
RUN chmod +x /usr/local/bin/docker-init.sh

CMD ["/usr/local/bin/docker-init.sh"]
