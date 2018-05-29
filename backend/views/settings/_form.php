<?php

use common\components\settings\helpers\FormFieldsHelper;
use common\components\settings\models\Settings;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var Settings $model
 */

$this->params['breadcrumbs'][] = ['label' => 'Настройки ', 'url' => ['/user']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

$js = <<<JS
var body = $('body');
 body.on('change','.fieldType_drp select', function (e) {
        e.preventDefault();
        $.ajax({
            'method':"POST",
            'url': '/dashboard/settings/get-field',
            'data':{
                type: $(this).val()
            },
            'beforeSend': function() {
                $(".field-settings-value").remove();
           },
            'success' : function (data) {
              jQuery('#settings-form > .col-md-12 .field-settings-fieldtype').after( data );
            }
        });
    });

JS;
$this->registerJs($js, $this::POS_END);
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
                <?php $form = ActiveForm::begin(['id' => 'settings-form', 'enableAjaxValidation' => true]) ?>
                <div class="col-md-12">
                    <?= $form->field($model, 'systemName', ['options' => ['class' => 'form-group label-floating']])->textInput() ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'description', ['options' => ['class' => 'form-group label-floating']])->textInput() ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'fieldType', ['options' => ['class' => 'form-group label-floating fieldType_drp']])->dropDownList(FormFieldsHelper::getFileList(), ['prompt' => '']) ?>
                </div>
                <div class="col-md-12">
                    <?php if (!$model->isNewRecord) {
                        echo FormFieldsHelper::getFormField($form, $model, 'value', $model->fieldType);
                    } else {
                        echo $form->field($model, 'value', ['template' => '{input}'])->hiddenInput();
                    } ?>
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