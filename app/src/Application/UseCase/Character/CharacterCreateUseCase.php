<?php

namespace App\Application\UseCase\Character;

use App\Domain\Character\Character;
use App\Domain\Character\CharacterWriterRepositoryInterface;

class CharacterCreateUseCase
{
    private CharacterWriterRepositoryInterface $characterWriterRepository;

    public function __construct(
        CharacterWriterRepositoryInterface $characterWriterRepository
    ) {
        $this->characterWriterRepository = $characterWriterRepository;
    }

    public function create(Character $character): int
    {
        $id = $this->characterWriterRepository->create($character);
        $this->characterWriterRepository->addHouses($id, ...$character->houses());
        $this->characterWriterRepository->addActors($id, ...$character->actors());
        $this->characterWriterRepository->addRelations($id, ...$character->relations());
        return $id;
    }
}