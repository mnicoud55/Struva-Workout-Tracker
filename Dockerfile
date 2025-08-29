# FROM php:8.2-apache

# # Install required extensions
# RUN docker-php-ext-install pdo pdo_mysql mysqli

# # Copy app
# COPY . /var/www/html/

# # Set working directory
# WORKDIR /var/www/html



# # Use PHP 8.2 with Apache
# FROM php:8.2-apache

# # Install PDO MySQL extensions
# RUN docker-php-ext-install pdo pdo_mysql mysqli

# # Enable Apache rewrite module (needed for many frameworks)
# RUN a2enmod rewrite

# # Copy your project files into Apache web root
# COPY . /var/www/html/

# # Set working directory
# WORKDIR /var/www/html

# # Fix file permissions so Apache can read files
# RUN chown -R www-data:www-data /var/www/html \
#     && chmod -R 755 /var/www/html

# # Set login.php as default page
# RUN echo "DirectoryIndex login.php" >> /etc/apache2/apache2.conf

# # Optional: set server name to suppress warning
# RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# # Expose port 8080 for Cloud Run
# ENV PORT 8080
# EXPOSE 8080

# # Configure Apache to listen on $PORT (Cloud Run requirement)
# RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf \
#     && sed -i 's/80/${PORT}/g' /etc/apache2/ports.conf


# Use PHP 8.2 with Apache
FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN a2enmod rewrite

COPY . /var/www/html/
WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

RUN echo "DirectoryIndex login.php" >> /etc/apache2/apache2.conf
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Apache listens on 8080 for both local testing and Cloud Run
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf \
    && sed -i 's/80/8080/g' /etc/apache2/sites-available/000-default.conf

EXPOSE 8080
CMD ["apache2-foreground"]
