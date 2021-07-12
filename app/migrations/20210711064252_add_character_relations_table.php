<?php
declare(strict_types=1);

namespace App\Migrations;

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class AddCharacterRelationsTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('got.characters_relations')
            ->addColumn(
                'character_id',
                MysqlAdapter::PHINX_TYPE_INTEGER,
                [
                    'null' => false
                ]
            )
            ->addColumn(
                'related_to_id',
                MysqlAdapter::PHINX_TYPE_INTEGER,
                [
                    'null' => false
                ]
            )
            ->addColumn(
                'relation',
                MysqlAdapter::PHINX_TYPE_ENUM,
                [
                    'values' => [
                        'siblings',
                        'killer',
                        'parent',
                        'serves',
                        'marriedEngaged',
                        'guarded'
                    ],
                    'null' => false
                ]
            )
            ->addIndex(['character_id', 'related_to_id', 'relation'], ['unique' => true])
            ->create();
    }
}
