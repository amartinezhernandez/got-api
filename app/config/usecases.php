<?php
declare(strict_types=1);

use App\Application\UseCase\Character\CharacterCreateUseCase;
use App\Application\UseCase\Character\CharacterDeleteUseCase;
use App\Application\UseCase\Character\CharacterListUseCase;
use App\Application\UseCase\Character\CharacterUpdateUseCase;
use App\Infrastructure\Repository\MySql\Character\MySqlCharacterReaderRepository;
use App\Infrastructure\Repository\MySql\Character\MySqlCharacterWriterRepository;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

return static function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        CharacterDeleteUseCase::class => function (ContainerInterface $c) {
            return new CharacterDeleteUseCase($c->get(MySqlCharacterWriterRepository::class));
        },
        CharacterListUseCase::class => function (ContainerInterface $c) {
            return new CharacterListUseCase($c->get(MySqlCharacterReaderRepository::class));
        },
        CharacterCreateUseCase::class => function (ContainerInterface $c) {
            return new CharacterCreateUseCase($c->get(MySqlCharacterWriterRepository::class));
        },
        CharacterUpdateUseCase::class => function (ContainerInterface $c) {
            return new CharacterUpdateUseCase($c->get(MySqlCharacterWriterRepository::class));
        },
    ]);
};
