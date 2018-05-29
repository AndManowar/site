<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/**
 * @var $form yii\bootstrap\ActiveForm
 * @var $this yii\web\View
 * @var \common\models\forms\LoginForm $model
 */


$this->title = 'Авторизация';
?>
<div class="col-md-12 login_layout_forms">
    <div class="col-md-6 col-md-offset-3">
        <div class="well no-padding">
            <?php $form = ActiveForm::begin(['options' => ['class' => 'smart-form client-form']]) ?>
            <header>
                Sign In
            </header>
            <fieldset>
                <section>
                    <label class="label">E-mail</label>
                    <label class="input"> <i class="icon-append fa fa-user"></i>
                        <?= $form->field($model, 'username')
                            ->textInput([
                                'placeholder' => 'Username',
                                'class'       => ''
                            ])->label(false) ?>
                        <b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Please
                            enter email address/username</b></label>
                </section>
                <section>
                    <label class="label">Password</label>
                    <label class="input"> <i class="icon-append fa fa-lock"></i>
                        <?= $form->field($model, 'password')
                            ->passwordInput([
                                'placeholder' => 'Password',
                                'class'       => ''
                            ])->label(false) ?>
                        <b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Enter
                            your password</b> </label>
                    <div class="note">
                        <a href="<?= Url::toRoute(['site/forgot-password']) ?>">Забыли пароль?</a>
                    </div>
                </section>
                <section>
                    <?= $form->field($model, 'rememberMe')->checkbox()->label('<i></i>Запомнить меня?', ['class' => 'checkbox']) ?>
                </section>
            </fieldset>
            <footer>
                <?= Html::submitButton('<i class="icon-unlock2"></i> Login', ['class' => 'btn btn-primary']) ?>
            </footer>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>

<style>
    .login_layout_forms{
        margin-top: 200px;
    }
</style>