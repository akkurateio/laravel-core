# Laravel Core

Using this package you can easily get Akkurate's interfaces. Here are centralized classes (traits, formulaires ...) that can be called by the other Akkurate packages.

## Installation

This package can be installed through Composer.

``` bash
composer require akkurate/laravel-core
```

Optionally, you can publish the dashboard view with this command:
```bash
php artisan vendor:publish --tag="dashboard"
```

You can publish as well the config file with this command:
```bash
php artisan vendor:publish --provider="Akkurate\LaravelCore\LaravelCoreServiceProvider" --tag="config"
```

The following files will be published in the config folder of your app : ``general.php``, `reference` and `laravel-core`.

Now to deploy the core installation process, you have to through this command:
```bash
php artisan core:install
```

## Laravel Admin

Module for managing accounts, users, languages, countries and preferences for Laravel projects.

Optionally, you can publish the config file with this command:
```bash
php artisan vendor:publish --provider="Akkurate\LaravelAdmin\LaravelAdminServiceProvider" --tag="config"
```

## Laravel Access

Module for managing roles and permissions.

If you want to overwrite the config file:
```bash
php artisan vendor:publish --provider="Akkurate\LaravelAccess\LaravelAccessServiceProvider" --tag="config"
```

## Laravel Me

Module for managing the user profile.

If you want to overwrite the config with:
```bash
php artisan vendor:publish --provider="Akkurate\LaravelMe\LaravelMeServiceProvider" --tag="config"
```

If you want to overwrite the users delete partial:
```bash
php artisan vendor:publish --provider="Akkurate\LaravelMe\LaravelMeServiceProvider" --tag="user-partials"
```

If you want to publish all the views:
```bash
php artisan vendor:publish --provider="Akkurate\LaravelMe\LaravelMeServiceProvider" --tag="views"
```

## Tests

At the root of the locally installed package:
```bash
composer install
composer test
```
