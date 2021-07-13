<?php

namespace Tests\Infrastructure\Slim\Action\Character;

use App\Infrastructure\Slim\Action\ActionPayload;
use Tests\Infrastructure\Slim\Action\ActionTestCase;

class CharacterCreateActionTest extends ActionTestCase
{
    public function testActionCreate()
    {
        $expectedPayload = new ActionPayload(200, [
            'id' => 390
        ]);

        $this->launchTest("POST", "/", $expectedPayload, "", [
            'name' => 'FakeChar',
            'link' => 'https://fake.link',
            'thumbnail' => 'https://thumb.link',
            'full_image' => 'https://full_image.link',
            'nickname' => 'Faker',
            'royal' => 0,
            'actors' => [
                [
                    'name' => 'FakeActor1',
                    'link' => 'https://fake1.link',
                    'seasons' => [1, 2, 3]
                ],
                [
                    'name' => 'FakeActor2',
                    'link' => 'https://fake2.link',
                    'seasons' => [5]
                ],
            ],
            'houses' => [1, 3],
            'relations' => [
                ['passive' => 1, 'character_id' => 1, 'relation' => 'siblings'],
                ['passive' => 0, 'character_id' => 2, 'relation' => 'killer'],
            ]
        ]);

        // After this, let's test that it has been created
        $this->insertedTest();
    }

    private function insertedTest()
    {
        $expectedPayload = new ActionPayload(200, [
            'characters' => [
                [
                    "characterName" => "FakeChar",
                    "characterLink" => "https://fake.link",
                    "characterImageThumb" => "https://thumb.link",
                    "characterImageFull" => "https://full_image.link",
                    "nickname" => "Faker",
                    "siblings" => [
                        "Addam Marbrand"
                    ],
                    "killed" => [
                        "Aegon Targaryen"
                    ],
                    "houseName" => [
                        "Targaryen",
                        "Lannister"
                    ],
                    "actors" => [
                        [
                            "actorName" => "FakeActor1",
                            "actorLink" => "https://fake1.link",
                            "seasonsActive" => [
                                1,
                                2,
                                3
                            ]
                        ],
                        [
                            "actorName" => "FakeActor2",
                            "actorLink" => "https://fake2.link",
                            "seasonsActive" => [
                                5
                            ]
                        ]
                    ]

                ]
            ],
        ]);

        $this->launchTest("GET", "/", $expectedPayload, "search=FakeChar");
    }
}
