# Usando a imagem oficial do PHP com Apache
FROM php:8.2-apache

# Instalar extensões necessárias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql

# Habilitar o mod_rewrite do Apache
RUN a2enmod rewrite

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir diretório de trabalho
WORKDIR /var/www/html

# Copiar arquivos do Laravel
COPY . .

# Definir permissões
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

CMD ["php","artisan","serve","--host=0.0.0.0","--port=8000","php","artisan","migrate:fresh","php","artisan","db:seed","php","artisan","l5-swagger:generate"]

# Expor a porta 80
EXPOSE 80
