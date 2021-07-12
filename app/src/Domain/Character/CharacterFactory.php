<?php

namespace App\Domain\Character;

use App\Domain\Actor\ActorFactory;

class CharacterFactory
{
    public static function fromMysqlRows(array $characters): array
    {
        $characters = self::formatMySqlCharactersRows($characters);
        return array_map(function ($character) {
            return self::fromMysqlRow($character);
        }, $characters);
    }

    public static function fromMysqlRow(array $character): Character
    {
        return new Character(
            $character['id'],
            $character['name'],
            $character['link'],
            $character['thumbnail'],
            $character['full_image'],
            $character['nickname'],
            $character['royal'] == 1,
            ActorFactory::fromMysqlRows($character['actors']),
            $character['houses']
        );
    }

    private static function formatMySqlCharactersRows(array $characters): array
    {
        $formattedCharacters = [];

        foreach ($characters as $character) {
            $alreadySetKey = array_search($character['id'], array_column($formattedCharacters, 'id'));

            $houses = $character['houseName'] !== null ? [$character['houseName']] : [];
            $actor = [];
            if ($character['actorName']) {
                $actor = [
                    [
                        'name' => $character['actorName'],
                        'link' => $character['actorLink'],
                        'seasons' => $character['actorSeasons']
                    ]
                ];
            }

            if ($alreadySetKey === false) {
                $formattedCharacters[] = [
                    'id' => $character['id'],
                    'name' => $character['name'],
                    'link' => $character['link'],
                    'thumbnail' => $character['thumbnail'],
                    'full_image' => $character['full_image'],
                    'nickname' => $character['nickname'],
                    'royal' => $character['royal'],
                    'houses' => $houses,
                    'actors' => $actor
                ];
            } else {
                $formattedCharacters[$alreadySetKey]['houses'] = array_unique(
                    array_merge($formattedCharacters[$alreadySetKey]['houses'], $houses)
                );
                $formattedCharacters[$alreadySetKey]['actors'] = array_unique(
                    array_merge($formattedCharacters[$alreadySetKey]['actors'], $actor),
                    SORT_REGULAR
                );
            }
        }
        return $formattedCharacters;
    }
}