<?php
declare(strict_types=1);

use App\Infrastructure\Slim\Action\Character\CharacterCreateAction;
use App\Infrastructure\Slim\Action\Character\CharacterDeleteAction;
use App\Infrastructure\Slim\Action\Character\CharacterListAction;
use App\Infrastructure\Slim\Action\Character\CharacterSearchAction;
use App\Infrastructure\Slim\Action\Character\CharacterUpdateAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return static function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', CharacterListAction::class);
    $app->get('/search', CharacterSearchAction::class);
    $app->post('/', CharacterCreateAction::class);
    $app->patch('/', CharacterUpdateAction::class);
    $app->delete('/{id}', CharacterDeleteAction::class);
};
