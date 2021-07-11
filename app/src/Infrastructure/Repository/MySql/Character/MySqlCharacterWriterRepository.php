<?php

namespace App\Infrastructure\Repository\MySql\Character;

use App\Domain\Character\CharacterWriterRepositoryInterface;
use App\Infrastructure\Repository\MySql\MySqlAbstractRepository;
use Exception;

class MySqlCharacterWriterRepository extends MySqlAbstractRepository implements CharacterWriterRepositoryInterface
{
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