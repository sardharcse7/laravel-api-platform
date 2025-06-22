# Laravel API Subscription Platform

A modular, rate-limited API platform supporting user authentication, subscription tiers, daily usage limits, billing, and usage monitoring.

## Features

-  Token-based authentication via Sanctum
-  Rate-limiting per subscription tier (Free, Standard, Premium)
-  Premium billing system (monthly)
-  Daily quota reset via scheduler
-  API usage tracking and reporting
-  Clean modular code for easy extension

## Requirements

- PHP 7.4+
- Laravel 10+
- MySQL
- Redis (optional, for cache rate limiting)
- Docker (optional)

## Setup

```bash
git clone https://github.com/sardharcse7/laravel-api-subscription-platform.git
cd laravel-api-subscription-platform

composer install
cp .env.example .env
php artisan key:generate

php artisan migrate --seed
php artisan serve
