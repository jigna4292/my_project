#Symfony Assignment

Basics of selling the software products by the provider.

**Project Requirements**

* PHP 7.2 or above
* MySQL 5.7 or MariaDb 10.1.30
* Symfony 4.4
* Git
* Composer

**Find below steps for the setup :**

1) Create Folder where you want to add files and open CMD and add command
```
git clone https://github.com/jigna4292/my_project.git
```

2) Open .env file and add your local database configuration and db version
Line to edit in .env file for database configurations
```
DATABASE_URL=mysql://root:@127.0.0.1:3306/symfony_db?serverVersion=mariadb-10.1.30
```

3) Open CMD from your project folder location and add below command to install composer
```
composer install
```

4) Create Database using symfony command and also migrate the database details
Some basic Git commands are:
```
For DB Creation : php bin/console doctrine:database:create
For Migration : php bin/console doctrine:migrations:migrate
```
Note: 4 tables will create in your database, i.e Platform, Product, Provider and Software. 

5) Add entity class config/packages/easy_admin.yaml
Code for the mentioned file:
```
easy_admin:
    entities:
        # change the following to the namespaces of your own entities
        - App\Entity\Platform
        - App\Entity\Provider
        - App\Entity\Product
        - App\Entity\ProductPlatform
```

6) Start symfony server from CMD of your project location
```
symfony server:start
```
Note: Your project url will be http://127.0.0.1:8000 or http://localhost:8080. You can see the URl in to the success message of web server started.

8) Open browser hit : http://127.0.0.1:8000/admin/ to see the admin panel
Add data for each entity to see the website perfectly. 
Note: For image and File you can use external URL. 

9) Finally you can see the http://127.0.0.1:8000/ here :)
