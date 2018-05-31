<?php

use kartik\file\FileInput;
use kartik\widgets\Select2;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var \common\models\forms\ProductForm $model
 * @var array $categories
 * @var boolean $isNewRecord
 */

$this->params['breadcrumbs'][] = ['label' => 'Товары ', 'url' => ['/product']];
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
            <?php
            if(!$isNewRecord){
                echo Html::a('Дополнительные настройки товара', Url::toRoute(['product/step-two', 'id' => $model->product->id]), ['class' => 'btn btn-warning']);}
            ?>
            <div class="widget-body no-padding">
                <hr>
                <?php $form = ActiveForm::begin([
                    'id'      => 'category-form',
                    'options' => [
                        'enctype' => 'multipart/form-data',
                    ]]) ?>
                <h2 class="text-center">Описание товара</h2>
                <hr>
                <div class="col-md-6">
                    <?= $form->field($model, 'name', ['options' => ['class' => 'form-group label-floating']])->textInput() ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'category_id')->widget(Select2::class, [
                        'data'          => $categories,
                        'language'      => 'ru',
                        'options'       => [
                            'placeholder' => 'Категория',
                            'class'       => 'form-group label-floating',
                        ],
                        'pluginOptions' => [
                            'allowClear' => false,
                        ],
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'price', ['options' => ['class' => 'form-group label-floating']])->textInput() ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'old_price', ['options' => ['class' => 'form-group label-floating']])->textInput() ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'width', ['options' => ['class' => 'form-group label-floating']])->textInput() ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'height', ['options' => ['class' => 'form-group label-floating']])->textInput() ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'thickness', ['options' => ['class' => 'form-group label-floating']])->textInput() ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'title_file')->widget(FileInput::class, [
                        'options'       => ['multiple' => false, 'accept' => 'image/*'],
                        'pluginOptions' => [
                            'previewFileType'      => 'any',
                            'maxFileSize'          => 10000,
                             'initialPreview'       => !$isNewRecord ? $model->getPreview()['title'] : [],
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
                <h3 class="text-center">Дополнительные изображения</h3>
                <div class="col-md-12">
                    <?= $form->field($model, 'files[]')->widget(FileInput::class, [
                        'options'       => ['multiple' => true, 'accept' => 'image/*'],
                        'pluginOptions' => [
                            'previewFileType'      => 'any',
                            'maxFileSize'          => 10000,
                             'initialPreview'       => !$isNewRecord  ? $model->getPreview()['additional'] : [],
                            'initialPreviewAsData' => true,
                            'initialPreviewShowDelete' => false,
                            'overwriteInitial' => false,
                            'showCaption' => false,
                            'showRemove' => false,
                            'showUpload' => false,
                        ]])
                    ?>
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