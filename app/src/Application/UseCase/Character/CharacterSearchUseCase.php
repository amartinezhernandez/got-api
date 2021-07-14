<?php

namespace App\Application\UseCase\Character;

use App\Domain\Character\CharacterSearchReaderRepositoryInterface;

class CharacterSearchUseCase
{
    private CharacterSearchReaderRepositoryInterface $characterSearchReaderRepository;

    public function __construct(
        CharacterSearchReaderRepositoryInterface $characterSearchReaderRepository
    ) {
        $this->characterSearchReaderRepository = $characterSearchReaderRepository;
    }

    public function search(string $query): array
    {
        return $this->characterSearchReaderRepository->search($query);
    }
}
