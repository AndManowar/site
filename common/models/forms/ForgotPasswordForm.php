<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 23.04.18
 * Time: 15:01
 */

namespace common\models\forms;

use common\models\users\User;
use yii\base\Model;

/**
 * Class ForgotPasswordForm
 * @package common\models\forms
 */
class ForgotPasswordForm extends Model
{
    /**
     * @var string
     */
    public $email;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
            ['email', function () {
                if (!User::find()->where(['email' => $this->email])->exists()) {
                    $this->addError('email', 'Пользователя с таким email-адрессом не существует');
                }
            }]
        ];
    }

    /**
     * Сброс пароля
     *
     * TODO отправка письма на почту
     *
     * @return bool
     * @throws \yii\web\NotFoundHttpException
     */
    public function generatePasswordResetToken()
    {
        $user = User::findOneStrictException(['email' => $this->email]);
        $user->generatePasswordResetToken();

        return $user->save();
    }
}