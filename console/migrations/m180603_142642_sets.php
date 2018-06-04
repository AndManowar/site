<?php

use yii\db\Migration;

/**
 * Class m180603_142642_sets
 */
class m180603_142642_sets extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%sets}}', [
            'id'               => $this->primaryKey(),
            'name'             => $this->string(255)->notNull(),
            'alias'            => $this->string(255)->notNull(),
            'image'            => $this->string(255),
            'description_text' => $this->text(),
            'caption'          => $this->string(255),
            'title'            => $this->string(255),
            'keywords'         => $this->string(255),
            'description'      => $this->string(255),
            'is_shown'         => $this->boolean(),
            'created_at'       => $this->integer(),
            'updated_at'       => $this->integer(),
        ], $tableOptions);

        $this->createTable('{{%products_sets}}', [
            'id'         => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'set_id'     => $this->integer()->notNull(),
            'quantity'   => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey('FK_sets_products',
            '{{%products_sets}}',
            'product_id',
            '{{%products}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey('FK_products_sets_sets',
            '{{%products_sets}}',
            'set_id',
            '{{%sets}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('products_sets');
        $this->dropTable('sets');
    }

}
