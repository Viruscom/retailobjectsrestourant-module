<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
</p>
<p align="center" style="font-size: 50px;font-weight: bold;">IWISHONLINE CMS</p>
<p align="center"><i>ver.1.0.0</i></p>
IWISHONLINE CMS is Laravel based app that offers functionality with package management system.

## Installation

Install all the dependencies using composer

    composer require iwish/retailobjectsrestourant

Set Google Maps API Key

    APIS/GoogleMapsApi.php > const $API_KEY = ".......";

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Run database seeds

    php artisan db:seed
