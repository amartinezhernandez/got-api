<?php

namespace App\Application\UseCase\Character;

use App\Application\Request\ListRequest;
use App\Domain\Character\CharacterReaderRepositoryInterface;
use App\Domain\Relations\RelationsBuilderDomainService;

class CharacterListUseCase
{
    private CharacterReaderRepositoryInterface $characterReaderRepository;

    public function __construct(
        CharacterReaderRepositoryInterface $characterReaderRepository
    ) {
        $this->characterReaderRepository = $characterReaderRepository;
    }

    public function list(ListRequest $request): array
    {
        $ids = $this->characterReaderRepository->listArrayOfIds($request->offset(), $request->limit(), $request->search());

        if (count($ids) === 0) {
            return [];
        }

        $characters = $this->characterReaderRepository->getCharactersData(...$ids);
        $relations = $this->characterReaderRepository->getCharactersRelations(...$ids);

        return RelationsBuilderDomainService::buildRelationsForMultipleCharacters($characters, $relations);
    }
}