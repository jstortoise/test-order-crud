
**Guide**
--
 - Clone this git repository
 - In the directory run the command: `composer install`
 - Edit the `.env` file for the database configuration
 - Migrate the db and run db seeder:
 `php artisan migrate`
 `php artisan db:seeder`
 - Start the server by running the command: `php artisan serve`
 - Visit [http://localhost:8000] 
 - For the test, run this command: `php artisan test`