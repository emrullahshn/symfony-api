### Prerequisites
* [Docker](https://www.docker.com/)

### Container
 - [nginx](https://hub.docker.com/_/nginx/) 1.15.+
 - [php-fpm](https://hub.docker.com/_/php/) 7.2.+
    - [composer](https://getcomposer.org/) 
    - [yarn](https://yarnpkg.com/lang/en/) and [node.js](https://nodejs.org/en/) (if you will use [Encore](https://symfony.com/doc/current/frontend/encore/installation.html) for managing JS and CSS)
- [mysql](https://hub.docker.com/_/mysql/) 5.7.+
- [redis]()

### Installing

run docker and connect to container:
```
 docker-compose build
```
```
 docker-compose up -d
```
```
 docker-compose exec php sh
```
```
 composer install
```
```
 bin/console doctrine:migrations:migrate
```
```
 bin/console doctrine:fixtures:load
```

configure the database connection information in your root directory `.env` 
```
DATABASE_URL=mysql://root:root@mysql:3306/symfony
```

call localhost in your browser:
- [http://localhost](http://localhost/)

### Notlar

- Redis host/port static yazılmış. .env'ye yazılıp DependencyInjection ile inject etmek daha doğru.
- Password kontrolü UserController içinde yapılmış. TokenAuth'da yapmak daha doğru çünkü hem bunun için bir metod var hemde elimizde User var. Tekrar db'ye gitmeye gerek yok.
- Errorlar için bir service yazıalbilir "message" ve "statusCode" alacak şekilde.
