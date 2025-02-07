Setup: <br>
clone repository <br>
composer install <br>
(configure .env to connect to mysql db or leave as is to use sqlite) <br>
php artisan migrate --seed <br>
npm run dev <br>
php artisan queue:work <br>
(to see generated emails either connect to smtp server such as mailtrap, or check them in storage/logs/laravel.log file) <br>

