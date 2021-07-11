<?php

namespace App\Domain\Character;

interface CharacterWriterRepositoryInterface
{
    public function delete(int $id): bool;
}