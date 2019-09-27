# laravel-api-boilerplate

This is a boilerplate for writing RESTful API projects using Laravel. This Boilerplate is a "starter kit" you can use to build your first API in seconds. As you can easily imagine, it is built on top of the awesome Laravel Framework. This version is built on Laravel 6.0!

##### Packages:

* JWT-Auth - [tymondesigns/jwt-auth](https://github.com/tymondesigns/jwt-auth)
* Laravel-CORS [barryvdh/laravel-cors](http://github.com/barryvdh/laravel-cors)


## Features

* Ready To use User Authentications
* Authentication with JWT
* Basic Features: Register, Login, Update Profile & Password
* Json API Format response.



## Installation

First, clone the repo:
```
$ git clone https://github.com/kennethtomagan/laravel-api-boilerplate.git
```
#### Install dependencies

```
$ cd laravel-api-boilerplate.git
$ composer install
```

#### Configure the Environment
Create `.env` file:
```
$ cat .env.example > .env
```
Run `php artisan key:generate` and `php artisan jwt:secret`

#### Migrations and Seed the database
```
$ php artisan migrate:fresh --seed
```


## Route API Endpoint

| Verb     |       URI                  |       Controller          |      Notes                                |
| -------- | -------------------------  | -----------------------   | ------------------------------------------
| POST     | `api/v1/auth`              |  AuthController           | to do the login and get your access token
| POST     | `api/v1/register`          |  RegisterController       | to create a new user into your application
| POST     | `api/v1/recovery`          |  ForgotPasswordController | to recover your credentials;
| POST     | `api/v1/reset`             |  ResetPasswordController  | to reset your password after the recovery (setup your mail credentials in `.env` file to avoid error);
| POST     | `api/v1/logout`            |  LogoutController         | to log out the user by invalidating the passed token;
| GET      | `api/v1/profile`           |  ProfileController        | to get current user data
| PUT      | `api/v1/profile`           |  ProfileController        | to update current user data
| PUT      | `api/v1/profile/password`  |  ProfileController        | to update current user password
