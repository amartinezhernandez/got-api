<?php

namespace Tests\Infrastructure\Slim\Action\Character;

use App\Infrastructure\Slim\Action\ActionPayload;
use Tests\Infrastructure\Slim\Action\ActionTestCase;

class CharacterListActionTest extends ActionTestCase
{
    public function testActionBabySam(): void
    {
        $expectedPayload = new ActionPayload(200, [
            'characters' => [
                [
                    "characterName" => "Baby Sam",
                    "characterLink" => "/character/ch0547881/",
                    "parents" => [
                        "Gilly",
                        "Samwell Tarly"
                    ],
                    "actors" => [
                        [
                            "actorName" => "William Wilson",
                            "actorLink" => "/name/nm8251159/",
                            "seasonsActive" => [
                                7
                            ]
                        ],
                        [
                            "actorName" => "James Wilson",
                            "actorLink" => "/name/nm8251160/",
                            "seasonsActive" => [
                                7
                            ]
                        ]
                    ]
                ]
            ],
        ]);

        $this->launchTest("GET", "/", $expectedPayload, "search=baby%20sam");
    }

    public function testActionJonSnow(): void
    {
        $expectedPayload = new ActionPayload(200, [
            'characters' => [
                [
                    "characterName" => "Jon Snow",
                    "characterLink" => "/character/ch0155777/",
                    "characterImageThumb" => "https://images-na.ssl-images-amazon.com/images/M/MV5BMTkwMjUxMDk2OV5BMl5BanBnXkFtZTcwMzg3MTg4OQ@@._V1._SX100_SY140_.jpg",
                    "characterImageFull" => "https://images-na.ssl-images-amazon.com/images/M/MV5BMTkwMjUxMDk2OV5BMl5BanBnXkFtZTcwMzg3MTg4OQ@@._V1_.jpg",
                    "royal" => true,
                    "siblings" => [
                        "Aegon Targaryen"
                    ],
                    "killedBy" => [
                        "Alliser Thorne",
                        "Bowen Marsh",
                        "Olly",
                        "Othell Yarwyck"
                    ],
                    "servedBy" => [
                        "Davos Seaworth"
                    ],
                    "killed" => [
                        "Alliser Thorne",
                        "Bowen Marsh",
                        "Daenerys Targaryen",
                        "Janos Slynt",
                        "Karl Tanner",
                        "Lyanna Stark",
                        "Mance Rayder",
                        "Olly",
                        "Orell",
                        "Othell Yarwyck",
                        "Othor",
                        "Qhorin Halfhand",
                        "Styr",
                        "White Walker"
                    ],
                    "guardedBy" => [
                        "Eddard Stark",
                        "Ghost"
                    ],
                    "marriedEngaged" => [
                        "Ygritte"
                    ],
                    "parents" => [
                        "Lyanna Stark",
                        "Rhaegar Targaryen"
                    ],
                    "houseName" => [
                        "Targaryen",
                        "Stark"
                    ],
                    "actorName" => "Kit Harington",
                    "actorLink" => "/name/nm3229685/"
                ]
            ],
        ]);

        $this->launchTest("GET", "/", $expectedPayload, "search=jon%20snow");
    }

    public function testBrynen(): void
    {
        $expectedPayload = new ActionPayload(200, [
            'characters' => [
                [
                    "characterName" => "Brynden Tully",
                    "characterLink" => "/character/ch0381563/",
                    "characterImageThumb" => "https://images-na.ssl-images-amazon.com/images/M/MV5BOTg5ZDIwOWUtMjQ1OS00YjgxLThmMDgtOWUwZjQ4MzE3ZDhlXkEyXkFqcGdeQXVyMjk3NTUyOTc@._V1._SX100_SY140_.jpg",
                    "characterImageFull" => "https://images-na.ssl-images-amazon.com/images/M/MV5BOTg5ZDIwOWUtMjQ1OS00YjgxLThmMDgtOWUwZjQ4MzE3ZDhlXkEyXkFqcGdeQXVyMjk3NTUyOTc@._V1_.jpg",
                    "nickname" => "Blackfish",
                    "siblings" => [
                        "Hoster Tully"
                    ],
                    "houseName" => "Tully",
                    "actorName" => "Clive Russell",
                    "actorLink" => "/name/nm0751085/"
                ]
            ]
        ]);

        $this->launchTest("GET", "/", $expectedPayload, "search=Brynden%20Tully");
    }


    public function testActionNothingFound(): void
    {
        $expectedPayload = new ActionPayload(200, [
            'characters' => [],
        ]);

        $this->launchTest("GET", "/", $expectedPayload, "search=iwillfindnothing");
    }
}
