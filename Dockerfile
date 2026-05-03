FROM php:8.2-apache

# Instalar extensões PHP necessárias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_mysql mbstring zip gd xml \
    && a2enmod rewrite

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar diretório da aplicação
WORKDIR /var/www/html

# Copiar arquivos da aplicação
COPY . .

# Instalar dependências PHP
RUN composer install --no-dev --optimize-autoloader

# Configurar permissões
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Configurar Apache para apontar para public/
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
    && sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Gerar chave da aplicação (será sobrescrita por variável de ambiente)
RUN php artisan key:generate --no-interaction || true

# Limpar cache e otimizar
RUN php artisan config:cache || true \
    && php artisan route:cache || true

# Expor porta 80
EXPOSE 80

# Iniciar Apache
CMD ["apache2-foreground"]
