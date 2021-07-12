<?php
declare(strict_types=1);

use App\Infrastructure\Repository\MySql\Character\MySqlCharacterReaderRepository;
use App\Infrastructure\Repository\MySql\Character\MySqlCharacterWriterRepository;
use App\Infrastructure\Repository\MySql\PDODataAccess;
use App\Infrastructure\Slim\Setting\ConfigLoader;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

return static function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        PDODataAccess::class => function (ContainerInterface $c) {
            $host = $c->get(ConfigLoader::class)->get("DB_HOSTNAME");
            $charset = $c->get(ConfigLoader::class)->get("DB_CHARSET");
            $port = $c->get(ConfigLoader::class)->get("DB_PORT");
            $database = $c->get(ConfigLoader::class)->get("DB_DATABASE");
            $username = $c->get(ConfigLoader::class)->get("DB_USERNAME");
            $password = $c->get(ConfigLoader::class)->get("DB_PASSWORD");

            $dsn = "mysql:host={$host};charset={$charset};port={$port};dbname={$database}";

            return new PDODataAccess($dsn, $username, $password);
        },
        MySqlCharacterWriterRepository::class => function (ContainerInterface $c) {
            return new MySqlCharacterWriterRepository($c->get(PDODataAccess::class));
        },MySqlCharacterReaderRepository::class => function (ContainerInterface $c) {
            return new MySqlCharacterReaderRepository($c->get(PDODataAccess::class));
        },
    ]);
};
