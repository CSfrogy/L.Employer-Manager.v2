# Docker Deployment Setup for Laravel Application

This repository contains a complete Docker setup for deploying your Laravel application in production environments.

## 📁 Files Created

### Core Docker Files

-   `Dockerfile` - Main application container with PHP 8.2-FPM
-   `docker-compose.yml` - Production deployment configuration
-   `docker-compose.override.yml` - Development environment overrides
-   `.dockerignore` - Files to exclude from Docker build

### Configuration Files

-   `docker/nginx/default.conf` - Nginx configuration
-   `docker/mysql/my.cnf` - MySQL optimization settings
-   `docker/redis/redis.conf` - Redis cache configuration
-   `docker/entrypoint.sh` - Application startup script

### Environment & Scripts

-   `.env.docker` - Docker environment template
-   `docker-deploy.sh` - Automated deployment script

## 🚀 Quick Start

### Option 1: Automated Deployment

```bash
# Make the script executable (already done)
chmod +x docker-deploy.sh

# Run the deployment script
./docker-deploy.sh

# Or run in interactive mode
./docker-deploy.sh interactive
```

### Option 2: Manual Deployment

```bash
# 1. Copy environment file
cp .env.docker .env

# 2. Update .env with your actual configuration
# 3. Build and start containers
docker-compose up --build -d

# 4. Run migrations (optional)
docker-compose exec app php artisan migrate --force
```

## 🏗️ Architecture

The Docker setup includes the following services:

### Services Overview

| Service       | Purpose                | Port            |
| ------------- | ---------------------- | --------------- |
| **app**       | PHP-FPM Application    | 9000 (internal) |
| **web**       | Nginx Web Server       | 80 (external)   |
| **mysql**     | MySQL Database         | 3306 (external) |
| **redis**     | Redis Cache            | 6379 (external) |
| **queue**     | Laravel Queue Worker   | -               |
| **scheduler** | Laravel Task Scheduler | -               |

### Service Details

#### Application Container (app)

-   **Base Image**: PHP 8.2-FPM Alpine
-   **Extensions**: MySQL, PostgreSQL, GD, intl, zip, bcmath, opcache
-   **Features**: Composer, optimized for production

#### Web Server (web)

-   **Base Image**: Nginx Alpine
-   **Configuration**: Optimized for Laravel with gzip compression
-   **Security**: Headers for XSS, CSRF protection

#### Database (mysql)

-   **Version**: MySQL 8.0
-   **Configuration**: Optimized for Laravel applications
-   **Persistence**: Data stored in Docker volume

#### Cache (redis)

-   **Version**: Redis 7 Alpine
-   **Usage**: Session storage, caching, queues
-   **Persistence**: Data stored in Docker volume

## 🔧 Configuration

### Environment Variables

Copy `.env.docker` to `.env` and update the following key variables:

```env
# Application
APP_NAME="Your App Name"
APP_ENV=production
APP_KEY= # Will be generated automatically
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database
DB_CONNECTION=mysql
DB_HOST=mysql
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Redis
REDIS_HOST=redis
REDIS_PASSWORD=your_redis_password
```

### SSL Configuration (Optional)

Place your SSL certificates in `docker/nginx/ssl/`:

-   `docker/nginx/ssl/cert.pem` - SSL certificate
-   `docker/nginx/ssl/key.pem` - SSL private key

Update the nginx configuration to use SSL if needed.

## 🛠️ Management Commands

### Using the Deployment Script

```bash
# Interactive menu
./docker-deploy.sh interactive

# Direct commands
./docker-deploy.sh deploy      # Deploy application
./docker-deploy.sh status      # Show container status
./docker-deploy.sh logs        # Show live logs
./docker-deploy.sh stop        # Stop containers
./docker-deploy.sh restart     # Restart containers
./docker-deploy.sh migrate     # Run database migrations
./docker-deploy.sh deps        # Install dependencies
./docker-deploy.sh cleanup     # Remove all resources
```

### Manual Docker Commands

```bash
# Build and start
docker-compose up --build -d

# View logs
docker-compose logs -f

# Execute commands
docker-compose exec app bash
docker-compose exec app php artisan migrate
docker-compose exec app composer install

# Database access
mysql -h 127.0.0.1 -u root -p laravel

# Redis access
redis-cli -h 127.0.0.1 -p 6379

# Stop containers
docker-compose down

# Stop and remove volumes
docker-compose down -v
```

## 🔄 Development vs Production

### Development

-   Use `docker-compose.override.yml` for development settings
-   Hot reload enabled for code changes
-   Debug mode enabled
-   Artisan server instead of Nginx

### Production

-   Optimized for performance and security
-   Nginx serving static files
-   PHP-FPM for PHP processing
-   Proper caching and compression

## 📊 Monitoring & Maintenance

### Log Management

```bash
# View application logs
docker-compose logs app

# View web server logs
docker-compose logs web

# View database logs
docker-compose logs mysql

# View all logs
docker-compose logs
```

### Performance Monitoring

```bash
# Check container status
docker-compose ps

# Monitor resource usage
docker stats

# Check container health
docker-compose ps
```

### Backup and Restore

```bash
# Backup database
docker-compose exec mysql mysqldump -u root -p laravel > backup.sql

# Restore database
docker-compose exec -T mysql mysql -u root -p laravel < backup.sql

# Backup files
tar -czf app-backup.tar.gz /path/to/app/data
```

## 🔐 Security Considerations

### Production Security Checklist

-   [ ] Change default passwords in `.env`
-   [ ] Set `APP_DEBUG=false`
-   [ ] Use SSL certificates
-   [ ] Configure proper firewall rules
-   [ ] Enable MySQL user authentication
-   [ ] Set Redis password
-   [ ] Regular security updates

### SSL Setup

1. Place certificates in `docker/nginx/ssl/`
2. Update nginx configuration for SSL
3. Update `.env` with HTTPS URL

## 🚨 Troubleshooting

### Common Issues

#### Containers not starting

```bash
# Check logs
docker-compose logs

# Check if ports are available
netstat -tulpn | grep :80
```

#### Database connection issues

```bash
# Check if MySQL is ready
docker-compose exec app php artisan migrate:status

# Check database connectivity
docker-compose exec app php artisan tinker
```

#### Permission issues

```bash
# Fix Laravel permissions
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
docker-compose exec app chmod -R 775 storage bootstrap/cache
```

#### Memory issues

```bash
# Check container resources
docker stats

# Increase memory limits in docker-compose.yml
```

## 📝 Development Workflow

### Starting Development Environment

```bash
# Copy environment
cp .env.docker .env

# Start with development overrides
docker-compose up -d

# Install dependencies
docker-compose exec app composer install
docker-compose exec app npm install && npm run build

# Run migrations
docker-compose exec app php artisan migrate
```

### Making Changes

-   Code changes are automatically reflected (mounted volumes)
-   Run `docker-compose exec app npm run build` for frontend changes
-   Clear caches: `docker-compose exec app php artisan cache:clear`

## 🔄 CI/CD Integration

### Example GitHub Actions

```yaml
name: Deploy to Production
on:
    push:
        branches: [main]

jobs:
    deploy:
        runs-on: ubuntu-latest
        steps:
            - uses: actions/checkout@v2
            - name: Deploy with Docker
              run: |
                  docker-compose up --build -d
                  docker-compose exec app php artisan migrate --force
```

## 📚 Additional Resources

-   [Laravel Documentation](https://laravel.com/docs)
-   [Docker Documentation](https://docs.docker.com/)
-   [Nginx Documentation](https://nginx.org/en/docs/)
-   [MySQL Documentation](https://dev.mysql.com/doc/)
-   [Redis Documentation](https://redis.io/documentation)

## 🆘 Support

For issues related to:

-   **Laravel**: Check Laravel documentation and community forums
-   **Docker**: Refer to Docker documentation
-   **Nginx**: Check nginx configuration and logs
-   **Database**: Check MySQL/PostgreSQL logs and configuration

## 📋 Files Summary

| File                          | Purpose                           |
| ----------------------------- | --------------------------------- |
| `Dockerfile`                  | Application container definition  |
| `docker-compose.yml`          | Production service orchestration  |
| `docker-compose.override.yml` | Development environment overrides |
| `docker/nginx/default.conf`   | Web server configuration          |
| `docker/mysql/my.cnf`         | Database optimization             |
| `docker/redis/redis.conf`     | Cache server configuration        |
| `docker/entrypoint.sh`        | Application startup script        |
| `.dockerignore`               | Build exclusions                  |
| `.env.docker`                 | Environment template              |
| `docker-deploy.sh`            | Deployment automation             |

This Docker setup provides a production-ready deployment environment for your Laravel application with proper separation of concerns, optimization, and security best practices.
