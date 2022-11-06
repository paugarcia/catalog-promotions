FROM phpdockerio/php:8.1-fpm
WORKDIR "/application"

RUN apt-get update; \
    apt-get -y --no-install-recommends install \
        git \
        php8.1-memcached \
        php8.1-mongodb \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
