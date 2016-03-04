# Shoes
### Created By: Conner Belvin
***
## Project Description:
The website was designed to demonstrate skill in many-to-many database relationships, where *many* stores have *many* brands, and *many* brands belong to *many* stores.

It was constructed using the following:
* PHP
* Twig & Silex
* MySQL
* HTML and CSS
* Tests ran using PHPUnit

***
## MySQL Commands:
1. Use `/Applications/MAMP/Library/bin/mysql --host=localhost -uroot -proot` to access the MySQL Shell.
2. `CREATE DATABASE shoes;`
3. `USE shoes;`
4. `CREATE TABLE stores (id serial PRIMARY KEY, name VARCHAR (100));`
5. `CREATE TABLE brands (id serial PRIMARY KEY, name VARCHAR (100));`
6. `CREATE TABLE brands_stores (id serial PRIMARY KEY, store_id INT, brand_id INT);`

***
## Installation:
To install php4 clone the following repository by:
1. Open up your terminal and type the following line:
`git clone https://github.com/heyconner/php4.git`
2. Use this line to change directories to the project folder: `cd php4`
3. In order to load the pages correctly make sure you run: `composer install`
3. Use this line to change into the web directory: `cd web`
4. Once you are in your web directory, run this line to start a local webserver `php -S localhost:8000`
5. Finally open your web browser and type `localhost:8000` into the URL bar of your browser to load the page.
***
## License
Copyright (c) 2016 Conner Belvin