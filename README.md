### Task Introduction
MedexSepeti is a multi-vendor marketplace built in Laravel and MySQL database. The business
owner requests to redesign the homepage of the consumer portal to be as the mentioned
wireframe.

The wireframe contains of a header and navigation bar for the main categories, then a wide slider to
navigate the Adv. products at the top of the page. The 4 remaining sections then should be
implemented as the following:

### Task Deliverables
1- Horizontal slider shows 5 products marked as” Special Offers”. (A total of 9 products can be
scrolled)

2- Horizontal slider shows 8 brands can be added by admin. (A total of 15 products can be
scrolled)

3- Horizontal slider shows 6 products with the title “The most viewed products” which is based
on the most viewed products. (A total of 15 products can be scrolled)

4- Horizontal slider shows 6 products with the title of “Products that just arrived” which
contains the user's last visited products. (A total of 15 products can be scrolled)

Task Description will follow in the next page.

### We require the following:
1. Create a new Laravel application.
2. Create the homepage as described above.
3. Create “products” table which at least contains the following fields:
- ID
- barcode
- name
- short description
- long description
- price
- quantity
- image
- Category ID
4. Create “categories” table to identify the main categories.
5. Connect the application with MySQL database.
6. Use the best architecture based on your experience.
### Development Stack:
- Latest version of laravel framework.
- Programing language PHP 8.1
- Relational-Database
- mysql driver version 8
### Development Packages:
- laravel/octane
- spatie/laravel-medialibrary
- spatie/laravel-query-builder
- spiral/roadrunner
- laravel/telescope
## Installation

### Step 1.
- Begin by cloning this repository to your machine
```
git clone `repo url` 
```

- Install dependencies
```
composer install
```

- Create environmental file and variables
```
cp .env.example .env
```

- Generate app key
```
php artisan key:generate
```

### Step 2
- Next, create a new database and reference its name and username/password in the project's .env file.
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database_name
DB_USERNAME=root
DB_PASSWORD=your_password
```

- Run migration
```
php artisan migrate or php artisan migrate:fresh
```

### Step 3
- before start, you need to run table seeders
```
php artisan db:seed
```

### Step 4
- To start the server, run the command below
```
php artisan serve
```

## Application Route
```
http://127.0.0.1:8000
```
## Author
- ibrahim khalaf
