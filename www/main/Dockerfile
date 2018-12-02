FROM phpdockerio/php72-fpm:latest
WORKDIR "/var/www"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install  php7.2-mysql php-redis php-xdebug php7.2-gd php-imagick php7.2-soap php7.2-bcmath \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install git
RUN apt-get update \
    && apt-get -y install git \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install node
RUN curl -sL https://deb.nodesource.com/setup_10.x -o /var/tmp/nodesource_setup.sh \
    && bash /var/tmp/nodesource_setup.sh \
    && apt-get update \
    && apt-get -y install nodejs \
    && apt-get -y install build-essential \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Copy overrides conf
COPY .docker/php.ini.overrides.ini /etc/php/7.2/fpm/conf.d/99-overrides.ini

COPY / /var/www