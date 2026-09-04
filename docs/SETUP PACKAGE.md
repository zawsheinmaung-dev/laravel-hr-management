# HR Management System - Installation Stack

## Backend Framework

### Laravel 12

Installed:

- Laravel Framework 12.x
- PHP 8.x


---

## Authentication

### Laravel Breeze

Installed:

```bash
composer require laravel/breeze --dev

php artisan breeze:install
composer require tightenco/ziggy
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

NPM Install

npm install @inertiajs/vue3
laravel-vite-plugin
npm install -D @vitejs/plugin-vue
npm install tailwindcss @tailwindcss/vite