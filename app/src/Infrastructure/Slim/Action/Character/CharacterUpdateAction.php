<?php

namespace App\Infrastructure\Slim\Action\Character;

use App\Application\Request\Character\CharacterUpdateRequest;
use App\Application\UseCase\Character\CharacterUpdateUseCase;
use App\Domain\Character\CharacterFactory;
use App\Infrastructure\Slim\Action\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class CharacterUpdateAction extends Action
{
    private CharacterUpdateUseCase $characterUpdateUseCase;

    public function __construct(CharacterUpdateUseCase $characterUpdateUseCase, LoggerInterface $logger)
    {
        $this->characterUpdateUseCase = $characterUpdateUseCase;
        parent::__construct($logger);
    }

    protected function action(): Response
    {
        $parsedBody = $this->request->getParsedBody();
        $parsedBody['id'] = $this->request->getAttribute('id');
        return $this->respondWithData([
            'success' => $this->characterUpdateUseCase->update(
                new CharacterUpdateRequest(
                    CharacterFactory::fromRequestData($parsedBody),
                    isset($parsedBody['updateHouses']) && $parsedBody['updateHouses'] == 1,
                    isset($parsedBody['updateActors']) && $parsedBody['updateActors'] == 1,
                    isset($parsedBody['updateRelations']) && $parsedBody['updateRelations'] == 1
                )
            )
        ]);
    }
}