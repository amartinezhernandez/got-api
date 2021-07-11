<?php
declare(strict_types=1);

use App\Infrastructure\Repository\MySql\Character\MySqlCharacterWriterRepository;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

return static function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        MySqlCharacterWriterRepository::class => function (ContainerInterface $c) {
            return new MySqlCharacterWriterRepository();
        }
    ]);
};
