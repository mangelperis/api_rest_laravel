## About Sesame-API

API that allows User and WorkEntry basic CRUD.

## Infrastructure used
* Laravel 9.4.1 (Laravel SAIL image)
* MySQL
* Docker
* PHP 8.4

## Third party libraries
* N/A

## Installation
Extract the zip files or clone the repository in your desired folder and then open a console window there.
First you need to grab permission to the system to write in logs & cache folders.
> sudo chmod 775 -R `folder`

> bootstrap/cache |
> storage |
> vendor/composer

Copy the .env.example to .env file for Laravel with your own desired parameters (optional)
> cp .env.example .env

Build & init docker container (https://laravel.com/docs/9.x/sail#starting-and-stopping-sail)

>./vendor/bin/sail up

Database creation is already automated in dockerfile - .env files

Enter/Log inside the container (as root) with
> docker ps
> docker exec -ti <container-name Or ID> bash

Run Migrations and seeder to fill tables with examples
> php artisan migrate:fresh --seed

Done!

## How it works ?

Once the container is up you can check all is OK going to the following addres (by default):
> http://localhost/

You'll see current Laravel & PHPVersion in a welcome page.

Use Postman or another cli in order to perform actions to each endpoint.

The list of available endpoints can be shown executing (while your logged inside the container) with:
> php artisan route:list

These are all the available endpoints:
```
GET|HEAD  api/user/all                  List all users
POST      api/user/create               Create a new user   
PUT       api/user/{user}               Update user by ID
DELETE    api/user/{user}               (Soft) Delete user by ID
GET|HEAD  api/user/{user}               Show user data by ID
GET|HEAD  api/user/{user}/workentry     List all user WorkEntries by UserID

POST      api/workentry/create          Create a new WorkEntry
PUT       api/workentry/{workentry}     Update WorkEntry by ID
DELETE    api/workentry/{workentry}     Delete WorkEntry by ID
GET|HEAD  api/workentry/{workentry}     Show WorkEntry Data by ID
```

Additionally, run all the tests available using (while your logged inside the container):
>./vendor/phpunit/phpunit/phpunit

## TroubleShooting
If an error like 

``Error in exception handler: The stream or file "/var/www/laravel/app/storage/logs/laravel.log" could not be opened: failed to open stream: Permission denied``

is prompted just take ownership of the `storage` folder to your user:group system info with
> sudo chown -R {user}:{group} ./storage 
