FROM phpdockerio/php:8.3-fpm
WORKDIR "/app"

RUN apt-get update \
    && apt-get -y --no-install-recommends install \
        php8.3-http \ 
        php8.3-imap \ 
        php8.3-mcrypt \ 
        php8.3-oauth \ 
        php8.3-pgsql \ 
        php8.3-redis \ 
        php8.3-raphf \ 
        php8.3-yaml \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
