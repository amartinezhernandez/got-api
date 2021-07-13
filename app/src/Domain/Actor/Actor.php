<?php

namespace App\Domain\Actor;

use JsonSerializable;

class Actor implements JsonSerializable
{
    private string $name;
    private ?string $link;
    private array $seasons;

    public function __construct(
        string $name,
        ?string $link,
        $seasons
    ) {
        $this->name = $name;
        $this->link = $link;
        $this->setSeasons($seasons);
    }

    private function setSeasons($seasons): void
    {
        if (is_string($seasons)) {
            $seasons = json_decode($seasons, true);
        }
        $this->seasons = $seasons ?? [];
    }

    public function name(): string
    {
        return $this->name;
    }

    public function link(): ?string
    {
        return $this->link;
    }

    public function seasons(): array
    {
        return $this->seasons;
    }

    public function jsonSerialize()
    {
        $actor = ['actorName' => $this->name()];

        if ($this->link()) {
            $actor['actorLink'] = $this->link();
        }

        if (count($this->seasons())) {
            $actor['seasonsActive'] = $this->seasons();
        }

        return $actor;
    }
}
