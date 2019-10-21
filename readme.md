# Social-Forum [![Build Status](https://travis-ci.org/hamza094/Social-Forum.svg?branch=master)](https://travis-ci.org/hamza094/Social-Forum)
This is an open source forum that is built in Laravel and Vue.js designed with Sass.

# Installation
## Step 1.
To run this project, you must have PHP 7 installed as a prerequisite.

Begin by cloning this repository to your machine, and installing all Composer dependencies.

- git clone https://github.com/hamza094/Social-Forum.git
- cd socialforum && composer install
- php artisan key:generate
- mv .env.example .env

If you want use Redis as your cache driver you need to install the Redis Server. You can either use homebrew on a Mac or compile from source (https://redis.io/topics/quickstart).
## Step 2.
Next, create a new database and reference its name and username/password within the project's .env file. In the example below, we've named the database, "socialforum"

- DB_CONNECTION=mysql
- DB_HOST=127.0.0.1
- DB_PORT=3306
- DB_DATABASE=socialforum
- DB_USERNAME=root
- DB_PASSWORD=
## Step 3.
reCAPTCHA is a Google tool to help prevent forum spam. You'll need to create a free account (don't worry, it's quick).

https://www.google.com/recaptcha/intro/

Choose reCAPTCHA V2, and specify your local (and eventually production) domain name.

Once submitted, you'll see two important keys that should be referenced in your .env file.

- RECAPTCHA_KEY=PASTE_KEY_HERE
- RECAPTCHA_SECRET=PASTE_SECRET_HERE
## Step 4.
- Edit config/forum.php, and add any email address that should be marked as an administrator.
- Use an administration portal to add channels.

For live view visit site https://doask.herokuapp.com/threads
