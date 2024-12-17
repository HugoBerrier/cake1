<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateSleepRecords extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('sleep_records');
        $table->addColumn('user_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('date', 'date', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('bedtime', 'time', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('wakeup_time', 'time', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('nap_afternoon', 'boolean', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('nap_evening', 'boolean', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('mood', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('comment', 'text', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('sport', 'boolean', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();
    }
}
