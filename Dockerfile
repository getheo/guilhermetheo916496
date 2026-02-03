FROM php:8.2-apache

# 1. Instala dependências do sistema e extensões PHP
RUN apt-get update && apt-get install -y \
    libpq-dev \
    postgresql-client \
    unzip \
    curl \
    gnupg \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# 2. Habilita o mod_rewrite do Apache
RUN a2enmod rewrite

# 3. Instala o Node.js 20.x de forma consolidada
# O segredo é rodar o update logo após o script do nodesource
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get update && \
    apt-get install -y nodejs npm && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# 4. Copia o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. VirtualHost
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html
COPY . .

# 7. Permissões
RUN chown -R www-data:www-data storage bootstrap/cache

# 8. Entrypoint
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]

EXPOSE 80