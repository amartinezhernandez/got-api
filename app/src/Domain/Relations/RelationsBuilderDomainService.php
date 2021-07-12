<?php

namespace App\Domain\Relations;

use App\Domain\Character\Character;

class RelationsBuilderDomainService
{
    public static function buildRelationsForMultipleCharacters(array $characters, array $relations): array
    {
        return array_map(function (Character $character) use ($relations) {
            $character->setRelations(self::findCharacterRelations($character->id(), $relations));
            return $character;
        }, $characters);
    }

    private static function findCharacterRelations(int $characterId, array $relations): array
    {
        $finalRelations = [];
        foreach ($relations as $relation) {
            if ($relation->characterId() == $characterId || $relation->relatedId() == $characterId) {
                $finalRelations[$relation->relationKey($characterId)][] = $relation->relationValue($characterId);
            }
        }

        return array_map(function ($finalRelation) {
            return array_values(array_unique($finalRelation, SORT_REGULAR));
        }, $finalRelations);
    }
}