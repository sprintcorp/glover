# Getting started

## Brief description

The system is a marker-checker systems that revolves around the idea that for any change to be made to user
information by an administrator, it must be approved by a fellow administrator in order to take
effect; and if the request is declined, the change isn’t persisted.

## Features
- Send Email Notification
- Create User
- Update User
- Delete User

## Tools
- PHP 7.3
- Laravel 8 framework
- mysql
- Bootstrap


## Installation

Please check the official laravel installation guide for server requirements before you start.
[Official Documentation](https://laravel.com/docs/8.x/installation)


Clone the repository

    git clone https://github.com/sprintcorp/glover.git

Switch to the folder directory

    cd glover

Install all the dependencies using composer manager

    composer install


Copy the example env files and make the required configuration changes (database, queues and smtp connection)

    cp .env.example .env


Generate a new application key

    php artisan key:generate

Create database on local machine and set credentials to .env

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Populate the database with seed data with into the database

    php artisan db:seed

Start the local development server

    php artisan serve

You can now access the server at `http://127.0.0.1:8000`

Documentation link `https://documenter.getpostman.com/view/7305732/UzJESzEd`

Running The Queue Worker for sending emails

    php artisan queue:work

To run test use the command below. The initial command sets the application to test using
sqlite database and .env.testing

    php artisan config:cache --env=testing
    
    php artisan test

Switch to use .env with the command below

    php artisan config:cache --env=local

