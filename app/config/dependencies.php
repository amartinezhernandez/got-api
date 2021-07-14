<?php

declare(strict_types=1);

use App\Infrastructure\Slim\Setting\ConfigLoader;
use App\Infrastructure\Slim\Setting\SettingsInterface;
use DI\ContainerBuilder;
use Elasticsearch\ClientBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return static function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        ConfigLoader::class => function (ContainerInterface $c) {
            return new ConfigLoader(__DIR__ . "/../env/env.json");
        },
        Elasticsearch\Client::class => function (ContainerInterface $c) {
            $host = $c->get(ConfigLoader::class)->get("ELASTIC_HOST");
            $port = $c->get(ConfigLoader::class)->get("ELASTIC_PORT");
            return ClientBuilder::create()->setHosts([$host . ":" . $port])->build();
        }
    ]);
};
