# laravelBa

**laravelBa** is an MVP solution using Laravel 10, InertiaJS and Vue3, powered by Vite, SCSS, TailwindCSS and PrimeVue.
It has support for authentication, authorization, user management and product management.

## Menu
1. [Installation](#installation)
    1. [Install dependencies](#install-dependencies)
    2. [Setting up](#setting-up)
        1. [Optional setup](#optional-setup)
    3. [Go Diego Go](#go-diego-go)
        1. [Login](#login)

## Installation
First of all, clone or download this repository and follow this step-by-step installation guide.

### Install dependencies
Run the following commands
```
composer install
```

```
npm install
```

### Setting up
First you need to make a copy of **.env.example** and name it **.env**.

Update your **.env** file to set up database connection.

Run the following commands
```
php artisan app:setup
```
```
npm run build
```

#### Optional setup

You could set up the solution with dummy data running the **app:setup** command with the following variation
```
php artisan app:setup --use-dummy
```

Inside the **.env** file there are two variables to define the amount of dummy data to generate with this setting.
```
DUMMY_DATA_SEEDER_USERS_QUANTITY=2
DUMMY_DATA_SEEDER_PRODUCTS_QUANTITY=5
```

### Go Diego Go

*Go for the money.* -says Diego-

Run the following command
```
php artisan serve
```
And access to the URL provided (Example: http://127.0.0.1:8000)

#### Login

There are at least two users created.

A manager user (Chief Manager) with the following credentials

```
manager@laravelba.com
```
```
manager
```

A revisor user (Chief Revisor) with the following credentials

```
revisor@laravelba.com
```
```
revisor
```
