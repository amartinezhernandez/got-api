<?php

namespace Tests\Infrastructure\Slim\Action\Character;

use App\Infrastructure\Slim\Action\ActionPayload;
use Tests\Infrastructure\Slim\Action\ActionTestCase;

class CharacterDeleteActionTest extends ActionTestCase
{
    public function testActionDeleteInvalidId(): void
    {
        $expectedPayload = new ActionPayload(200, [
            'success' => false
        ]);

        $this->launchTest("DELETE", "/78877878", $expectedPayload);
    }

    public function testActionDelete(): void
    {
        $expectedPayload = new ActionPayload(200, [
            'success' => true
        ]);

        $this->launchTest("DELETE", "/4", $expectedPayload);

        // Check if it has been deleted
        $this->deletedTest();
    }

    private function deletedTest(): void
    {
        $expectedPayload = new ActionPayload(200, [
            'characters' => [],
        ]);

        $this->launchTest("GET", "/", $expectedPayload, "search=Aerys II Targaryen");
    }
}
