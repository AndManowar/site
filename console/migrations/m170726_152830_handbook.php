<?php

use yii\db\Migration;

class m170726_152830_handbook extends Migration
{


    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%handbook}}', [
            'id'          => $this->primaryKey(),
            'systemName'  => $this->string()->notNull(),
            'description' => $this->string()->notNull(),
            'fields'      => $this->text(),
            'relation'    => $this->integer(),
            'created_at'  => $this->integer()->notNull(),
            'updated_at'  => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%handbook_data}}', [
            'id'          => $this->primaryKey(),
            'handbook_id' => $this->integer()->notNull(),
            'data_id'     => $this->integer()->notNull(),
            'value'       => $this->string()->notNull(),
            'relation'    => $this->integer(),
            'fields'      => $this->text(),
            'title'       => $this->string()->notNull(),
            'created_at'  => $this->integer()->notNull(),
            'updated_at'  => $this->integer()->notNull(),
            'created_by'  => $this->integer()->notNull(),
            'updated_by'  => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('FK_handbook_data_handbook', '{{%handbook_data}}', 'handbook_id', '{{%handbook}}', 'id', 'CASCADE', 'CASCADE');

    }


    public function down()
    {
        $this->dropTable('{{%handbook_data}}');
        $this->dropTable('{{%handbook}}');
    }

}
