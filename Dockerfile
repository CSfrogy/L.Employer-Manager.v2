# Laravel Dockerfile for Railway deployment
# Simple Apache setup compatible with Railway

FROM heroku/heroku:22

# Install system dependencies
RUN apt-get update -qq && \
    apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libssl-dev \
    libcurl4-openssl-dev \
    libjpeg-dev \
    libfreetype6-dev \
    build-essential \
    apache2 \
    apache2-utils \
    apache2-dev \
    && rm -rf /var/lib/apt/lists/*


# Install PHP and required extensions
# Enable Ondřej PHP repository and install PHP 8.2 with extensions
RUN apt-get update -qq && \
    apt-get install -y --no-install-recommends \
    software-properties-common \
    ca-certificates \
    lsb-release \
    apt-transport-https && \
    add-apt-repository ppa:ondrej/php && \
    apt-get update -qq && \
    apt-get install -y \
    php8.2 \
    php8.2-cli \
    php8.2-fpm \
    php8.2-mysql \
    php8.2-zip \
    php8.2-gd \
    php8.2-mbstring \
    php8.2-curl \
    php8.2-xml \
    php8.2-bcmath \
    php8.2-intl \
    && rm -rf /var/lib/apt/lists/*

# Ensure PHP 8.2 is the default CLI and pdo_mysql is enabled
RUN update-alternatives --set php /usr/bin/php8.2 && phpenmod pdo_mysql

# Configure PHP for Laravel
RUN echo "memory_limit = 256M" > /etc/php/8.2/cli/conf.d/99-custom.ini && \
    echo "upload_max_filesize = 64M" >> /etc/php/8.2/cli/conf.d/99-custom.ini && \
    echo "post_max_size = 64M" >> /etc/php/8.2/cli/conf.d/99-custom.ini && \
    echo "max_execution_time = 60" >> /etc/php/8.2/cli/conf.d/99-custom.ini

# Install Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Allow composer plugins when running as root in Docker
ENV COMPOSER_ALLOW_SUPERUSER=1

# Copy application code
COPY . .

# Install PHP dependencies (skip scripts; run artisan later in entrypoint)
RUN composer install --optimize-autoloader --no-dev --no-interaction --prefer-dist --no-scripts

# Configure Apache for Laravel
RUN a2enmod rewrite && \
    a2enmod deflate && \
    a2enmod expires && \
    a2enmod headers && \
    a2enmod ssl

# Create Apache virtual host configuration
RUN echo '<VirtualHost *:8080>' > /etc/apache2/sites-available/000-default.conf && \
    echo '    DocumentRoot /var/www/html/public' >> /etc/apache2/sites-available/000-default.conf && \
    echo '    <Directory /var/www/html/public>' >> /etc/apache2/sites-available/000-default.conf && \
    echo '        AllowOverride All' >> /etc/apache2/sites-available/000-default.conf && \
    echo '        Require all granted' >> /etc/apache2/sites-available/000-default.conf && \
    echo '        DirectoryIndex index.php' >> /etc/apache2/sites-available/000-default.conf && \
    echo '        ErrorLog ${APACHE_LOG_DIR}/error.log' >> /etc/apache2/sites-available/000-default.conf && \
    echo '        CustomLog ${APACHE_LOG_DIR}/access.log combined' >> /etc/apache2/sites-available/000-default.conf && \
    echo '</VirtualHost>' >> /etc/apache2/sites-available/000-default.conf

# Set proper permissions
RUN chown -R heroku:heroku /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copy entrypoint script
COPY docker/entrypoint-railway.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Expose port
EXPOSE 8080

# Set entrypoint
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

# Use Apache foreground mode (Railway compatible)
CMD ["apache2-foreground"]
