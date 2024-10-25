# MAS POS

## Default Usage (Use XAMPP, MAMPP, etc)

### Additional Kit
1. Visual Studio Code/Sublime/Other Text Editor
2. Composer
3. XAMPP/MAMPP/Other (Minimum PHP Version 8.2)
4. NodeJs (for development purpose)

### How to Run the Application
1. Clone this repository <code>git clone https://github.com/naufal-rafif/laravel-filament-starter.git appname</code>
2. Run <code>composer install</code>
3. Make sure your xampp mysql and server is run.
4. Run <code>php artisan migrate --seed</code>
5. Run <code>php artisan serve</code>
5. Run <code>npm install</code>
6. Run <code>npm run dev</code> for development mode and  <code>npm run build</code> for production mode

### NOTE
- please change your .env file, change the config database, and app as you want.

## Docker Usage

Change environment and 
```
cp .env.example .env
cp docker-compose.yml.default docker-compose.yml
```

#### Development Environment
```
sh stub/local/setup.sh
```

#### Production Environment
```
sh stub/prod/setup.sh
```

### Docker Usage Note
- On development we use npm package **chokidar** to update change when reload. You can remove `--watch` on **supervisord.conf** or you can choose setup on production mode
- We use Laravel Octane with frankenphp server, you can change or remove it if you don't want use it
- Please consider use default container name logic on docker-compose.yml to run bash script (It use **COINTAINER_NAME** variable on .env file)
- It's free to change database like mysql, mariadb, postgres, etc. But we just use Postgres in this starter kit for example.

## Filament Cheat Sheet

Optimize filament on Production
```
php artisan filament:optimize
```

Clear cache on filament
```
php artisan filament:optimize-clear
```

## Just a Note

You can directly show the error on the storage/logs file

test user can be found at database/seeders/UserSeeder.php 

## Progress
- [x] Docker Friendly
- [x] User Module
- [ ] Role Permission
- [ ] Multi Tenant
- [x] Landing Page
- [ ] App Setting
- [ ] Testing

## Happy Code !
