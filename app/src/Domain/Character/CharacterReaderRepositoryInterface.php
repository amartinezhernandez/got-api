<?php

namespace App\Domain\Character;

interface CharacterReaderRepositoryInterface
{
    public function listArrayOfIds(?int $offset, ?int $limit, ?string $search): array;
    public function getCharactersData(int ...$ids): array;
    public function getCharactersRelations(int ...$ids): array;
}
