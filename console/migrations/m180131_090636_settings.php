<?php

use yii\db\Migration;

/**
 * Class m180131_090636_settings
 */
class m180131_090636_settings extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%settings}}', [
            'id'          => $this->primaryKey(),
            'systemName'  => $this->string()->notNull(),
            'description' => $this->string()->notNull(),
            'fieldType'   => $this->integer()->notNull(),
            'value'       => $this->string(),
            'created_at'  => $this->integer(),
            'updated_at'  => $this->integer()
        ], $tableOptions);

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%settings}}');
    }
}