<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class CreateRunsTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('runs', ['collation'=>'utf8mb4_unicode_ci']);
        $table
            ->addColumn('time', 'datetime')
            ->addColumn('ip', 'string', ['limit' => 255, 'default' => ''])
            ->addColumn('hash', 'string', ['limit' => 40, 'default' => ''])
            ->addColumn('meta', 'text')
            ->addColumn('status', 'string', ['limit' => 10, 'default' => 'waiting'])
            ->addColumn('results', 'text', ['limit' => MysqlAdapter::TEXT_LONG, 'null' => true])
            ->addColumn('last_seen', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['hash'])
            ->create();
    }
}
