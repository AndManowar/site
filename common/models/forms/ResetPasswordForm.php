<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 23.04.18
 * Time: 14:55
 */

namespace common\models\forms;


use common\models\users\User;
use yii\base\Model;

/**
 * Class ResetPasswordForm
 * @package common\models\forms
 */
class ResetPasswordForm extends Model
{
    /**
     * @var string
     */
    public $newPassword;

    /**
     * @var string
     */
    public $newPasswordRepeat;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['newPasswordRepeat', 'newPassword'], 'required'],
            [['newPasswordRepeat', 'newPassword'], 'string'],
            ['newPasswordRepeat', 'compare', 'compareAttribute' => 'newPassword'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'newPassword'       => 'Новый пароль',
            'newPasswordRepeat' => 'Повтор пароля'
        ];
    }

    /**
     * @param User $user
     * @return bool
     * @throws \yii\base\Exception
     */
    public function resetPassword($user)
    {
        $user->setPassword($this->newPassword);
        $user->removePasswordResetToken();

        if (!$user->save()) {
            return false;
        }

        return (new LoginForm(['username' => $user->username, 'password' => $this->newPassword]))->login();
    }
}