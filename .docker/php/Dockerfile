FROM php:7.4-fpm

# Copy custom php.ini
COPY ./conf/php.ini /usr/local/etc/php/conf.d/99-custom-php.ini

# Install necessary packages
RUN apt-get update -y && apt-get install -y \
        curl \
        git \
        libcurl4-openssl-dev \
        libldap2-dev \
        libssl-dev \
        libxslt-dev \
        libicu-dev \
        libsqlite3-dev \
        libzip-dev \
        g++ \
        default-mysql-client \
        nano \
        zip \
        unzip \
    --no-install-recommends && \
    rm -r /var/lib/apt/lists/*

# Install PHP Extensions
RUN docker-php-ext-configure intl && \
    docker-php-ext-configure mysqli --with-mysqli=mysqlnd && \
    docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ && \
    docker-php-ext-install -j$(nproc) \
        bcmath \
        intl \
        ldap \
        mysqli \
        pdo \
        pdo_sqlite \
        pdo_mysql \
        xsl \
        zip

# Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer

EXPOSE 80
