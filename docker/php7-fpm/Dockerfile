# See https://github.com/docker-library/php/blob/master/7.1/fpm/Dockerfile
FROM php:7.4-fpm
ARG TIMEZONE
ARG UPSTREAMPORT

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

# Custom upstream port
#RUN sed -i 's/listen = 9000/listen = 9001/' /usr/local/etc/php-fpm.d/zz-docker.conf
RUN printf '[global]\ndaemonize = no\n\n[www]\nlisten = "%s"' ${UPSTREAMPORT} > /usr/local/etc/php-fpm.d/zz-docker.conf

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
#RUN pecl install xdebug
#RUN docker-php-ext-enable xdebug
#RUN echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
#RUN echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
#RUN echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
#RUN echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
#RUN echo "xdebug.remote_connect_back=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
#RUN echo "xdebug.idekey=\"PHPSTORM\"" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
#RUN echo "xdebug.remote_port=9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
#RUN echo "xdebug.var_display_max_depth=10" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
#RUN echo "xdebug.var_display_max_children=128" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
#RUN echo "xdebug.var_display_max_data = 512" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# OPCACHE
RUN echo '\
opcache.enable=1\n\
opcache.revalidate_freq=0\n\
opcache.validate_timestamps=1\n\
opcache.max_accelerated_files=20000\n\
opcache.memory_consumption=512\n\
opcache.max_wasted_percentage=10\n\
opcache.interned_strings_buffer=16\n\
opcache.fast_shutdown=1\n\
' >> /usr/local/etc/php/conf.d/docker-opcache.ini

# define conf
RUN echo '\
    memory_limit=4G\n\
    max_execution_time=60000\n\
    realpath_cache_size=4096K\n\
    realpath_cache_ttl=600\n\
    default_socket_timeout=360\n\
    upload_max_filesize = 30M\n\
    post_max_size = 256M\n\
    ' >> /usr/local/etc/php/conf.d/docker-php-conf.ini


RUN echo 'alias sf="php bin/console"' >> ~/.bashrc

WORKDIR /var/www/symfony
