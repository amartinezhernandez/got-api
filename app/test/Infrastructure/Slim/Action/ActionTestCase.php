<?php

namespace Tests\Infrastructure\Slim\Action;

use App\Infrastructure\Slim\Action\ActionPayload;
use DI\ContainerBuilder;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Request as SlimRequest;
use Slim\Psr7\Uri;

class ActionTestCase extends TestCase
{
    protected function getAppInstance(): App
    {
        // Instantiate PHP-DI ContainerBuilder
        $containerBuilder = new ContainerBuilder();

        // Container intentionally not compiled for tests.

        // Set up settings
        $settings = require __DIR__ . '/../../../../config/settings.php';
        $settings($containerBuilder);

        // Set up dependencies
        $dependencies = require __DIR__ . '/../../../../config/dependencies.php';
        $dependencies($containerBuilder);

        // Set up usecases
        $usecases = require __DIR__ . '/../../../../config/usecases.php';
        $usecases($containerBuilder);

        // Set up repositories
        $repositories = require __DIR__ . '/../../../../config/repositories.php';
        $repositories($containerBuilder);

        // Build PHP-DI Container instance
        $container = $containerBuilder->build();

        // Instantiate the app
        AppFactory::setContainer($container);
        $app = AppFactory::create();

        // Register middleware
        $middleware = require __DIR__ . '/../../../../config/middleware.php';
        $middleware($app);

        // Register routes
        $routes = require __DIR__ . '/../../../../config/routes.php';
        $routes($app);

        return $app;
    }

    protected function createRequest(
        string $method,
        string $path,
        array $headers = ['HTTP_ACCEPT' => 'application/json'],
        array $cookies = [],
        array $serverParams = [],
        string $query = ""
    ): Request {
        $uri = new Uri('', '', 80, $path, $query);
        $handle = fopen('php://temp', 'w+');
        $stream = (new StreamFactory())->createStreamFromResource($handle);

        $h = new Headers();
        foreach ($headers as $name => $value) {
            $h->addHeader($name, $value);
        }

        return new SlimRequest($method, $uri, $h, $cookies, $serverParams, $stream);
    }

    protected function launchTest(
        string $method,
        string $path,
        ActionPayload $expectedPayload,
        string $query = "",
        array $data = []
    ): void {
        $app = $this->getAppInstance();

        $request = $this->createRequest(
            $method,
            $path,
            ['HTTP_ACCEPT' => 'application/json'],
            [],
            [],
            $query
        );
        $request = $request->withParsedBody($data);
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        self::assertEquals($serializedPayload, $payload);
    }
}
