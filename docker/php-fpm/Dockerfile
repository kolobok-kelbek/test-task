FROM phpdockerio/php73-fpm

WORKDIR "/app"

RUN apt-get update \
    && apt-get -y --no-install-recommends install libpq-dev php-xdebug \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
