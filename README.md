# HervestSolutions Shop

Fully functional e-commerce platform tailored for agricultural products

## [🔗 CLICK TO SEE IT LIVE](https://hervestsolutionsshop.rafaljagielski.pl)

## Table of Contents

[⚓General Informations](#general-informations)

[⚓Technologies](#technologies)

[⚓Build Setup](#built-setup)

## General Informations

A fully functional e-commerce platform, offering features for product presentation, searching, and filtering, adding to cart, order fulfillment, account registration, user profile editing, and viewing order history.

## Technologies

List of technologies used to build the app:

<a href="https://symfony.com"> <img src="https://github.com/rafJagCode/tech_icons/blob/main/symfony.png?raw=true" width="30" height="30" style="vertical-align:middle"/> Symfony</a> - set of reusable PHP components and a PHP framework to build web applications, APIs, microservices and web services.

<a href="https://twig.symfony.com"> <img src="https://raw.githubusercontent.com/rafJagCode/tech_icons/32d0af85f7d53e27326d220525646c6f9bc5d098/twig.svg" width="30" height="30" style="vertical-align:middle"/> Twig</a> - a modern template engine for PHP.

<a href="https://twig.symfony.com"> <img src="https://github.com/rafJagCode/tech_icons/blob/main/mysql.png?raw=true" width="30" height="30" style="vertical-align:middle"/> Mysql</a> - open-source relational database management system.

## Build Setup

- Clone repository

  ```sh
  git clone https://github.com/rafJagCode/hervestsolutions_shop.git
  ```

- Create and edit .env file

  ```sh
  cd hervestsolutions_shop
  cp .env.example .env
  vim .env
  ```

- Install dependencies

  ```sh
  composer install
  ```

- Run migrations

   ```sh
  php bin/console doctrine:migrations:diff
  php bin/console doctrine:migrations:migrate
  ```

- Seed db with categories, producers and products

   ```sh
  php bin/console seed-categories
  php bin/console seed-producers
  php bin/console seed-products
  ```

- Serve at localhost:8000
  
  [🔗 How to install symfony CLI](https://symfony.com/download)

  ```sh
  symfony server:start
  ```

## License

MIT


[symfony]: https://symfony.com
[twig]: https://twig.symfony.com
