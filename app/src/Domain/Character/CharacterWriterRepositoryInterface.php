<?php

namespace App\Domain\Character;

use App\Domain\Actor\Actor;
use App\Domain\Relations\Relation;

interface CharacterWriterRepositoryInterface
{
    public function create(Character $character): int;
    public function update(Character $character): bool;
    public function addHouses(int $characterId, int ...$houseIds): bool;
    public function addActors(int $characterId, Actor ...$actors): bool;
    public function addRelations(int $characterId, Relation ...$relations): bool;
    public function delete(int $id): bool;
}