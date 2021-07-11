<?php
declare(strict_types=1);

namespace App\Migrations;

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class AddCharactersTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('got.characters')
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
                'thumbnail',
                MysqlAdapter::PHINX_TYPE_STRING,
                [
                    'limit' => MysqlAdapter::TEXT_REGULAR,
                    'null' => true
                ]
            )
            ->addColumn(
                'full_image',
                MysqlAdapter::PHINX_TYPE_STRING,
                [
                    'limit' => MysqlAdapter::TEXT_REGULAR,
                    'null' => true
                ]
            )
            ->addColumn(
                'nickname',
                MysqlAdapter::PHINX_TYPE_STRING,
                [
                    'limit' => MysqlAdapter::TEXT_SMALL,
                    'null' => true
                ]
            )
            ->addColumn(
                'royal',
                MysqlAdapter::PHINX_TYPE_BOOLEAN,
                [
                    'default' => false,
                    'null' => false
                ]
            )

            ->create();
    }
}
