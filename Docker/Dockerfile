# 1. Base estable basada en Debian Bookworm
FROM php:8.3-fpm-bookworm

# 2. Variables de entorno
ENV DEBIAN_FRONTEND=noninteractive \
    PHP_OPCACHE_VALIDATE_TIMESTAMPS=0 \
    COMPOSER_ALLOW_SUPERUSER=1

# 3. Instalación de dependencias del sistema y herramientas de Microsoft
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxslt1-dev \
    acl \
    curl \
    gnupg2 \
    ca-certificates \
    # Repositorio de Microsoft para drivers SQL Server (Debian 12)
    && curl https://packages.microsoft.com/keys/microsoft.asc | gpg --dearmor > /usr/share/keyrings/microsoft-archive-keyring.gpg \
    && echo "deb [arch=amd64,arm64,armhf signed-by=/usr/share/keyrings/microsoft-archive-keyring.gpg] https://packages.microsoft.com/debian/12/prod bookworm main" > /etc/apt/sources.list.d/mssql-release.list \
    && apt-get update \
    && ACCEPT_EULA=Y apt-get install -y msodbcsql18 mssql-tools18 unixodbc-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 4. Instalación de extensiones PHP y Drivers SQL Server
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        intl \
        pdo_mysql \
        zip \
        gd \
        opcache \
        xsl \
        mbstring \
    # Instalación de drivers SQL Server compatibles con PHP 8.3
    && pecl install sqlsrv pdo_sqlsrv \
    && docker-php-ext-enable sqlsrv pdo_sqlsrv
# 5. Configuración de OPcache
RUN { \
    echo 'opcache.enable=1'; \
    echo 'opcache.enable_cli=1'; \
    echo 'opcache.memory_consumption=256'; \
    echo 'opcache.interned_strings_buffer=16'; \
    echo 'opcache.max_accelerated_files=20000'; \
    echo 'opcache.revalidate_freq=0'; \
    echo 'opcache.validate_timestamps=1'; \
    echo 'opcache.fast_shutdown=1'; \
    } > /usr/local/etc/php/conf.d/opcache-optimized.ini

# 6. INSTALAR COMPOSER
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# 7. INSTALAR SYMFONY CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

# 8. Directorio de trabajo y permisos
WORKDIR /var/www/symfony

# Agregamos mssql-tools al PATH para poder usar herramientas de comandos si es necesario
ENV PATH="$PATH:/opt/mssql-tools18/bin"

RUN chown -R www-data:www-data /var/www/symfony

USER www-data

EXPOSE 9000

CMD ["php-fpm"]