#!/bin/bash

# Laravel Docker Deployment Script
# This script helps you deploy your Laravel application using Docker

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

print_header() {
    echo -e "${BLUE}=== $1 ===${NC}"
}

# Check if Docker is installed
check_docker() {
    if ! command -v docker &> /dev/null; then
        print_error "Docker is not installed. Please install Docker first."
        exit 1
    fi
    
    if ! command -v docker-compose &> /dev/null; then
        print_error "Docker Compose is not installed. Please install Docker Compose first."
        exit 1
    fi
    
    print_status "Docker and Docker Compose are available"
}

# Create .env file if it doesn't exist
setup_env() {
    if [ ! -f ".env" ]; then
        if [ -f ".env.docker" ]; then
            print_status "Creating .env file from .env.docker template..."
            cp .env.docker .env
            print_warning "Please update the .env file with your actual configuration"
        else
            print_error ".env file not found. Please create one first."
            exit 1
        fi
    fi
}

# Build and start containers
deploy() {
    print_header "Starting Docker Deployment"
    
    # Stop any running containers
    print_status "Stopping existing containers..."
    docker-compose down 2>/dev/null || true
    
    # Build and start containers
    print_status "Building and starting containers..."
    docker-compose up --build -d
    
    # Wait for services to be ready
    print_status "Waiting for services to be ready..."
    sleep 10
    
    # Check if containers are running
    if docker-compose ps | grep -q "Up"; then
        print_status "Containers are running successfully!"
    else
        print_error "Some containers failed to start. Check logs with: docker-compose logs"
        exit 1
    fi
}

# Run migrations
run_migrations() {
    read -p "Do you want to run database migrations? (y/N): " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        print_status "Running database migrations..."
        docker-compose exec app php artisan migrate --force
        print_status "Migrations completed!"
    fi
}

# Install dependencies
install_deps() {
    read -p "Do you want to install Composer dependencies? (y/N): " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        print_status "Installing Composer dependencies..."
        docker-compose exec app composer install --optimize-autoloader --no-dev
        print_status "Dependencies installed!"
    fi
}

# Show logs
show_logs() {
    print_header "Container Logs"
    docker-compose logs -f
}

# Show status
show_status() {
    print_header "Container Status"
    docker-compose ps
    
    echo ""
    print_header "Container Information"
    echo "Application URL: http://localhost"
    echo "Database Port: 3306"
    echo "Redis Port: 6379"
    
    echo ""
    print_header "Useful Commands"
    echo "View logs: $0 logs"
    echo "Stop containers: $0 stop"
    echo "Restart containers: $0 restart"
    echo "Execute command in app container: docker-compose exec app <command>"
    echo "Access MySQL: mysql -h 127.0.0.1 -u root -p laravel"
    echo "Access Redis: redis-cli -h 127.0.0.1 -p 6379"
}

# Stop containers
stop() {
    print_header "Stopping Containers"
    docker-compose down
    print_status "Containers stopped"
}

# Restart containers
restart() {
    print_header "Restarting Containers"
    docker-compose restart
    print_status "Containers restarted"
}

# Clean up
cleanup() {
    print_header "Cleaning Up Docker Resources"
    read -p "This will remove all containers, volumes, and networks. Are you sure? (y/N): " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        docker-compose down -v --remove-orphans
        docker system prune -f
        print_status "Cleanup completed!"
    fi
}

# Main menu
show_menu() {
    echo ""
    print_header "Laravel Docker Deployment"
    echo "1) Deploy application"
    echo "2) Show status"
    echo "3) Show logs"
    echo "4) Stop containers"
    echo "5) Restart containers"
    echo "6) Run migrations"
    echo "7) Install dependencies"
    echo "8) Cleanup (remove all resources)"
    echo "9) Exit"
    echo ""
}

# Interactive mode
interactive() {
    while true; do
        show_menu
        read -p "Select an option (1-9): " choice
        case $choice in
            1)
                deploy
                run_migrations
                show_status
                ;;
            2) show_status ;;
            3) show_logs ;;
            4) stop ;;
            5) restart ;;
            6) run_migrations ;;
            7) install_deps ;;
            8) cleanup ;;
            9) 
                print_status "Goodbye!"
                exit 0
                ;;
            *)
                print_error "Invalid option. Please select 1-9."
                ;;
        esac
        echo ""
    done
}

# Command line mode
case "${1:-deploy}" in
    "deploy")
        check_docker
        setup_env
        deploy
        ;;
    "status")
        check_docker
        show_status
        ;;
    "logs")
        check_docker
        show_logs
        ;;
    "stop")
        check_docker
        stop
        ;;
    "restart")
        check_docker
        restart
        ;;
    "migrate")
        check_docker
        docker-compose exec app php artisan migrate --force
        ;;
    "deps")
        check_docker
        install_deps
        ;;
    "cleanup")
        check_docker
        cleanup
        ;;
    "interactive"|"menu"|"")
        check_docker
        interactive
        ;;
    *)
        print_error "Unknown command: $1"
        echo "Usage: $0 [deploy|status|logs|stop|restart|migrate|deps|cleanup|interactive]"
        exit 1
        ;;
esac
