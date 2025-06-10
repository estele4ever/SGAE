#!/usr/bin/env bash

# Install dependencies
npm install

# Build assets
npm run build

# Clear cache
php artisan cache:clear
php artisan view:clear
php artisan config:clear

# Optimize
php artisan optimize