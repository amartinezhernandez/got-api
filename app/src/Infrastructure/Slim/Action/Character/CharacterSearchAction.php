<?php

namespace App\Infrastructure\Slim\Action\Character;

use App\Application\UseCase\Character\CharacterSearchUseCase;
use App\Infrastructure\Slim\Action\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class CharacterSearchAction extends Action
{
    private CharacterSearchUseCase $characterSearchUseCase;

    public function __construct(CharacterSearchUseCase $characterSearchUseCase, LoggerInterface $logger)
    {
        $this->characterSearchUseCase = $characterSearchUseCase;
        parent::__construct($logger);
    }

    protected function action(): Response
    {
        return $this->respondWithData([
            'characters' => $this->characterSearchUseCase->search($this->request->getQueryParams()['search'])
        ]);
    }
}
