<?php

namespace App\Domain\Relations;

class RelationFactory
{
    public static function fromMysqlRows(array $relations): array
    {
        return array_map(function ($relation) {
            return self::fromMysqlRow($relation);
        }, $relations);
    }

    public static function fromMysqlRow(array $relation): Relation
    {
        return new Relation(
            $relation['character_id'],
            $relation['character_name'],
            $relation['related_to_id'],
            $relation['related_name'],
            $relation['relation']
        );
    }
}