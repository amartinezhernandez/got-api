<?php

namespace App\Domain\Character;

interface CharacterSearchReaderRepositoryInterface
{
    public function search(string $search): array;
}
