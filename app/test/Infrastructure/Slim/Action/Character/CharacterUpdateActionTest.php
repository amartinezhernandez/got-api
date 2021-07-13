<?php

namespace Tests\Infrastructure\Slim\Action\Character;

use App\Infrastructure\Slim\Action\ActionPayload;
use Tests\Infrastructure\Slim\Action\ActionTestCase;

class CharacterUpdateActionTest extends ActionTestCase
{
    /**
     * @dataProvider provider
     */
    public function testActionUpdate(int $id, array $newData, array $newResult): void
    {
        $expectedPayload = new ActionPayload(200, [
            'success' => true
        ]);

        $this->launchTest("PATCH", "/{$id}", $expectedPayload, "", $newData);

        // Test if updated
        $this->updatedTest($newResult);
    }

    private function updatedTest(array $result): void
    {
        $expectedPayload = new ActionPayload(200, [
            'characters' => [
                $result
            ]
        ]);

        $this->launchTest("GET", "/", $expectedPayload, "search={$result['characterName']}");
    }

    public function provider(): array
    {
        $aryaNewData = [
            'name' => 'Arya2',
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
                ]
            ],
            'houses' => [1, 3],
            'relations' => [
                ['passive' => 1, 'character_id' => 1, 'relation' => 'siblings'],
                ['passive' => 0, 'character_id' => 2, 'relation' => 'killer'],
            ],
            'updateHouses' => 0,
            'updateActors' => 0,
            'updateRelations' => 0
        ];

        $newAryaResult = [
            "characterName" => "Arya2",
            "characterLink" => "https://fake.link",
            "characterImageThumb" => "https://thumb.link",
            "characterImageFull" => "https://full_image.link",
            "nickname" => "Faker",
            "killed" => [
                "Black Walder Rivers",
                "Lothar Frey",
                "Meryn Trant",
                "Petyr Baelish",
                "Polliver",
                "Red Keep Stableboy",
                "Rorge",
                "The Night King",
                "The Waif",
                "Viserion",
                "Walder Frey",
                "White Walker"
            ],
            "siblings" => [
                "Bran Stark",
                "Rickon Stark",
                "Robb Stark",
                "Sansa Stark"
            ],
            "guardedBy" => [
                "Nymeria"
            ],
            "parents" => [
                "Catelyn Stark",
                "Eddard Stark"
            ],
            "houseName" => "Stark",
            "actorName" => "Maisie Williams",
            "actorLink" => "/name/nm3586035/"
        ];

        $greyWormNewData = [
            'name' => 'GreyWorm2',
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
            ],
            'updateHouses' => 1,
            'updateActors' => 1,
            'updateRelations' => 1
        ];

        $newGreyWormResult = [
            "characterName" => "GreyWorm2",
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
        ];

        return [
            [
                16, $aryaNewData, $newAryaResult
            ],
            [
                92, $greyWormNewData, $newGreyWormResult
            ]
        ];
    }
}
