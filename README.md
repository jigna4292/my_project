#Symfony Assignment

1) Create Folder where you want to add files and open CMD and add command git clone https://github.com/jigna4292/my_project.git

2) Open .env file and add your local database configuration and db version
like : DATABASE_URL=mysql://root:@127.0.0.1:3306/symfony_db?serverVersion=mariadb-10.1.30

3) Open CMD and add command 
Some basic Git commands are:
```
composer install
```

4) Create Database using symfony command and also migrate the database details
Some basic Git commands are:
```
For DB Creation : php bin/console doctrine:database:create
For Migration : php bin/console doctrine:migrations:migrate
```

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
6) Open browser hit : http://127.0.0.1:8000/admin/
and add data for each entity 
7) Finally you can see the http://127.0.0.1:8000/ here :)
