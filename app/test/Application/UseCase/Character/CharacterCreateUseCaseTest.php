<?php

namespace Tests\Application\UseCase\Character;

use App\Application\UseCase\Character\CharacterCreateUseCase;
use App\Domain\Actor\Actor;
use App\Domain\Character\Character;
use App\Domain\Character\CharacterWriterRepositoryInterface;
use App\Domain\Relations\Relation;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CharacterCreateUseCaseTest extends TestCase
{
    private MockObject|CharacterWriterRepositoryInterface $characterWriterRepository;
    private CharacterCreateUseCase $useCase;

    protected function setUp(): void
    {
        $this->characterWriterRepository = $this->createMock(CharacterWriterRepositoryInterface::class);
        $this->useCase = new CharacterCreateUseCase($this->characterWriterRepository);
    }

    /**
     * @dataProvider provider
     */
    public function testCreate(Character $character, int $id): void
    {
        $this->characterWriterRepository->expects(self::once())->method('create')->willReturn($id);
        $this->characterWriterRepository->expects(self::once())->method('addHouses')->willReturn(true);
        $this->characterWriterRepository->expects(self::once())->method('addActors')->willReturn(true);
        $this->characterWriterRepository->expects(self::once())->method('addRelations')->willReturn(true);

        self::assertEquals(2, $this->useCase->create($character));
    }

    public function provider(): array
    {
        return [
            [
                new Character(
                    null,
                    "Aerys II Targaryen",
                    "/character/ch0541362/",
                    "https://images-na.ssl-images-amazon.com/images/M/MV5BMWQzOWViN2ItNDZhOS00MmZlLTkxZTYtZDg5NGUwMGRmYWZjL2ltYWdlL2ltYWdlXkEyXkFqcGdeQXVyMjk3NTUyOTc@._V1._SX100_SY1 ▶",
                    "https://images-na.ssl-images-amazon.com/images/M/MV5BMWQzOWViN2ItNDZhOS00MmZlLTkxZTYtZDg5NGUwMGRmYWZjL2ltYWdlL2ltYWdlXkEyXkFqcGdeQXVyMjk3NTUyOTc@._V1_.jpg",
                    "The Mad King",
                    true,
                    [
                        new Actor("David Rintoul", "/name/nm0727778/", null)
                    ],
                    [
                        2
                    ],
                    [
                        new Relation(null, null, 3, null, "killer")
                    ]
                ),
                2
            ]
        ];
    }
}
