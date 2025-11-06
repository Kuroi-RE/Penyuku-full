#!/bin/sh

# Vercel Build Script
# This script runs during deployment

echo "Building Laravel application for Vercel..."

# Install composer dependencies
composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Install npm dependencies and build assets
npm install
npm run build

# Create necessary directories
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set proper permissions
chmod -R 775 storage bootstrap/cache

echo "Build completed successfully!"
