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
            'alias'            => $this->string(255),
            'caption'          => $this->string(255),
            'image'            => $this->string(255),
            'description_text' => $this->text(),
            'title'            => $this->string(255),
            'keywords'         => $this->string(255),
            'description'      => $this->string(255),
            'root'             => $this->integer(),
            'lft'              => $this->integer(),
            'rgt'              => $this->integer(),
            'lvl'              => $this->integer(),
            'icon'             => $this->string(255),
            'icon_type'        => $this->integer(),
            'active'           => $this->boolean(),
            'selected'         => $this->boolean(),
            'disabled'         => $this->boolean(),
            'readonly'         => $this->boolean(),
            'visible'          => $this->boolean(),
            'collapsed'        => $this->boolean(),
            'movable_u'        => $this->boolean(),
            'movable_d'        => $this->boolean(),
            'movable_l'        => $this->boolean(),
            'movable_r'        => $this->boolean(),
            'removable'        => $this->boolean(),
            'removable_all'    => $this->boolean(),
            'parent_id'        => $this->integer(),
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
