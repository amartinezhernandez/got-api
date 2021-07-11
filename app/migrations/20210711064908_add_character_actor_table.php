<?php
declare(strict_types=1);

namespace App\Migrations;

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class AddCharacterActorTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('got.characters_actors')
            ->addColumn(
                'character_id',
                MysqlAdapter::PHINX_TYPE_INTEGER,
                [
                    'null' => false
                ]
            )
            ->addColumn(
                'name',
                MysqlAdapter::PHINX_TYPE_STRING,
                [
                    'limit' => MysqlAdapter::TEXT_SMALL,
                    'null' => false
                ]
            )
            ->addColumn(
                'link',
                MysqlAdapter::PHINX_TYPE_STRING,
                [
                    'limit' => MysqlAdapter::TEXT_REGULAR,
                    'null' => true
                ]
            )
            ->addColumn(
                'seasons',
                MysqlAdapter::PHINX_TYPE_JSON,
                [
                    'null' => true
                ]
            )
            ->create();
    }
}
