<?php
namespace App\Seeds;

use Phinx\Seed\AbstractSeed;

class CharactersSeed extends AbstractSeed
{
    public function run()
    {
        $this->insert("got.characters", $this->getProcessedData());
    }

    private function getProcessedData(): array
    {
        $jsonCharacter = json_decode(
            file_get_contents(__DIR__ . "/got-characters.json"),
            true
        );

        return array_map(function ($character) {
            return [
                "name" => $character["characterName"],
                "link" => $character["characterLink"] ?? null,
                "thumbnail" => $character["characterImageThumb"] ?? null,
                "full_image" => $character["characterImageFull"] ?? null,
                "nickname" => $character["nickname"] ?? null,
                "royal" => $character["royal"] ?? false
            ];
        }, $jsonCharacter['characters']);
    }
}
