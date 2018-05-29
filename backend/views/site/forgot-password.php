<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 23.04.18
 * Time: 15:03
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/**
 * @var \common\models\forms\ForgotPasswordForm $model
 */

$this->title = 'Сброс пароля';
?>
<div class="col-md-12 login_layout_forms">
    <div class="col-md-6 col-md-offset-3">
        <div class="well no-padding">
            <?php $form = ActiveForm::begin(['options' => ['class' => 'smart-form client-form'], 'enableAjaxValidation' => true]) ?>
            <header>
                <?= $this->title ?>
            </header>
            <fieldset>
                <section>
                    <label class="label">E-mail</label>
                    <label class="input"> <i class="icon-append fa fa-user"></i>
                        <?= $form->field($model, 'email')
                            ->textInput([
                                'placeholder' => 'Email',
                                'class'       => ''
                            ])->label(false) ?>
                    </label>
                </section>
            </fieldset>
            <footer>
                <?= Html::submitButton('<i class="icon-unlock2"></i> Запросить сброс пароля', ['class' => 'btn btn-primary']) ?>
            </footer>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>

<style>
    .login_layout_forms{
        margin-top: 250px;
    }
</style>