<?php

namespace App\Domain\Character;

use JsonSerializable;

class Character implements JsonSerializable
{
    private int $id;
    private string $name;
    private ?string $link;
    private ?string $thumbnail;
    private ?string $image;
    private ?string $nickname;
    private bool $royal;
    private array $actors;
    private array $houses;
    private array $relations;

    public function __construct(
        int $id,
        string $name,
        ?string $link,
        ?string $thumbnail,
        ?string $image,
        ?string $nickname,
        bool $royal,
        array $actors = [],
        array $houses = [],
        array $relations = []
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->link = $link;
        $this->thumbnail = $thumbnail;
        $this->image = $image;
        $this->nickname = $nickname;
        $this->royal = $royal;
        $this->actors = $actors;
        $this->houses = $houses;
        $this->relations = $relations;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function link(): ?string
    {
        return $this->link;
    }

    public function thumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function image(): ?string
    {
        return $this->image;
    }

    public function nickname(): ?string
    {
        return $this->nickname;
    }

    public function royal(): bool
    {
        return $this->royal;
    }

    public function actors(): array
    {
        return $this->actors;
    }

    public function houses(): array
    {
        return $this->houses;
    }

    public function relations(): array
    {
        return $this->relations;
    }

    public function setRelations(array $relations): void
    {
        $this->relations = $relations;
    }

    public function jsonSerialize(): array
    {
        $character = [
            'characterName' => $this->name()
        ];

        if ($this->link()) {
            $character['characterLink'] = $this->link();
        }
        if ($this->thumbnail()) {
            $character['characterImageThumb'] = $this->thumbnail();
        }
        if ($this->image()) {
            $character['characterImageFull'] = $this->image();
        }
        if ($this->royal()) {
            $character['royal'] = $this->royal();
        }
        $character = array_merge($character, $this->relations());

        if ($totalHouses = count($characterHouses = $this->houses())) {
            $character['houseName'] = $totalHouses == 1 ? reset($characterHouses) : $characterHouses;
        }

        $totalActors = count($actor = $this->actors());

        if ($totalActors > 1) {
            $character['actors'] = $this->actors();
        } elseif ($totalActors == 1) {
            $actor = reset($actor);
            $character = array_merge($character, $actor->jsonSerialize());
        }

        return $character;
    }
}