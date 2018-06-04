<?php

use kartik\file\FileInput;
use kartik\widgets\Select2;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var \common\models\forms\SetForm $model
 * @var boolean $isNewRecord
 */

$this->params['breadcrumbs'][] = ['label' => 'Товары ', 'url' => ['/product']];
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
            <?php
            if (!$isNewRecord) {
                echo Html::a('Товары подборки', Url::toRoute(['set/set-products', 'id' => $model->set->id]), ['class' => 'btn btn-warning']);
            }
            ?>
            <div class="widget-body no-padding">
                <hr>
                <?php $form = ActiveForm::begin([
                    'id'                     => 'product-form',
                    'enableClientValidation' => $isNewRecord ? true : false,
                    'enableAjaxValidation'   => $isNewRecord ? false : true,
                    'options'                => [
                        'enctype' => 'multipart/form-data',
                    ]]) ?>
                <h2 class="text-center">Описание товара</h2>
                <hr>
                <div class="col-md-6">
                    <?= $form->field($model, 'name', ['options' => ['class' => 'form-group label-floating']])->textInput() ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'alias', ['options' => ['class' => 'form-group label-floating']])->textInput() ?>
                </div>

                <div class="col-md-12">
                    <?= $form->field($model, 'file')->widget(FileInput::class, [
                        'options'       => ['multiple' => false, 'accept' => 'image/*'],
                        'pluginOptions' => [
                            'previewFileType'      => 'any',
                            'maxFileSize'          => 10000,
                            'initialPreview'       => !$isNewRecord ? Yii::getAlias('@setImagePreviewPath/').$model->set->image : [],
                            'initialPreviewAsData' => true,
                        ]])
                    ?>
                </div>

                <div class="col-md-12">
                    <?= $form->field($model, 'description_text')->widget(CKEditor::class, [
                        'editorOptions' => ElFinder::ckeditorOptions('elfinder', []),
                    ]) ?>
                </div>

                <hr>
                <h3 class="text-center">Meta</h3>
                <hr>
                <div class="col-md-4">
                    <?= $form->field($model, 'title', ['options' => ['class' => 'form-group label-floating']])->textInput() ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'keywords', ['options' => ['class' => 'form-group label-floating']])->textInput() ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'caption', ['options' => ['class' => 'form-group label-floating']])->textInput() ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'description', ['options' => ['class' => 'form-group label-floating']])->textarea() ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'is_shown', ['options' => ['class' => 'form-group label-floating']])->checkbox() ?>
                </div>
                <hr>
                <div class="col-md-12">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-fill btn-success']) ?>
                    <hr>
                </div>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
</article>

<style>
    .file-thumbnail-footer {
        display: none;
    }
</style>