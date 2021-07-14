<?php

use App\Infrastructure\Commands\CharacterElasticSearchGenerateCommand;
use App\Infrastructure\Repository\MySql\Character\MySqlCharacterReaderRepository;
use DI\ContainerBuilder;
use Elasticsearch\Client;
use Symfony\Component\Console\Application;

require __DIR__ . '/../vendor/autoload.php';

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

if (isset($env) && $env === 'production') {
    $containerBuilder->enableCompilation(__DIR__ . '/../var/cache');
}

// Set up settings
$settings = require __DIR__ . '/../config/settings.php';
$settings($containerBuilder);

// Set up dependencies
$dependencies = require __DIR__ . '/../config/dependencies.php';
$dependencies($containerBuilder);

// Set up usecases
$usecases = require __DIR__ . '/../config/usecases.php';
$usecases($containerBuilder);

// Set up repositories
$repositories = require __DIR__ . '/../config/repositories.php';
$repositories($containerBuilder);

// Build PHP-DI Container instance
$container = $containerBuilder->build();

$consoleApp = new Application();
$consoleApp->add(new CharacterElasticSearchGenerateCommand(
    $container->get(Client::class),
    $container->get(MySqlCharacterReaderRepository::class)
));
$consoleApp->run();
