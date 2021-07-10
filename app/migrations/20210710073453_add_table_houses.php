<?php
declare(strict_types=1);

namespace App\Migrations;

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class AddTableHouses extends AbstractMigration
{
    public function change(): void
    {
        $this->table('got.houses')
            ->addColumn(
                'name',
                MysqlAdapter::PHINX_TYPE_STRING,
                [
                    'limit' => MysqlAdapter::TEXT_SMALL,
                    'null' => false
                ]
            )
            ->create();
    }
}
