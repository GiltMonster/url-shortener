<?php

use Phinx\Migration\AbstractMigration;

final class CreateClicksTable extends AbstractMigration
{

    public function change(): void
    {
        $table = $this->table('clicks');
        $table->addColumn('url_id', 'integer')
            ->addColumn('clicked_at', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP'
            ])
            ->addColumn('ip', 'string', [
                'limit' => 45
            ])
            ->addColumn('user_agent', 'text')
            ->addForeignKey('url_id', 'urls', 'id', [
                'delete' => 'CASCADE',
                'update' => 'NO_ACTION'
            ])
            ->create();
    }
}
