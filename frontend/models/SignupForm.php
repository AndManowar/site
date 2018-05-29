<?php

namespace frontend\models;

use common\models\Profile;
use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $surname;
    public $name;
    public $email;
    public $sex_id;
    public $password;
    public $isConfirmRules;
    public $role;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            [['username', 'isConfirmRules', 'surname', 'name', 'sex_id'], 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['isConfirmRules', 'boolean', 'when' => function () {
                if ($this->isConfirmRules == false) {
                    $this->addError('isConfirmRules', 'Необходимо согласится с условиями !');
                }
            }],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Користувач з таким логіном вже існує'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['role', 'default', 'value' => 'user'],

        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'email'          => 'Email - адресс',
            'surname'        => 'Прізвище',
            'name'           => "Ім'я",
            'sex_id'         => "Стать",
            'username'       => 'Имя пользователя',
            'password'       => 'Пароль',
            'isConfirmRules' => 'Я принимаю пользовательское соглашение',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     * @throws \Exception
     * @throws \yii\base\Exception
     */
    public function signup()
    {
        if ($this->validate()) {

            $user = new User(['username' => $this->username, 'email' => $this->email, 'role' => User::ROLE_USER]);
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                $user->link('profile', new Profile(['surname' => $this->surname, 'name' => $this->name, 'sex_id' => $this->sex_id]));
                $role = Yii::$app->accessControl->getRole($this->role);
                Yii::$app->authManager->assign($role, $user->id);

                return $user;
            }
        }

        return null;
    }
}
