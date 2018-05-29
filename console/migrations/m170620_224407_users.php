<?php

use yii\db\Migration;

/**
 * Class m170620_224407_users
 */
class m170620_224407_users extends Migration
{
    /**
     * @return bool|void
     * @throws \yii\base\Exception
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }


        $this->createTable('{{%user}}', [
            'id'                   => $this->primaryKey(),
            'username'             => $this->string()->notNull()->unique(),
            'auth_key'             => $this->string(32)->notNull(),
            'password_hash'        => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email'                => $this->string()->notNull()->unique(),
            'role'                 => $this->integer()->notNull(),
            'status'               => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at'           => $this->integer()->notNull(),
            'updated_at'           => $this->integer()->notNull(),
        ], $tableOptions);

//        $this->createTable('{{%profile}}', [
//            'user_id'    => $this->primaryKey(),
//            'surname'    => $this->string(32)->notNull(),
//            'name'       => $this->string(32)->notNull(),
//            'lastname'   => $this->string(32)->notNull(),
//            'sex_id'     => $this->integer()->notNull()->defaultValue(0),
//            'birthday'   => $this->integer(),
//            'region_id'  => $this->integer(),
//            'city_id'    => $this->integer(),
//            'created_at' => $this->integer(),
//            'updated_at' => $this->integer(),
//        ], $tableOptions);

       // $this->addForeignKey('FK_profile_user', '{{%profile}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        $this->batchInsert('{{%user}}',
            [
                'auth_key',
                'password_hash',
                'role',
                'username',
                'email',
                'status',
                'created_at',
                'updated_at',
            ],
            [
                [
                    Yii::$app->security->generateRandomString(),
                    Yii::$app->security->generatePasswordHash('123456'),
                    10,
                    'admin',
                    'admnin@test.com',
                    5,
                    time(),
                    time()
                ],
                [
                    Yii::$app->security->generateRandomString(),
                    Yii::$app->security->generatePasswordHash('123456'),
                    8,
                    'manager',
                    'manager@test.com',
                    5,
                    time(),
                    time()
                ],
            ]
        );
//        $this->batchInsert('{{%profile}}',
//            [
//                'sex_id',
//                'birthday',
//                'name',
//                'surname',
//                'user_id',
//                'created_at',
//                'updated_at',
//            ],
//            [
//                [
//                    1,
//                    858988800,
//                    'admin',
//                    'super',
//                    1,
//                    time(),
//                    time()
//                ],
//                [
//                    2,
//                    843696000,
//                    'Manager',
//                    'Manager',
//                    2,
//                    time(),
//                    time()
//                ],
//            ]
//        );

    }

    public function down()
    {
//        $this->dropTable('{{%profile}}');
        $this->dropTable('{{%user}}');
    }
}
