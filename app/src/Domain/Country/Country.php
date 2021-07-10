<?php

namespace App\Domain\Country;

class Country
{
    private $code;
    private $population;
    private $region;

    private function __construct(
        string $code,
        int $population,
        ?string $region
    ) {
        $this->code = $code;
        $this->population = $population;
        $this->region = $region;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function population(): int
    {
        return $this->population;
    }

    public function region(): ?string
    {
        return $this->region;
    }

    public static function fromRequest(array $requestData, string $code): self
    {
        if (!isset($requestData['population'])) {
            throw new CountryPopulationMissingException();
        }
        return new self(
            $code,
            $requestData['population'],
            $requestData['region'] ?? null
        );
    }
}
