<?php

namespace App\Infrastructure\Repository\MySql\Character;

use App\Domain\Character\CharacterWriterRepositoryInterface;

class MySqlCharacterWriterRepository implements CharacterWriterRepositoryInterface
{
    public function delete(int $id): bool
    {
        return true;
    }
}