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
                    'id'                   => 'category-form',
                    'enableAjaxValidation' => true,
                    'options'              => [
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
                            'previewFileType' => 'any',
                            'maxFileSize'     => 10000,
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
                <hr>


                <h2 class="text-center chechbox">Положение в дереве</h2>
                <?php if ($isNewRecord) { ?>
                    <hr>

                    <div class="col-md-12">
                        <div class="col-md-2 col-md-offset-1">
                            <?= $form->field($model, 'is_root')->widget(SwitchInput::class, [
                                'type'         => SwitchInput::CHECKBOX,
                                'pluginEvents' => [
                                    "switchChange.bootstrapSwitch" => "function() { 
                                if($(this).is(':checked')) {
                                $('.tree_options').addClass('hidden');}
                            else $('.tree_options').removeClass('hidden'); }",
                                ],
                            ]) ?>
                        </div>
                        <div class="col-md-6 col-md-offset-1">
                            <div class="tree_options hidden">
                                <?php if (!empty($roots)) {
                                    echo $form->field($model, 'root')->widget(Select2::class, [
                                        'data'          => $roots,
                                        'language'      => 'ru',
                                        'options'       => ['placeholder' => 'Выбрать корневой элемент', 'class' => 'selected_tree'],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                        ],
                                    ]);
                                } else {
                                    echo '<h1 class="txt-color-red"> Нет ни одного доступного корневого элемента </h1>';
                                } ?>
                            </div>
                        </div>
                    </div>
                <?php } else {
                    echo '<div class="col-md-8 col-md-offset-2">';
                    if ($model->is_root) {
                        echo '<h1 class="text-center txt-color-red"> Корневой элемент </h1>';
                    } else {
                        echo '<h1 class="text-center txt-color-red"> Дочерний элемент, предок - ' . \common\models\categories\Category::find()->roots()->where(['id' => $model->root])->one()->name . '</h1>';
                    }
                }
                echo '</div>'; ?>
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