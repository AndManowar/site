<?php

use common\models\forms\CategoryForm;
use kartik\file\FileInput;
use kartik\widgets\Select2;
use kartik\widgets\SwitchInput;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var CategoryForm $model
 * @var array $roots
 * @var boolean $isNewRecord
 */

$this->params['breadcrumbs'][] = ['label' => 'Категории ', 'url' => ['/category']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

$this->registerJsFile('@web/js/category-js.js');
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
                <?php $form = ActiveForm::begin([
                    'id'      => 'category-form',
                    'options' => [
                        'enctype' => 'multipart/form-data',
                    ]]) ?>
                <div class="col-md-12">
                    <?= $form->field($model, 'name', ['options' => ['class' => 'form-group label-floating']])->textInput() ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'alias', ['options' => ['class' => 'form-group label-floating']])->textInput() ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'caption', ['options' => ['class' => 'form-group label-floating']])->textInput() ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'file')->widget(FileInput::class, [
                        'options'       => ['multiple' => false, 'accept' => 'image/*'],
                        'pluginOptions' => [
                            'previewFileType'      => 'any',
                            'maxFileSize'          => 10000,
                            'initialPreview'       => !$isNewRecord && $model->hasImage() ? $model->getPreviewImage() : [],
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
                <div class="col-md-12">
                    <?= $form->field($model, 'title', ['options' => ['class' => 'form-group label-floating']])->textInput() ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'keywords', ['options' => ['class' => 'form-group label-floating']])->textInput() ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'description', ['options' => ['class' => 'form-group label-floating']])->textInput() ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'active', ['options' => ['class' => 'form-group label-floating']])->checkbox() ?>
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