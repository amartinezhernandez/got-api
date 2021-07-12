<?php

namespace App\Domain\Actor;

class ActorFactory
{
    public static function fromMysqlRowsOrRequest(array $actors): array
    {
        return array_map(function ($actor) {
            return self::fromMysqlRowOrRequest($actor);
        }, $actors);
    }

    public static function fromMysqlRowOrRequest(array $actor): Actor
    {
        return new Actor(
            $actor['name'],
            $actor['link'],
            $actor['seasons']
        );
    }
}