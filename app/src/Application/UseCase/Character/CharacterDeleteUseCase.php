<?php

namespace App\Application\UseCase\Character;

use App\Domain\Character\CharacterWriterRepositoryInterface;

class CharacterDeleteUseCase
{
    private CharacterWriterRepositoryInterface $characterWriterRepository;

    public function __construct(
        CharacterWriterRepositoryInterface $characterWriterRepository
    ) {
        $this->characterWriterRepository = $characterWriterRepository;
    }

    public function delete(int $id): bool
    {
        return $this->characterWriterRepository->delete($id);
    }
}