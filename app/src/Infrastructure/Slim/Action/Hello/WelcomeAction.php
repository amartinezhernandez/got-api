<?php
declare(strict_types=1);

namespace App\Infrastructure\Slim\Action\Hello;

use App\Infrastructure\Slim\Action\Action;
use Psr\Http\Message\ResponseInterface as Response;

class WelcomeAction extends Action
{
    protected function action(): Response
    {
        return $this->respondWithData([
            'message' => 'Welcome to Game of Thrones API!'
        ]);
    }
}
