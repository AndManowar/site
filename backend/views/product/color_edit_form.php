<?php

use yii\widgets\ActiveForm;
use common\models\products\ProductColor;

/**
 * @var ProductColor $model
 * @var array $colors
 */
?>

<div class="col-md-12">
    <?php $form = ActiveForm::begin(['action' => \yii\helpers\Url::toRoute(['product/edit-color', 'id' => $model->id])]) ?>

    <?= $form->field($model, 'product_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'color_id')->dropDownList($colors)->label(false) ?>
    <?= \yii\helpers\Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    <?php ActiveForm::end() ?>
</div>
