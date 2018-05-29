<?php

use common\components\handbook\models\Handbook;
use common\components\handbook\models\HandbookFields;
use common\components\handbook\TypeHelper;
use kartik\widgets\Select2;
use wbraganca\dynamicform\DynamicFormAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

/**
 * @var Handbook $handbook
 * @var HandbookFields[] $fields
 * @var array $data
 */

$this->title = 'Данные справочника';

$js = <<<JS
  $(".dynamicform_wrapper").on('afterInsert',function () {
  var hb_id = $('.hb_id');
        hb_id.find('input:hidden').val(hb_id.data('id'));
        
  });
JS;

$this->registerJs($js);
$this->registerJsFile('@web/js/yii2-dynamic-form.js', ['depends' => DynamicFormAsset::class])
?>

<article class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">

    <!-- Widget ID (each widget will need unique ID)-->
    <div class="jarviswidget jarviswidget-sortable" id="wid-id-0" data-widget-colorbutton="false"
         data-widget-editbutton="false" data-widget-custombutton="false">
        <header class="ui-sortable-handle">
            <h2><?= $this->title ?> </h2>
            <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>
        <div class="content">
            <div class="jarviswidget-editbox">
            </div>
            <div class="widget-body no-padding">
                <?php $form = ActiveForm::begin([
                    'id'                     => 'dynamic-form1',
                    'action'                 => ['update', 'id' => $handbook->id],
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => false,
                ]) ?>
                <br>
                <div class="col-md-12">
                    <?= Html::submitButton('Сохранить записи', ['class' => 'btn btn-success']) ?>
                    <?= Html::a('Изменить структуру справочника', Url::toRoute(['handbook/update-structure', 'id' => $handbook->id]), ['class' => 'btn btn-warning']) ?>
                </div>
                <hr>
                <div class="col-md-12">
                    <?php DynamicFormWidget::begin([
                        'widgetContainer' => 'dynamicform_wrapper',
                        'widgetBody'      => '.container-items',
                        'widgetItem'      => '.item',
                        'limit'           => 5000,
                        'min'             => 1,
                        'insertButton'    => '.add-item',
                        'deleteButton'    => '.remove-item',
                        'model'           => $data[0],
                        'formId'          => 'dynamic-form1',
                        'formFields'      => [
                            'id',
                            'handbook_id',
                            'data_id',
                            'value',
                            'title',
                            'relation',
                            'additionalFields',
                        ],
                    ]); ?>
                    <h3 style="text-align: center">Добавить значения справочника</h3>
                    <div class="container-items">
                        <?php foreach ($data as $i => $item): ?>
                            <div class="item panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title pull-left">Значение справочника</h3>
                                    <div class="pull-right">
                                        <button type="button" class="add-item btn btn-success btn-xs"><i
                                                    class="glyphicon glyphicon-plus"></i></button>
                                        <button type="button" class="remove-item btn btn-danger btn-xs"><i
                                                    class="glyphicon glyphicon-minus"></i></button>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <?php if(!$item->isNewRecord){
                                            echo $form->field($item, "[{$i}]id")->hiddenInput()->label(false);
                                        }?>
                                        <div class="hb_id" data-id="<?= $handbook->id ?>">
                                            <?= $form->field($item, "[{$i}]handbook_id")->hiddenInput(['value' => $handbook->id])->label(false) ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <?= $form->field($item, "[{$i}]data_id")->textInput()->label('ID') ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <?= $form->field($item, "[{$i}]value")->textInput() ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <?= $form->field($item, "[{$i}]title")->textInput() ?>
                                        </div>
                                        <?php if ($handbook->relation) { ?>
                                            <div class="col-sm-12 select2_field">
                                                <?=
                                                $form->field($item, "[{$i}]relation")->widget(Select2::class, [
                                                    'data'          => Yii::$app->handbook->getDataForRelation($handbook->relation),
                                                    'language'      => 'ru',
                                                    'options'       => ['placeholder' => 'Родительское значение'],
                                                    'pluginOptions' => [
                                                        'allowClear' => true,
                                                    ],
                                                ]);
                                                ?>
                                            </div>
                                        <?php }
                                        if (!empty($fields)) { ?>
                                            <div class="col-md-12">
                                                <h4 style="text-align: center">Дополнительные поля</h4>
                                                <?php
                                                $countFields = round(12 / (count($fields)));
                                                foreach ($fields as $field):
                                                    $fieldType = TypeHelper::getTypes($field->type);
                                                    $fieldType = $fieldType[3];
                                                    $key = $field['name'];
                                                    ?>
                                                    <div class="col-sm-<?= $countFields ?>">
                                                        <?= $form->field($item, "[{$i}]additionalFields[$key]")->$fieldType()->label($field->description) ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php DynamicFormWidget::end(); ?>
                    </div>
                    <?php ActiveForm::end() ?>
                </div
            </div>
        </div>
    </div>
</article>