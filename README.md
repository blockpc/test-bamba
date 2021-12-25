# Blockpc Backend

## Laravel backend Layout

This repo contains a frontend and bakend layouts for a laravel breeze  
Contains:
- Laravel 8
- Tailwind
- Livewire
- Alpine JS

Helpers: file autoload helper on `app\helpers.php`

Packages for laravel:
- [christophrumpel/missing-livewire-assertions](https://github.com/christophrumpel/missing-livewire-assertions)
- [spatie/laravel-permission](https://spatie.be/index.php/docs/laravel-permission)
- [yoeunes/toastr](https://github.com/yoeunes/toastr)
- [intervention/image](http://image.intervention.io/)

Packages NPM: only one, [tailwind-scrollbar](https://github.com/adoxography/tailwind-scrollbar)

This packages includes a model `Profile` (one-to-one for user) and model `Image` (polimorphic model)

And change some components from the original laravel install.


### Install Clone

- git clone https://github.com/blockpc/blockpc-with-backend your-proyect
- cd your-proyect
- cp .env.example .env (Configure your app name, app url, database, email, etc)
- composer install
- php artisan key:generate
- npm install
- npm run dev
- php artisan migrate
- php artisan storage:link
- php artisan test

You must before start your proyect remove or change the git remote url

### Change remote

- git remote set-url origin <url-at-your-proyect-git>
- git remote -v

Enjoy!