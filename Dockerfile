FROM php:8.1.0-apache

WORKDIR /var/www/html

#mod rewrite 
RUN a2enmod rewrite

# Add ServerName directive to suppress Apache warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

RUN apt-get update -y && \
    apt-get install -y \
    libicu-dev \
    libmariadb-dev \
    unzip \
    zip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files into the image
COPY . /var/www/html/

# Set ownership and permissions for cache and logs directories
RUN chown -R www-data:www-data /var/www/html/tmp/cache/ && \
    chmod -R 777 /var/www/html/tmp/cache/
RUN chown -R www-data:www-data /var/www/html/logs/ && \
    chmod -R 777 /var/www/html/logs/

# Install PHP extensions
RUN docker-php-ext-install intl pdo_mysql gd 

# Configure and install GD extension
RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd
