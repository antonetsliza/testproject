Setup:
clone repository
composer install
(configure .env to connect to mysql db or leave as is to use sqlite)
php artisan migrate --seed
npm run dev
php artisan queue:work
(to see generated emails either connect to smtp server such as mailtrap, or check them in storage/logs/laravel.log file)

