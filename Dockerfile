FROM php:7.2-fpm-alpine

# Install PHP Required Extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer from official Docker image
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Set Working Directory
WORKDIR /var/www

# Set Permissions For Webserver User
COPY --chown=www-data:www-data ./ /var/www

# Create user based on provided user ID - helps reduce permission issues between host / client
ARG HOST_UID
RUN adduser --disabled-password --gecos "" --uid $HOST_UID gumboShrimp

# Switch to that user
USER gumboShrimp