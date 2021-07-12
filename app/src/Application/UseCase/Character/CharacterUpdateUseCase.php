<?php

namespace App\Application\UseCase\Character;

use App\Application\Request\Character\CharacterUpdateRequest;
use App\Domain\Character\CharacterWriterRepositoryInterface;

class CharacterUpdateUseCase
{
    private CharacterWriterRepositoryInterface $characterWriterRepository;

    public function __construct(
        CharacterWriterRepositoryInterface $characterWriterRepository
    ) {
        $this->characterWriterRepository = $characterWriterRepository;
    }

    public function update(CharacterUpdateRequest $request): bool
    {
        $updated = $this->characterWriterRepository->update($request->character());
        if ($request->updateHouses()) {
            $this->characterWriterRepository->addHouses($request->character()->id(), ...$request->character()->houses());
        }
        if ($request->updateActors()) {
            $this->characterWriterRepository->addActors($request->character()->id(), ...$request->character()->actors());
        }
        if ($request->updateRelations()) {
            $this->characterWriterRepository->addRelations($request->character()->id(), ...$request->character()->relations());
        }

        return $updated;
    }
}