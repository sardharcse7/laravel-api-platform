# Laravel API Subscription Platform

A modular, rate-limited API platform supporting user authentication, subscription tiers, daily usage limits, billing, and usage monitoring.

## Features

-  Token-based authentication via Passport
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

## Explanations

-  Rate-Limiting Approach
   Per-user daily quota stored in cache:
        When a user calls a protected API endpoint, the system increments a cache key like quota:{user_id}:{date} using Laravel’s cache (Redis or file, ideally Redis for performance). This counter tracks the number of API calls the user has made today.

-  Quota expiration & reset:
        The cache key is set with a TTL of 24 hours, so quotas automatically reset daily without needing manual cleanup.

-  Middleware enforcement:
        A custom middleware checks the user’s subscription tier to get their daily quota, compares it with the current call count, and either allows the request or returns HTTP 429 if the quota is exceeded.

-  Usage logs:
        Each API request is logged in the database for auditing and billing calculations.

-  Billing Approach
   Monthly billing job:
        On the 1st of each month (via Laravel Scheduler), a background task calculates the user’s total API calls for the previous month.

-   Premium tier usage pricing:
       Premium users have a large included monthly quota (10,000 calls/day * days in month). Calls beyond that quota are multiplied by the extra rate (e.g., $0.01 per call) to compute the billing amount.

-   Billing records saved:
        The calculated due amount and usage are saved in a billing_records table for user review and accounting.

-    Simulated billing:
          Actual payment integration can be added later; for now, the system just stores the amounts.

-    Rate limiting: Cache counters with 24h TTL + middleware to block over-quota calls.

-    Billing: Monthly scheduled job calculates premium users’ usage, stores billing records.

-    Scheduler: Run via php artisan schedule:work or cron entry every minute.

-    Queue: Run workers with php artisan queue:work for asynchronous tasks.

## Setup

```bash
git clone https://github.com/sardharcse7/laravel-api-subscription-platform.git
cd laravel-api-subscription-platform

composer install
cp .env.example .env
php artisan key:generate

php artisan migrate --seed
php artisan serve
