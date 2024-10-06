# Use the official PHP image with Apache
FROM php:8.2-apache

# Set the working directory inside the container
WORKDIR /var/www/html

# Install system dependencies and required PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    certbot \
    python3-certbot-apache \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd mbstring xml exif pcntl bcmath opcache

# Enable Apache mod_rewrite for Laravel
RUN a2enmod rewrite
RUN a2enmod ssl 
RUN a2enmod headers

# Install Composer (Dependency Manager for PHP)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


# Copy the entire RSPK-HRT into the container
COPY . /var/www/html

# Set the correct permissions for Laravel directories
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Update the Apache config to serve the RSPK-HRT from the 'public' directory
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's|#ServerName www.example.com|Redirect https://holonresearchtower.org|g' /etc/apache2/sites-available/000-default.conf
RUN echo '<VirtualHost *:443>\n\
    DocumentRoot /var/www/html/public\n\
\n\
    SSLEngine on\n\
    SSLCertificateFile "/var/www/letsencrypt/certs/live/holonresearchtower.org/fullchain.pem"\n\
    SSLCertificateKeyFile "/var/www/letsencrypt/certs/live/holonresearchtower.org/privkey.pem"\n\
</VirtualHost>' >> /etc/apache2/sites-available/000-default.conf
# RUN sed -i 's|#ServerName www.example.com|Alias /.well-known/acme-challenge /var/www/letsencrypt/data/.well-known/acme-challenge|g' /etc/apache2/sites-available/000-default.conf

# Ensure that index.php is used as the default directory index file
RUN echo "<Directory /var/www/html/public>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>" >> /etc/apache2/apache2.conf

# Expose port 80 for the web server
EXPOSE 80
EXPOSE 443

# Start Apache in the foreground
CMD ["apache2-foreground"]
# CMD php artisan serve --host:0.0.0.0 --port:80