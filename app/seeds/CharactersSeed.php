<?php
namespace App\Seeds;

use Phinx\Seed\AbstractSeed;

class CharactersSeed extends AbstractSeed
{
    private array $characters = [];
    private array $charactersHouses = [];
    private array $charactersActors = [];
    private array $charactersRelations = [];

    private const RELATION_TYPES = [
        'sibling' => "siblings",
        'killer' => "killed",
        'parent' => "parentOf",
        'serves' => "serves",
        'married_engaged' => "marriedEngaged",
        'guarded' => 'guardedBy'
    ];

    public function run()
    {
        $this->processData();
        $this->insert("got.characters", $this->characters);
        $this->insert("got.characters_houses", $this->charactersHouses);
        $this->insert("got.characters_actors", $this->charactersActors);
        $this->insert("got.characters_relations", $this->charactersRelations);
    }

    private function processData(): void
    {
        $jsonCharacter = json_decode(
            file_get_contents(__DIR__ . "/got-characters.json"),
            true
        );

        $id = 0;

        $this->characters = array_map(function ($character) use (&$id) {
            $id++;
            return [
                "id" => $id,
                "name" => $character["characterName"],
                "link" => $character["characterLink"] ?? null,
                "thumbnail" => $character["characterImageThumb"] ?? null,
                "full_image" => $character["characterImageFull"] ?? null,
                "nickname" => $character["nickname"] ?? null,
                "royal" => $character["royal"] ?? false
            ];
        }, $jsonCharacter['characters']);

        $houses = HousesSeed::housesData();

        foreach ($jsonCharacter['characters'] as $iter => $character) {
            $iter++;
            if (isset($character['houseName']) && (is_array($character['houseName']) || is_string($character['houseName']))) {
                $this->charactersHouses = array_merge($this->charactersHouses, $this->findHouseId(
                    $houses,
                    $iter,
                    is_array($character['houseName']) ? $character['houseName'] : [$character['houseName']]
                ));
            }

            if (isset($character['actorName'])) {
                $this->charactersActors[] = $this->processActors($character, $iter);
            } elseif (isset($character['actors']) && is_array($character['actors'])) {
                $this->charactersActors = array_merge($this->charactersActors, array_map(function ($char) use ($iter) {
                    return $this->processActors($char, $iter);
                }, $character['actors']));
            }

            $this->buildRelations($character, $iter);
        }
    }

    private function findHouseId(array $houses, int $charId, array $names): array
    {
        $found = [];
        foreach ($names as $name) {
            $key = array_search($name, array_column($houses, 'name'));
            if ($key !== false) {
                $found[] = [
                    'character_id' => $charId,
                    'house_id' => $houses[$key]['id']
                ];
            }
        }
        return $found;
    }

    private function processActors(array $character, int $charId): array
    {
        return [
            'character_id' => $charId,
            'name' => $character['actorName'],
            'link' => $character['actorLink'] ?? null,
            'seasons' => isset($character['seasonsActive']) ? json_encode($character['seasonsActive']) : null
        ];
    }

    private function buildRelations(mixed $character, int $id): void
    {
        foreach (self::RELATION_TYPES as $bdType => $jsonType) {
            if (isset($character[$jsonType]) && is_array($character[$jsonType])) {
                foreach ($character[$jsonType] as $related) {
                    $key = array_search($related, array_column($this->characters, 'name'));
                    if ($key !== false) {
                        $this->charactersRelations[] = [
                            'character_id' => $id,
                            'related_to_id' => $this->characters[$key]['id'],
                            'relation' => $bdType
                        ];
                    }
                }
            }
        }
    }
}
