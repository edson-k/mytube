<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Example run on Heroku
https://ek-mytube.herokuapp.com/

[![Deploy](https://www.herokucdn.com/deploy/button.png)](https://heroku.com/deploy?template=https://github.com/edson-k/mytube)

## Clone project and install
`$ git clone git@github.com:edson-k/mytube.git Laravel`

`$ cd Laravel`

`$ composer install`

## Configuration of project
`$ cp .env.example .env`

`$ vi .env`

add youtube api key
```
YOUTUBE_API_KEY=<your_key>
```

## RUN
`$ php artisan serve`

## Files
[mytube/app/Helpers/YoutubeHelper.php](https://github.com/edson-k/mytube/blob/master/app/Helpers/YoutubeHelper.php)

[mytube/app/Http/Controllers/SearchController.php](https://github.com/edson-k/mytube/blob/master/app/Http/Controllers/SearchController.php)

[mytube/routes/web.php](https://github.com/edson-k/mytube/blob/master/routes/web.php)

[mytube/resources/views/search.blade.php](https://github.com/edson-k/mytube/blob/master/resources/views/search.blade.php)

[mytube/resources/views/result.blade.php](https://github.com/edson-k/mytube/blob/master/resources/views/result.blade.php)

## Heroku - Cloud Application Platform
https://www.heroku.com

## Heroku - Redis - Database for cache free
https://elements.heroku.com/addons/heroku-redis