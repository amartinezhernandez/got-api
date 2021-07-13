<?php

namespace Tests\Application\UseCase\Character;

use App\Application\Request\ListRequest;
use App\Application\UseCase\Character\CharacterListUseCase;
use App\Domain\Actor\Actor;
use App\Domain\Character\Character;
use App\Domain\Character\CharacterReaderRepositoryInterface;
use App\Domain\Relations\Relation;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CharacterListUseCaseTest extends TestCase
{
    private CharacterListUseCase $useCase;
    private CharacterReaderRepositoryInterface|MockObject $characterReaderRepository;

    protected function setUp(): void
    {
        $this->characterReaderRepository = $this->createMock(CharacterReaderRepositoryInterface::class);
        $this->useCase = new CharacterListUseCase($this->characterReaderRepository);
    }

    public function testListWhenNoIdsFoundWillReturnEmptyArray(): void
    {
        $this->characterReaderRepository->expects(self::once())->method('listArrayOfIds')
            ->willReturn([]);

        self::assertEquals([], $this->useCase->list(new ListRequest(1, 5, 'invalidcharacter')));
    }

    /**
     * @dataProvider provider
     */
    public function testListHappyPath(array $ids, array $characters, array $relations, array $result): void
    {
        $this->characterReaderRepository->expects(self::once())->method('listArrayOfIds')
            ->willReturn($ids);

        $this->characterReaderRepository->expects(self::once())->method('getCharactersData')
            ->willReturn($characters);

        $this->characterReaderRepository->expects(self::once())->method('getCharactersRelations')
            ->willReturn($relations);

        self::assertEquals($result, $this->useCase->list(new ListRequest(1, 2)));
    }

    public function provider(): array
    {
        $characters = [
            new Character(
                "3",
                "Aeron Greyjoy",
                "/character/ch0540081/",
                "https://images-na.ssl-images-amazon.com/images/M/MV5BNzI5MDg0ZDAtN2Y2ZC00MzU1LTgyYjQtNTBjYjEzODczZDVhXkEyXkFqcGdeQXVyNTg0Nzg4NTE@._V1._SX100_SY140_.jpg",
                "https://images-na.ssl-images-amazon.com/images/M/MV5BNzI5MDg0ZDAtN2Y2ZC00MzU1LTgyYjQtNTBjYjEzODczZDVhXkEyXkFqcGdeQXVyNTg0Nzg4NTE@._V1_.jpg",
                "Damphair",
                false,
                [
                    new Actor("Michael Feast", "/name/nm0269923/", null)
                ]
            ),
            new Character(
                "4",
                "Aerys II Targaryen",
                "/character/ch0541362/",
                "https://images-na.ssl-images-amazon.com/images/M/MV5BMWQzOWViN2ItNDZhOS00MmZlLTkxZTYtZDg5NGUwMGRmYWZjL2ltYWdlL2ltYWdlXkEyXkFqcGdeQXVyMjk3NTUyOTc@._V1._SX100_SY1 ▶",
                "https://images-na.ssl-images-amazon.com/images/M/MV5BMWQzOWViN2ItNDZhOS00MmZlLTkxZTYtZDg5NGUwMGRmYWZjL2ltYWdlL2ltYWdlXkEyXkFqcGdeQXVyMjk3NTUyOTc@._V1_.jpg",
                "The Mad King",
                true,
                [
                    new Actor("David Rintoul", "/name/nm0727778/", null)
                ]
            )
        ];
        $relations = [
            new Relation("3", "Aeron Greyjoy", "66", "Euron Greyjoy", "siblings"),
            new Relation("4", "Aerys II Targaryen", "29", "Brandon Stark", "killer"),
            new Relation("114", "Jaime Lannister", "4", "Aerys II Targaryen", "killer")

        ];

        $result = [
            new Character(
                "3",
                "Aeron Greyjoy",
                "/character/ch0540081/",
                "https://images-na.ssl-images-amazon.com/images/M/MV5BNzI5MDg0ZDAtN2Y2ZC00MzU1LTgyYjQtNTBjYjEzODczZDVhXkEyXkFqcGdeQXVyNTg0Nzg4NTE@._V1._SX100_SY140_.jpg",
                "https://images-na.ssl-images-amazon.com/images/M/MV5BNzI5MDg0ZDAtN2Y2ZC00MzU1LTgyYjQtNTBjYjEzODczZDVhXkEyXkFqcGdeQXVyNTg0Nzg4NTE@._V1_.jpg",
                "Damphair",
                false,
                [
                    new Actor("Michael Feast", "/name/nm0269923/", null)
                ],
                [],
                [
                    'siblings' => [
                        "Euron Greyjoy"
                    ]
                ]
            ),
            new Character(
                "4",
                "Aerys II Targaryen",
                "/character/ch0541362/",
                "https://images-na.ssl-images-amazon.com/images/M/MV5BMWQzOWViN2ItNDZhOS00MmZlLTkxZTYtZDg5NGUwMGRmYWZjL2ltYWdlL2ltYWdlXkEyXkFqcGdeQXVyMjk3NTUyOTc@._V1._SX100_SY1 ▶",
                "https://images-na.ssl-images-amazon.com/images/M/MV5BMWQzOWViN2ItNDZhOS00MmZlLTkxZTYtZDg5NGUwMGRmYWZjL2ltYWdlL2ltYWdlXkEyXkFqcGdeQXVyMjk3NTUyOTc@._V1_.jpg",
                "The Mad King",
                true,
                [
                    new Actor("David Rintoul", "/name/nm0727778/", null)
                ],
                [],
                [
                    'killed' => [
                        "Brandon Stark"
                    ],
                    'killedBy' => [
                        "Jaime Lannister"
                    ]
                ]
            )
        ];

        return [
            [
                [1, 2], // listArrayOfIds
                $characters, // getCharactersData
                $relations, // getCharactersRelations
                $result //buildRelationsForMultipleCharacters
            ]
        ];
    }
}
