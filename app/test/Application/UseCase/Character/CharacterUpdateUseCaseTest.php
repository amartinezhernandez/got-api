<?php

namespace Tests\Application\UseCase\Character;

use App\Application\Request\Character\CharacterUpdateRequest;
use App\Application\UseCase\Character\CharacterUpdateUseCase;
use App\Domain\Actor\Actor;
use App\Domain\Character\Character;
use App\Domain\Character\CharacterWriterRepositoryInterface;
use App\Domain\Relations\Relation;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CharacterUpdateUseCaseTest extends TestCase
{
    private MockObject|CharacterWriterRepositoryInterface $characterWriterRepository;
    private CharacterUpdateUseCase $useCase;

    protected function setUp(): void
    {
        $this->characterWriterRepository = $this->createMock(CharacterWriterRepositoryInterface::class);
        $this->useCase = new CharacterUpdateUseCase($this->characterWriterRepository);
    }

    /**
     * @dataProvider provider
     */
    public function testUpdate(Character $character): void
    {
        $this->characterWriterRepository->expects(self::once())->method('update')->willReturn(true);
        $this->characterWriterRepository->expects(self::once())->method('addActors')->willReturn(true);
        $this->characterWriterRepository->expects(self::once())->method('addHouses')->willReturn(true);
        $this->characterWriterRepository->expects(self::once())->method('addRelations')->willReturn(true);
        self::assertTrue($this->useCase->update(new CharacterUpdateRequest($character, true, true, true)));
    }

    public function provider(): array
    {
        return [
            [
                new Character(
                    2,
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
                )
            ]
        ];
    }
}
