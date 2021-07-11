<?php

namespace App\Infrastructure\Slim\Action\Character;

use App\Application\UseCase\Character\CharacterDeleteUseCase;
use App\Infrastructure\Slim\Action\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class CharacterDeleteAction extends Action
{
    private CharacterDeleteUseCase $characterDeleteUseCase;

    public function __construct(
        CharacterDeleteUseCase $characterDeleteUseCase,
        LoggerInterface $logger
    ) {
        $this->characterDeleteUseCase = $characterDeleteUseCase;
        parent::__construct($logger);
    }

    protected function action(): Response
    {
        return $this->respondWithData([
            'success' => $this->characterDeleteUseCase->delete($this->request->getAttribute('id'))
        ]);
    }
}