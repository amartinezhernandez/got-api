<?php

namespace App\Seeds;

use Phinx\Seed\AbstractSeed;

class HousesSeed extends AbstractSeed
{
    public function run()
    {
        $this->execute("TRUNCATE TABLE got.houses;");
        $this->insert("got.houses", self::housesData());
    }

    public static function housesData(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'Targaryen'
            ],
            [
                'id' => 2,
                'name' => 'Greyjoy'
            ],
            [
                'id' => 3,
                'name' => 'Lannister'
            ],
            [
                'id' => 4,
                'name' => 'Stark'
            ],
            [
                'id' => 5,
                'name' => 'Baratheon'
            ],
            [
                'id' => 6,
                'name' => 'Frey'
            ],
            [
                'id' => 7,
                'name' => 'Tully'
            ],
            [
                'id' => 8,
                'name' => 'Martell'
            ],
            [
                'id' => 9,
                'name' => 'Mormont'
            ],
            [
                'id' => 10,
                'name' => 'Tyrell'
            ],
            [
                'id' => 11,
                'name' => 'Arryn'
            ],
            [
                'id' => 12,
                'name' => 'Umber'
            ],
            [
                'id' => 13,
                'name' => 'Bolton'
            ]
        ];
    }
}
