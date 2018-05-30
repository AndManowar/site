<?php

use yii\db\Migration;

/**
 * Class m180529_143803_categories
 */
class m180529_143803_categories extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%categories}}', [
            'id'               => $this->primaryKey(),
            'name'             => $this->string(255)->notNull(),
            'alias'            => $this->string(255)->notNull(),
            'caption'          => $this->string(255),
            'image'            => $this->string(255),
            'description_text' => $this->text(),
            'title'            => $this->string(255),
            'keywords'         => $this->string(255),
            'description'      => $this->string(255),
            'parent_id'        => $this->boolean(),
            'sort'             => $this->integer()->null(),
            'created_at'       => $this->integer(),
            'updated_at'       => $this->integer(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%categories}}');
    }
}
