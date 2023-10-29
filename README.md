# Group6_SE347.O11

Hướng dẫn cài đặt sau khi clone project.

1. Download Composer và Node.js.
2. cp .env.example .env
3. Config database name in .env (DB_DATABASE=)
4. composer install
5. npm install
6. php artisan key:generate
7. composer update
8. php artisan migrate
9. php artisan db:seed
10. php artisan serve