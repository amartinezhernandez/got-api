<?php
declare(strict_types=1);

use App\Infrastructure\Slim\Middleware\SessionMiddleware;
use Slim\App;

return static function (App $app) {
    $app->add(SessionMiddleware::class);
};
