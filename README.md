# Minesweeper

An implementation of Minesweeper in PHP.

### Installation (using PHP)

Environment requirements:

- Git
- PHP >= 7.2

Setting up environment on your local machine:

```bash
$ git clone https://github.com/ahsanatiq/minesweeper.git
$ cd minesweeper
$ composer install
$ ./bin/minesweeper
```

Run unit-tests:

```bash
$ cd minesweeper
$ ./vendor/bin/phpunit
```


### Installation (using Docker)

Environment requirements:

- Git
- Docker >= 17.06 CE
- Docker Compose

Setting up environment on your local machine:

```bash
$ git clone https://github.com/ahsanatiq/minesweeper.git
$ cd minesweeper
$ docker-compose up -d
$ docker exec -it minesweeper-php-fpm composer install
$ docker exec -it minesweeper-php-fpm bash /var/www/bin/minesweeper
```
Run the unit-tests in the minesweeper-php-fpm container:

```bash
$ docker exec -it minesweeper-php-fpm bash /var/www/vendor/bin/phpunit
```
