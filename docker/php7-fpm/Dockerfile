# See https://github.com/docker-library/php/blob/master/7.1/fpm/Dockerfile
FROM php:7.4-fpm
ARG TIMEZONE

MAINTAINER Jonathan Gondellier <jgondellier@yahoo.fr>

RUN apt-get update && apt-get install -y \
    openssl \
    git \
    unzip \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libonig-dev \
    libpng-dev \
    libxml2-dev

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone
RUN printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini
RUN "date"

# Type docker-php-ext-install to see available extensions
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install gd mysqli
RUN docker-php-ext-install -j$(nproc) gd mbstring mysqli pdo pdo_mysql shmop xmlrpc
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# install xdebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
RUN echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_connect_back=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.idekey=\"PHPSTORM\"" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_port=9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.var_display_max_depth=10" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini


# define conf
RUN echo "memory_limit=4G" >> /usr/local/etc/php/conf.d/docker-php-conf.ini
RUN echo "upload_max_filesize=8M" >> /usr/local/etc/php/conf.d/docker-php-conf.ini
RUN echo "post_max_size=8M" >> /usr/local/etc/php/conf.d/docker-php-conf.ini
RUN echo "max_execution_time=60000" >> /usr/local/etc/php/conf.d/docker-php-conf.ini
RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/docker-php-conf.ini
RUN echo "opcache.memory_consumption=512" >> /usr/local/etc/php/conf.d/docker-php-conf.ini
RUN echo "opcache.max_accelerated_files=20000" >> /usr/local/etc/php/conf.d/docker-php-conf.ini
RUN echo "opcache.validate_timestamps=0" >> /usr/local/etc/php/conf.d/docker-php-conf.ini
RUN echo "realpath_cache_size=4096K" >> /usr/local/etc/php/conf.d/docker-php-conf.ini
RUN echo "realpath_cache_ttl=600" >> /usr/local/etc/php/conf.d/docker-php-conf.ini

RUN echo 'alias sf="php app/console"' >> ~/.bashrc
RUN echo 'alias sf3="php bin/console"' >> ~/.bashrc

WORKDIR /var/www/symfony
