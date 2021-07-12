<?php

namespace App\Domain\Relations;

class Relation
{
    private int $characterId;
    private string $characterName;
    private int $relatedId;
    private string $relatedName;
    private string $relation;

    private const RELATION_ACTIONS = [
        'killer' => [
            'character' => 'killed',
            'related' => 'killedBy'
        ],
        'parent' => [
            'character' => 'parentOf',
            'related' => 'parents'
        ],
        'serves' => [
            'character' => 'serves',
            'related' => 'servedBy'
        ],
        'guarded' => [
            'character' => 'guardedBy',
            'related' => 'guardianOf'
        ]
    ];

    public function __construct(
        int $characterId,
        string $characterName,
        int $relatedId,
        string $relatedName,
        string $relation
    ) {
        $this->characterId = $characterId;
        $this->characterName = $characterName;
        $this->relatedId = $relatedId;
        $this->relatedName = $relatedName;
        $this->relation = $relation;
    }

    public function characterId(): int
    {
        return $this->characterId;
    }

    public function characterName(): string
    {
        return $this->characterName;
    }

    public function relatedId(): int
    {
        return $this->relatedId;
    }

    public function relatedName(): string
    {
        return $this->relatedName;
    }

    public function relation(): string
    {
        return $this->relation;
    }

    public function relationKey(int $id): string
    {
        if (isset(self::RELATION_ACTIONS[$this->relation()])) {
            return self::RELATION_ACTIONS[$this->relation()][$this->isCharacter($id) ? 'character' : 'related'];
        }
        return $this->relation();
    }

    public function relationValue(int $id): string
    {
        return $this->isCharacter($id) ? $this->relatedName() : $this->characterName();
    }

    private function isCharacter(int $id): bool
    {
        return $this->characterId() == $id;
    }
}