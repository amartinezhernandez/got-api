<?php

namespace App\Infrastructure\Slim\Action\Character;

use App\Application\UseCase\Character\CharacterCreateUseCase;
use App\Domain\Character\CharacterFactory;
use App\Infrastructure\Slim\Action\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class CharacterCreateAction extends Action
{
    private CharacterCreateUseCase $characterCreateUseCase;

    public function __construct(CharacterCreateUseCase $characterCreateUseCase, LoggerInterface $logger)
    {
        $this->characterCreateUseCase = $characterCreateUseCase;
        parent::__construct($logger);
    }

    protected function action(): Response
    {
        return $this->respondWithData([
            'id' => $this->characterCreateUseCase->create(
                CharacterFactory::fromRequestData($this->request->getParsedBody()
                )
            )
        ]);
    }
}