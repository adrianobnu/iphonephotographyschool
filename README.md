# Iphone Photography School

# Youtube video explaining the project

I have created an small explanation of how to use this project, and how to run it. The logic, code and some testing. Its an 9 minutes long video, but you can fast forward the video.

https://www.youtube.com/watch?v=AGa5nrPceyY

This project has created using Laravel, Laravel Actions, Laravel Sail, Laravel Octane, Laravel Filament and PEST.

## How to run this project

You dont need to change anything in the code. I have hardcoded the .env file to make more easier to run.

### Install the composer dependencies

```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

### Run the Laravel Sail Up

```
./vendor/bin/sail up -d
```

### Run the Migrations and Seeders

```
./vendor/bin/sail artisan migrate --seed
```

## How to run test commands

You can use these commands to dispatch the events that you want to test.

### Lesson Watched

```
./vendor/bin/sail artisan lesson:watched
```

### Comment Written

```
./vendor/bin/sail artisan comment:written
```

## How to run the PEST tests

```
./vendor/bin/sail artisan test
```

## How to access the Filament Admin Panel

Just go to the root page and press enter in the login form (the username and password are already filled):

```
http://localhost
```
