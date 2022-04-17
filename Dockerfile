FROM php:8.1.0-fpm-alpine

LABEL maintainer="Olaleye Osunsanya"
LABEL description="sunspottours-test-senior-lead-php-developer"

ARG uid=1000
ARG user=olaleye

# Install system dependencies
RUN apk add --update && apk add --no-cache \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    pcre-dev ${PHPIZE_DEPS} \
      && pecl install redis \
      && docker-php-ext-enable redis \
      && apk del pcre-dev ${PHPIZE_DEPS} \
      && rm -rf /tmp/pear

# Install PHP extensions
RUN docker-php-ext-install exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN adduser -u $uid -G www-data -h /home/$user -D $user

RUN mkdir -p /home/$user/.composer && \
    chown -R $user /home/$user

# Set working directory
WORKDIR /var/www

USER $user
