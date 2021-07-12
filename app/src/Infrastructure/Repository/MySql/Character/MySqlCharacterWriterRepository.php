<?php

namespace App\Infrastructure\Repository\MySql\Character;

use App\Domain\Actor\Actor;
use App\Domain\Character\Character;
use App\Domain\Character\CharacterWriterRepositoryInterface;
use App\Domain\Relations\Relation;
use App\Infrastructure\Repository\MySql\MySqlAbstractRepository;
use Exception;

class MySqlCharacterWriterRepository extends MySqlAbstractRepository implements CharacterWriterRepositoryInterface
{
    public function create(Character $character): int
    {
        $sql = "INSERT INTO got.characters (name,link,thumbnail,full_image,royal,nickname)
	    VALUES (:name,:link,:thumbnail,:full_image,:royal,:nickname);";

        $parameters = [
            ':name' => $character->name(),
            ':link' => $character->link(),
            ':thumbnail' => $character->thumbnail(),
            ':full_image' => $character->image(),
            ':royal' => $character->royal(),
            ':nickname' => $character->nickname()
        ];

        return $this->pdo->insert($sql, $parameters);
    }

    public function addHouses(int $characterId, int ...$houseIds): bool
    {
        $this->pdo->connect();
        $this->pdo->pdo()->beginTransaction();

        try {
            $parameters = [
                ':character_id' => $characterId
            ];

            // Delete old houses
            $sql = "DELETE FROM got.characters_houses WHERE character_id=:character_id;";
            $this->pdo->updateOrDelete($sql, $parameters);

            // Insert new houses if needed
            if (count($houseIds)) {
                $parameters = [];
                $this->buildIdParameters($parameters, ...$houseIds);
                $insertValues = [];
                foreach ($parameters as $key => $parameter) {
                    $insertValues[] = "(:character_id, {$key})";
                }
                $parameters[':character_id'] = $characterId;

                $sql = sprintf(
                    "INSERT INTO got.characters_houses (character_id,house_id) VALUES %s;",
                    join(",", $insertValues)
                );

                $this->pdo->insert($sql, $parameters);
            }

            $this->pdo->pdo()->commit();
            $this->pdo->close();
            return true;
        } catch (Exception $e) {
            $this->pdo->pdo()->rollBack();
            $this->pdo->close();
            return false;
        }
    }

    public function addActors(int $characterId, Actor ...$actors): bool
    {
        $this->pdo->connect();
        $this->pdo->pdo()->beginTransaction();

        try {
            $parameters = [
                ':character_id' => $characterId
            ];

            // Delete old actors
            $sql = "DELETE FROM got.characters_actors WHERE character_id=:character_id;";
            $this->pdo->updateOrDelete($sql, $parameters);

            // Insert new actors if needed
            if (count($actors)) {
                $insertValues = [];
                foreach ($actors as $key => $actor) {
                    $parameters[":name{$key}"] = $actor->name();
                    $parameters[":link{$key}"] = $actor->link();
                    $parameters[":seasons{$key}"] = count($actor->seasons()) ? json_encode($actor->seasons()) : null;
                    $insertValues[] = "(:character_id, :name{$key},:link{$key},:seasons{$key})";
                }
                $parameters[':character_id'] = $characterId;

                $sql = sprintf(
                    "INSERT INTO got.characters_actors (character_id,name,link,seasons)
	                VALUES %s;",
                    join(",", $insertValues)
                );

                $this->pdo->insert($sql, $parameters);
            }

            $this->pdo->pdo()->commit();
            $this->pdo->close();
            return true;
        } catch (Exception $e) {
            $this->pdo->pdo()->rollBack();
            $this->pdo->close();
            return false;
        }
    }

    public function addRelations(int $characterId, Relation ...$relations): bool
    {
        $this->pdo->connect();
        $this->pdo->pdo()->beginTransaction();

        try {
            $parameters = [
                ':character_id' => $characterId
            ];

            // Delete old relations. Related are also deleted as the relations are reciprocal
            $sql = "DELETE FROM got.characters_relations WHERE character_id=:character_id OR related_to_id=:character_id;";
            $this->pdo->updateOrDelete($sql, $parameters);

            // Insert new relations if needed
            if (count($relations)) {
                $parameters = [];
                $insertValues = [];
                foreach ($relations as $key => $relation) {
                    $parameters[":relation{$key}"] = $relation->relation();
                    // The only way it is null is because the other one is filled
                    $parameters[":character_id{$key}"] = $relation->characterId() ?? $characterId;
                    $parameters[":related_to_id{$key}"] = $relation->relatedId() ?? $characterId;
                    $insertValues[] = "(:character_id{$key}, :name{$key},:link{$key},:seasons{$key})";
                }
                $parameters[':character_id'] = $characterId;

                $sql = sprintf(
                    "INSERT INTO got.characters_relations (character_id,related_to_id,relation) VALUES %s;",
                    join(",", $insertValues)
                );

                $this->pdo->insert($sql, $parameters);
            }

            $this->pdo->pdo()->commit();
            $this->pdo->close();
            return true;
        } catch (Exception $e) {
            $this->pdo->pdo()->rollBack();
            $this->pdo->close();
            return false;
        }
    }

    public function delete(int $id): bool
    {
        $this->pdo->connect();
        $this->pdo->pdo()->beginTransaction();

        try {
            $parameters = [
                ':id' => $id
            ];

            // Delete character data
            $sql = "DELETE FROM got.characters WHERE id=:id LIMIT 1;";
            $this->pdo->updateOrDelete($sql, $parameters);

            // Delete character-house data
            $sql = "DELETE FROM got.characters_houses WHERE character_id=:id;";
            $this->pdo->updateOrDelete($sql, $parameters);

            // Delete character-relations data
            $sql = "DELETE FROM got.characters_relations WHERE character_id=:id OR related_to_id=:id;";
            $parameters = [
                ':id' => $id
            ];
            $this->pdo->updateOrDelete($sql, $parameters);

            $this->pdo->pdo()->commit();
            $this->pdo->close();
            return true;
        } catch (Exception $e) {
            $this->pdo->pdo()->rollBack();
            $this->pdo->close();
            return false;
        }
    }
}