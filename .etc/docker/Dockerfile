FROM php:8.0.12-fpm-bullseye

ARG HOST_SRC_DIR=.
ARG DOCKER_DIRECTORY=./.etc/docker
ARG WORKING_DIRECTORY=/var/www/html/
ARG USER_ID=1000
ARG GROUP_ID=1000
ARG USERNAME=www
ARG GROUP=www

# PHP Opcache
ARG PHP_OPCACHE_VALIDATE_TIMESTAMPS
ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS=${PHP_OPCACHE_VALIDATE_TIMESTAMPS} \
    PHP_OPCACHE_MAX_ACCELERATED_FILES="16000" \
    PHP_OPCACHE_MEMORY_CONSUMPTION="512" \
    PHP_OPCACHE_MAX_WASTED_PERCENTAGE="10"

ARG PHP_OPCACHE_VALIDATE_TIMESTAMPS

# PHP Opcache
ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS=${PHP_OPCACHE_VALIDATE_TIMESTAMPS} \
    PHP_OPCACHE_MAX_ACCELERATED_FILES="16000" \
    PHP_OPCACHE_MEMORY_CONSUMPTION="512" \
    PHP_OPCACHE_MAX_WASTED_PERCENTAGE="10"

# Copy composer.lock and composer.json
COPY ${HOST_SRC_DIR}/composer.lock* ${HOST_SRC_DIR}/composer.json* ${WORKING_DIRECTORY}

# Set working directory
WORKDIR ${WORKING_DIRECTORY}

# Install dependencies
RUN apt-get update && apt-get install -y \
    cron \
    libmcrypt-dev \
    nano \
    libzip-dev \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    unzip \
    curl \
    openssl \
    libcurl4-openssl-dev \ 
    pkg-config \
    libssl-dev \
    sudo \
    dnsutils \
    iputils-ping \
    procps \
    git \
    supervisor

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql exif pcntl gd zip opcache

# Install PHP MongoDB extension
RUN pecl install mongodb \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable mongodb \
    &&  pecl config-set php_ini /etc/php.ini

# Install PHP Redis
RUN pecl install -o -f redis \
	&&  rm -rf /tmp/pear \
	&&  docker-php-ext-enable redis

# Install PHP Sockets extension
RUN docker-php-ext-install sockets

# Config Supervisor
COPY ${DOCKER_DIRECTORY}/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user
RUN adduser --disabled-password --gecos '' --uid ${USER_ID} ${USERNAME}

# Config Entrypoint
COPY ${DOCKER_DIRECTORY}/entrypoint.sh /home/${USERNAME}/entrypoint.sh
RUN chmod +x /home/${USERNAME}/entrypoint.sh

# Copy PHP ini
COPY ${DOCKER_DIRECTORY}/php/custom.ini /usr/local/etc/php/conf.d/custom.ini
COPY ${DOCKER_DIRECTORY}/php/www.conf /usr/local/etc/php-fpm.d/www.conf

# Change user
USER ${USERNAME}

# Expose port 9000
EXPOSE 9000

# Run entrypoint
ENTRYPOINT ["/home/www/entrypoint.sh"]