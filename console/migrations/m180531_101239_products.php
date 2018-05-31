<?php

use yii\db\Migration;

/**
 * Class m180531_101239_products
 */
class m180531_101239_products extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%products}}', [
            'id'               => $this->primaryKey(),
            'name'             => $this->string(255)->notNull(),
            'title_image'      => $this->string(255),
            'price'            => $this->double()->notNull(),
            'old_price'        => $this->double()->notNull(),
            'width'            => $this->double(),
            'height'           => $this->double(),
            'thickness'        => $this->double(),
            'description_text' => $this->text(),
            'caption'          => $this->string(255),
            'title'            => $this->string(255),
            'keywords'         => $this->string(255),
            'description'      => $this->string(255),
            'is_shown'         => $this->boolean(),
            'category_id'      => $this->integer(),
            'created_at'       => $this->integer(),
            'updated_at'       => $this->integer(),
        ], $tableOptions);

        $this->createTable('{{%colors}}', [
            'id'         => $this->primaryKey(),
            'name'       => $this->string(255)->notNull(),
            'image'      => $this->string(255),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createTable('{{%products_colors}}', [
            'id'         => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'color_id'   => $this->integer()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createTable('{{%products_images}}', [
            'id'         => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'image'      => $this->string()->notNull(),
            'sort'       => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey('FK_images_products',
            '{{%products_images}}',
            'product_id',
            '{{%products}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey('FK_colors_products',
            '{{%products_colors}}',
            'product_id',
            '{{%products}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey('FK_colors_colors',
            '{{%products_colors}}',
            'color_id',
            '{{%colors}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey('FK_product_category',
            '{{%products}}',
            'category_id',
            '{{%categories}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('products_colors');
        $this->dropTable('products_images');
        $this->dropTable('colors');
        $this->dropTable('products');
    }

}
