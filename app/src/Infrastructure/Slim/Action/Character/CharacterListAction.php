<?php

namespace App\Infrastructure\Slim\Action\Character;

use App\Application\Request\ListRequest;
use App\Application\UseCase\Character\CharacterListUseCase;
use App\Infrastructure\Slim\Action\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class CharacterListAction extends Action
{
    private CharacterListUseCase $characterListUseCase;

    private const DEFAULT_LIMIT = 20;

    public function __construct(
        CharacterListUseCase $characterListUseCase,
        LoggerInterface $logger
    ) {
        $this->characterListUseCase = $characterListUseCase;
        parent::__construct($logger);
    }

    protected function action(): Response
    {
        return $this->respondWithData(['characters' => $this->characterListUseCase->list($this->buildRequest())]);
    }

    private function buildRequest(): ListRequest
    {
        $params = $this->request->getQueryParams();
        return new ListRequest(
            $params['page'] ?? null,
            $params['limit'] ?? self::DEFAULT_LIMIT,
            $params['search'] ?? null
        );
    }
}