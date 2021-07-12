<?php

namespace App\Application\Request\Character;

use App\Domain\Character\Character;

class CharacterUpdateRequest
{
    private Character $character;
    private bool $updateHouses;
    private bool $updateActors;
    private bool $updateRelations;

    public function __construct(
        Character $character,
        bool $updateHouses,
        bool $updateActors,
        bool $updateRelations
    ) {
        $this->character = $character;
        $this->updateHouses = $updateHouses;
        $this->updateActors = $updateActors;
        $this->updateRelations = $updateRelations;
    }

    public function character(): Character
    {
        return $this->character;
    }

    public function updateHouses(): bool
    {
        return $this->updateHouses;
    }

    public function updateActors(): bool
    {
        return $this->updateActors;
    }

    public function updateRelations(): bool
    {
        return $this->updateRelations;
    }
}