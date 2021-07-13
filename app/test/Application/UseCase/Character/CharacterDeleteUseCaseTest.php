<?php

namespace Tests\Application\UseCase\Character;

use App\Application\UseCase\Character\CharacterDeleteUseCase;
use App\Domain\Character\CharacterWriterRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CharacterDeleteUseCaseTest extends TestCase
{
    private MockObject|CharacterWriterRepositoryInterface $characterWriterRepository;
    private CharacterDeleteUseCase $useCase;

    protected function setUp(): void
    {
        $this->characterWriterRepository = $this->createMock(CharacterWriterRepositoryInterface::class);
        $this->useCase = new CharacterDeleteUseCase($this->characterWriterRepository);
    }

    public function testDelete(): void
    {
        $this->characterWriterRepository->expects(self::once())->method('delete')->willReturn(true);
        self::assertTrue($this->useCase->delete(5));
    }
}
