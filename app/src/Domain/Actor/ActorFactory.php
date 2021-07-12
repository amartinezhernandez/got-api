<?php

namespace App\Domain\Actor;

class ActorFactory
{
    public static function fromMysqlRows(array $actors): array
    {
        return array_map(function ($actor) {
            return self::fromMysqlRow($actor);
        }, $actors);
    }

    public static function fromMysqlRow(array $actor): Actor
    {
        return new Actor(
            $actor['name'],
            $actor['link'],
            $actor['seasons']
        );
    }
}