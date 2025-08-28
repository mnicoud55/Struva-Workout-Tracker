# FROM php:8.2-apache

# # Install required extensions
# RUN docker-php-ext-install pdo pdo_mysql mysqli

# # Copy app
# COPY . /var/www/html/

# # Set working directory
# WORKDIR /var/www/html



# Use PHP 8.2 with Apache
FROM php:8.2-apache

# Install PDO MySQL extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Enable Apache rewrite module (needed for many frameworks)
RUN a2enmod rewrite

# Copy your project files into Apache web root
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Expose port 8080 for Cloud Run
ENV PORT 8080
EXPOSE 8080

# Configure Apache to listen on $PORT (Cloud Run requirement)
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's/80/${PORT}/g' /etc/apache2/ports.conf