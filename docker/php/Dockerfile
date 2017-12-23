FROM php:7.2.0-fpm

RUN apt update && \
    apt install -y \
        zip \
        unzip \
        libpq-dev

RUN rm /etc/localtime &&\
    ln -s /usr/share/zoneinfo/Europe/Paris /etc/localtime && \
    date

RUN usermod -u 1000 www-data && \
    groupmod -g 1000 www-data && \
    chown -R www-data:www-data .

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    mkdir /var/www/.composer && \
    chown -R www-data:www-data /var/www/.composer

RUN echo 'alias symfony="php bin/console"' >> ~/.bashrc

RUN apt-get clean && \
    apt-get autoclean && \
    apt-get autoremove && \
    rm -rf /var/lib/apt/lists/*
