<?php

use Phinx\Migration\AbstractMigration;

final class CreateUrlsTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('urls', [
            'id' => false,
            'primary_key' => ['id']
        ]);
        $table->addColumn('id', 'integer', ['identity' => true])
              ->addColumn('original_url', 'string', ['limit' => 2048])
              ->addColumn('shortened_url', 'string', ['limit' => 100])
              ->addColumn('clicks', 'integer', ['default' => 0])
              ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              ->create();
    }
}
