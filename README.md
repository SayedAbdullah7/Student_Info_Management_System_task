<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

----------

# Getting started

## Installation

Clone the repository

    git clone https://github.com/SayedAbdullah7/Student_Info_Management_System_task.git

Switch to the repo folder

    cd Student_Info_Management_System_task

Install all the dependencies using composer

    composer install

Create a new database called “students” Then import the file "students.sql" in it

Another option :
Run the database migrations and  database seeder

        php artisan migrate 
    
        php artisan db:seed

Install and run front-end dependencies using npm

        npm install

&

        npm run build


Start the local development server

    php artisan serve

    You can now access the server at http://127.0.0.1:8000/


## Steps to Upload The Project on a Host


### Steps

1. **Prepare The Project**
    - Run `composer install --optimize-autoloader --no-dev` to install production dependencies.
    - Run `php artisan config:cache` to cache the configuration.
    - Run `php artisan route:cache` to cache the routes.
    - Run `php artisan view:cache` to cache the views.
    - Run `npm install && npm run build` to install fron end dependencies.
    - Ensure your `.env` file is properly configured for the production environment.

2. **Create a Database on Your Hosting Server**
    - Log in to your hosting control panel (e.g., cPanel).
    - Create a new MySQL database and user, and assign the user to the database with the necessary permissions.
    - Import students.sql file
    - Update `.env` file with the new database credentials.

3. **Upload The Project**
    - Compress the project directory into a `.zip` file.
    - Extract the `.zip` file into the desired directory on your hosting server (usually the `public_html` directory or a subdirectory).

4. **Set Up Environment Variables**
    - Ensure the `.env` and  `.htaccess`  is uploaded to your hosting server.
    - Double-check that the `.env` file has the correct settings for the production environment.

