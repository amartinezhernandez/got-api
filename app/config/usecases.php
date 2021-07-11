<?php
declare(strict_types=1);

use App\Application\UseCase\Character\CharacterDeleteUseCase;
use App\Infrastructure\Repository\MySql\Character\MySqlCharacterWriterRepository;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

return static function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        CharacterDeleteUseCase::class => function (ContainerInterface $c) {
            return new CharacterDeleteUseCase($c->get(MySqlCharacterWriterRepository::class));
        }
    ]);
};
