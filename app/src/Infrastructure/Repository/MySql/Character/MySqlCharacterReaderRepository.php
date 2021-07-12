<?php

namespace App\Infrastructure\Repository\MySql\Character;

use App\Domain\Character\CharacterFactory;
use App\Domain\Character\CharacterReaderRepositoryInterface;
use App\Domain\Relations\RelationFactory;
use App\Infrastructure\Repository\MySql\MySqlAbstractRepository;

class MySqlCharacterReaderRepository extends MySqlAbstractRepository implements CharacterReaderRepositoryInterface
{
    public function listArrayOfIds(int $offset, int $limit, ?string $search): array
    {
        $filter = "";
        $parameters = [];

        if ($search !== null) {
            $filter = "WHERE c.name LIKE :search";
            $parameters[':search'] = "%" . $search . "%";
        }

        $sql = sprintf(
            "SELECT c.id FROM got.characters c %s LIMIT %d, %d",
            $filter,
            $offset,
            $limit
        );

        return $this->pdo->query($sql, $parameters, false, true);
    }

    public function getCharactersData(int ...$ids): array
    {
        $parameters = [];
        $this->buildIdParameters($parameters, ...$ids);

        $sql = sprintf(
            "SELECT c.id, c.name, c.link, c.thumbnail, c.full_image, c.nickname, c.royal, h.name as houseName,
            ca.name as actorName, ca.link as actorLink, ca.seasons as actorSeasons
            FROM got.characters c
            LEFT JOIN got.characters_houses ch ON ch.character_id = c.id
            LEFT JOIN got.houses h ON h.id = ch.house_id
            LEFT JOIN got.characters_actors ca ON ca.character_id = c.id
            WHERE c.id IN (%s);",
            join(",", array_keys($parameters))
        );

        return CharacterFactory::fromMysqlRows($this->pdo->query($sql, $parameters));
    }

    public function getCharactersRelations(int ...$ids): array
    {
        $parameters = [];
        $this->buildIdParameters($parameters, ...$ids);

        $sql = sprintf(
            "SELECT cr.character_id, cr.related_to_id, c.name as character_name, crel.name as related_name,
            cr.relation
            FROM got.characters_relations cr
            LEFT JOIN got.characters c ON c.id = cr.character_id
            LEFT JOIN got.characters crel ON crel.id = cr.related_to_id
            WHERE cr.character_id IN (%s) OR cr.related_to_id IN (%s)",
            join(",", array_keys($parameters)),
            join(",", array_keys($parameters))
        );

        return RelationFactory::fromMysqlRows($this->pdo->query($sql, $parameters));
    }
}