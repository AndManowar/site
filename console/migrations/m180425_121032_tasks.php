<?php

use yii\db\Migration;

/**
 * Class m180425_121032_tasks
 */
class m180425_121032_tasks extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%tasks}}', [
            'id'             => $this->primaryKey(),
            'title'          => $this->string()->notNull(),
            'description'    => $this->text(),
            'position'       => $this->integer(),
            'status'         => $this->integer()->notNull(),
            'previousStatus' => $this->integer(),
            'created_by'     => $this->integer()->notNull(),
            'updated_by'     => $this->integer()->notNull(),
            'created_at'     => $this->integer(),
            'updated_at'     => $this->integer(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('tasks');
    }

}
