<?php

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var \common\models\forms\ColorForm $model
 * @var bool $isNewRecord
 */

$this->params['breadcrumbs'][] = ['label' => 'Цвета ', 'url' => ['/color']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<article class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">

    <div class="jarviswidget jarviswidget-sortable" id="wid-id-0" data-widget-colorbutton="false"
         data-widget-editbutton="false" data-widget-custombutton="false">
        <header class="ui-sortable-handle">
            <h2><?= $this->title ?> </h2>
            <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>
        <div class="content">
            <div class="jarviswidget-editbox">
            </div>
            <div class="widget-body no-padding">
                <hr>
                <?php $form = ActiveForm::begin(['id' => 'settings-form']) ?>
                <div class="col-md-12">
                    <?= $form->field($model, 'name', ['options' => ['class' => 'form-group label-floating']])->textInput() ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'file')->widget(FileInput::class, [
                        'options'       => ['multiple' => false, 'accept' => 'image/*'],
                        'pluginOptions' => [
                            'previewFileType'      => 'any',
                            'maxFileSize'          => 10000,
                            'initialPreview'       => !$isNewRecord ? $model->getPreviewImage() : [],
                            'initialPreviewAsData' => true,
                        ]])
                    ?>
                </div>

                <div class="col-md-12">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-fill btn-success']) ?>
                    <hr>
                </div>

                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
</article>