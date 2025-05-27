## Requirements
- php version 8.2
- laravel version 11
- database using MySql
- adminlte (bootstrap)

## .env 
Add this to .env
```
DIGIFLAZZ_USERNAME=
DIGIFLAZZ_KEY=
DIGIFLAZZ_WEBHOOK_SECRET=
```
## Initial
After cloning repositories, Please do:
```
cp .env.example .env
```
```
php artisan key:generate
```
```
composer install
```
```
npm install
```
```
php migrate 
```
