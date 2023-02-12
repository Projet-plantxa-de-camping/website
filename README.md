<h2 align="center">Plantxa camping</h2>

<p align="center">
symfony server:start
 website to remotely manage a camping pantxa
</p>


![Language](https://img.shields.io/badge/language-php-797db2.svg?style=flat)
![Language](https://img.shields.io/badge/language-symfony-000000.svg?style=flat)
![Language](https://img.shields.io/badge/language-twig-bccf28.svg?style=flat)
![Language](https://img.shields.io/badge/language-javascript-efd81d.svg?style=flat)

## Install & Run Project

   ```sh
    $ git clone [ssh]
    $ composer install && npm install && npm run build
    $ // edit db url in .env and create database
    $ symfony console doctrine:migration:migrate // create all tables
    $ symfony console doctrine:fixtures:load // execute seeders
    $ symfony server:start
   ```
