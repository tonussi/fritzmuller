# Fritz Muller App

> educational project

## Features

- Laravel 5.7 
- Vue + VueRouter + Vuex + VueI18n + Vuetify
- Pages with dynamic import and custom layouts
- Login, register and password reset
- Authentication with JWT

## Installation

- `composer create-project --prefer-dist tonussi/fritzmuller`
- Edit `.env` and set your database connection details
- (When installed via git clone or download, run `php artisan key:generate` and `php artisan jwt:secret`)
- `php artisan migrate`
- `$ composer config -g repos.packagist composer https://packagist.com.br`
- `composer install`
- `yarn` (Install [Yarn](https://yarnpkg.com/en/docs/install) if you don't have it.)

## Usage

#### Development

```bash
# build and watch
yarn run watch-poll

# serve with hot reloading
yarn run hot
```

#### Production

```bash
yarn run production
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.
