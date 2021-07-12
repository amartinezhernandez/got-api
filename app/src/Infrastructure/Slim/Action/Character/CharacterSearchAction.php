<?php

namespace App\Infrastructure\Slim\Action\Character;

use App\Infrastructure\Slim\Action\Action;
use Psr\Http\Message\ResponseInterface as Response;

class CharacterSearchAction extends Action
{
    protected function action(): Response
    {
        return $this->respondWithData([
            'message' => 'I will search characters by name'
        ]);
    }
}