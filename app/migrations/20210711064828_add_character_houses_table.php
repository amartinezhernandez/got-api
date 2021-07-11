<?php
declare(strict_types=1);

namespace App\Migrations;

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class AddCharacterHousesTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('got.characters_houses')
            ->addColumn(
                'character_id',
                MysqlAdapter::PHINX_TYPE_INTEGER,
                [
                    'null' => false
                ]
            )
            ->addColumn(
                'house_id',
                MysqlAdapter::PHINX_TYPE_INTEGER,
                [
                    'null' => false
                ]
            )
            ->addIndex(['character_id', 'house_id'], ['unique' => true])
            ->create();
    }
}
