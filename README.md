# Minesweeper

An implementation of Minesweeper in PHP.

### Installation (using PHP)

Requirements:

- Git
- PHP >= 7.2
- Composer

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
$ docker exec -it minesweeper-php-fpm /var/www/bin/minesweeper
```

Run the unit-tests in the minesweeper-php-fpm container:

```bash
$ docker exec -it minesweeper-php-fpm /var/www/vendor/bin/phpunit
```

### Running (command-line options)

By default the game will start with `20 rows x 30 columns` board and `25 mines/bombs`. But you can overide these settings using the following command-line parameters:

- -r, --rows[=ROWS] `number of rows of the board [default: 25]`

- -c, --columns[=COLUMNS] `number of columns of the board [default: 30]`
- -b, --bombs[=BOMBS] `number of hidden bombs in the board [default: 25]`

Examples:

```bash
./bin/minesweeper --rows=5 --columns=5 --bombs=10
```
```bash
./bin/minesweeper -r 5 -c 5 -b 10
```


