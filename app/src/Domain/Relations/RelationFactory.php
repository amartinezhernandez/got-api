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

    public static function fromRequestData(array $relations): array
    {
        return array_map(function ($relation) {
            $isPassiveRelation = isset($relation['passive']) && $relation['passive'] == 1;
            return new Relation(
                $isPassiveRelation ? $relation['character_id'] : null,
                null,
                $isPassiveRelation ? null : $relation['character_id'],
                null,
                $relation['relation']
            );
        }, $relations);
    }
}