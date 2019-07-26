<?php

require_once __DIR__ . '/../vendor/autoload.php';


$container = \Illuminate\Container\Container::getInstance();

if (file_exists($envFile = __DIR__ . '/../.env')) {
    loadEnvironmentFromFile($envFile);
}


// bind configuration to the container
$container->singleton('Illuminate\Config\Repository', function () {
    $configItems = [];
    $finder = (new \Symfony\Component\Finder\Finder)->files()->in(__DIR__.'/../config/');
    foreach ($finder as $file) {
        $configItems = array_merge($configItems, [
        $file->getBasename('.php') => require($file->getRealPath())
        ]);
    }
    return new Illuminate\Config\Repository($configItems);
});
$container->alias('Illuminate\Config\Repository', 'config');

// bind logger to the container
$container->singleton('Monolog\Logger', function ($container) {
    $config = $container->make('config');
    $logger = new \Monolog\Logger($config['app.name']);
    $formatter = new \Monolog\Formatter\LineFormatter(null, null, false, true);
    $handler = new \Monolog\Handler\RotatingFileHandler(
        $config['logger.file'],
        $config['logger.days'],
        constant('\Monolog\Logger::'.strtoupper($config['logger.level']))
    );
    $handler->setFormatter($formatter);
    $logger->pushHandler($handler);
    return $logger;
});
$container->alias('Monolog\Logger', 'logger');

// bind climate
$container->singleton('League\CLImate\CLImate');

// bind dependencies
$container->bind('Minesweeper\Interfaces\GameInterface', 'Minesweeper\Game');
$container->bind('App\Commands\MinesweeperCommand');
