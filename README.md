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

    composer require iwish/

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Set permissions for folders

    chmod -R 0777 storage
    chmod -R 0777 bootstrap

Change .env properties

- APP_NAME= Set application name like Iwishonline shop
- APP_ENV= Set to production
- APP_DEBUG= Set to false
- APP_URL= Set production domain
- MINIFY_HTML=true
- DATABASE
    - DB_CONNECTION=mysql
    - DB_HOST=127.0.0.1
    - DB_PORT=3306
    - DB_DATABASE= Set DB
    - DB_USERNAME= Set DB username
    - DB_PASSWORD= Set DB password
- MAIL
    - MAIL_MAILER=smtp
    - MAIL_HOST= Set Host
    - MAIL_PORT= Set Port
    - MAIL_USERNAME= Set Username
    - MAIL_PASSWORD= Set Password
    - MAIL_ENCRYPTION= Set Encryption
    - MAIL_FROM_ADDRESS= Set Email address
    - MAIL_FROM_NAME="${APP_NAME}"

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Run database seeds

    php artisan db:seed

On production server set cronjob command

    /usr/local/bin/php /home/hosting-username/laravel-folder/artisan schedule:run >> /dev/null 2>&1

Install packages
<br>
Example fo name of Package: AdBoxes
<br>
Link to Documentation: **[Laravel-Modules Artisan commands](https://nwidart.com/laravel-modules/v6/advanced-tools/artisan-commands)**
<br>
If you have problem with branch like dev-master, dev-main - use: composer require -vvv "iwish/name_of_module dev-main"

    composer require joshbrw/laravel-module-installer
    use composer require iwish/name_of_module-module
    php artisan cache:clear
    composer dump-autoload
    php artisan module:migrate name_of_module
    php artisan module:seed name_of_module
    php artisan route:clear

## Post installation instructions and commands

### Performance optimizations

Cache routes

    php artisan route:cache
    php artisan route:clear

Optimize composer

    composer install --prefer-dist --no-dev -o

#### Other performance optimizations

<p>Reduce Autoloaded Services</p>
<p>Reduce Package Usage</p>
<p>Compress Images</p>
<p>Use a CDN</p>
<p>Minimize JS and CSS Code</p>

<p>
Configuration Caching: 
<br>Compiles all application’s configuration values into one file so that the framework can load it faster.

    php artisan config:cache
    php artisan config:clear

</p>

<p>
Views Caching: 
<br>Cache all views. 
<br><b>Warning !!!</b>
<br> Be careful with caching views. Can be used on NOT DYNAMIC websites.

    php artisan view:cache
    php artisan view:clear

</p>
<p>Use CloudFlare</p>

### Packages

Name of package is last segment of url. For example: AdBoxes module name from https://github.com/Viruscom/adboxes-module is adboxes-module

- **[Ad Boxes](https://github.com/Viruscom/adboxes-module)**
- **[Shop](https://github.com/Viruscom/shop-module)**
- **[Shop Discounts](https://github.com/Viruscom/shopdiscounts-module)**
- **[Hotel](https://github.com/Viruscom/hotel-module)**
- **[Blog](https://github.com/Viruscom/blog-module)**

- **[Newsletter](https://lendio.com)**
- **[Econt delivery](https://romegasoftware.com)**
- **[Speedy delivery](https://romegasoftware.com)**
- **[MyPOS Payment](https://romegasoftware.com)**
- **[YanakSoft API](https://github.com/Viruscom/yanaksoftapi-module.git)**

### Get Packages

Blog

    composer require iwish/blog-module

AdBoxes

    composer require iwish/adboxes-module

## Contributing

## Security Vulnerabilities

If you discover a security vulnerability within our system, please send an e-mail to IWISHONLINE LTD via [office@iwishonline.info](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

### Chosen packages

- **[SEO Package](https://github.com/artesaos/seotools)**
- **[Sitemap Package](https://github.com/spatie/laravel-sitemap)**
- **[Translations Package](https://github.com/Astrotomic/laravel-translatable)**
- **[Schema Package](https://github.com/spatie/schema-org)**

# Needed information for production (before encryption)

# Needed information for production (after encryption)

- Register account at https://www.exchangerate-api.com/ and set API key for current client

## For each model

- FILES_PATH = "images/law_pages";
- $MODEL_RATIO = '1/1';
- $MODEL_MIMES = 'jpg,jpeg,png,gif';
- $MODEL_MAX_FILE_SIZE = '3000';
