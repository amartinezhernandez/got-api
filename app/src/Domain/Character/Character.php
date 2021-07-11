<?php

namespace App\Domain\Character;

use JsonSerializable;

class Character implements JsonSerializable
{
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
        $character['houseName'] = count($characterHouses = $this->houses()) ? reset($characterHouses) : $characterHouses;

        if (count($actor = $this->actors()) > 0) {
            $actor = reset($actor);
            $character = array_merge($character, $actor->jsonSerialize());
        } else {
            $character['actors'] = $this->actors();
        }

        return $character;
    }
}