<?php

use common\components\handbook\models\Handbook;
use common\components\handbook\models\HandbookFields;
use common\components\handbook\TypeHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

/**
 * @var Handbook $handbook
 * @var HandbookFields[] $fields
 */

$this->title = $handbook->isNewRecord ? 'Новый справочник' : 'Обновление структуры справочника';

$action = $handbook->isNewRecord ? ['create'] : ['update-structure', 'id' => $handbook->id];
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
                    'id'                     => 'dynamic-form',
                    'action'                 => $action,
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => false,
                ]) ?>
                <div class="col-md-12">
                    <hr>
                    <h4 style="text-align: center">Информация о справочнике</h4>

                    <div class="col-md-4">
                        <?= $form->field($handbook, 'systemName')->textInput() ?>
                    </div>
                    <div class="col-md-4">
                        <?= $form->field($handbook, 'description')->textInput() ?>
                    </div>
                    <div class="col-md-4">
                        <?= $form->field($handbook, 'relation')->dropDownList(Yii::$app->handbook->getHandbooksList($handbook->isNewRecord ? null : $handbook->id), ['prompt' => 'Родительский справочник']) ?>
                    </div>
                    <div class="col-md-12">
                        <?= Html::submitButton($handbook->isNewRecord ? 'Сохранить' : 'Изменить', ['class' => 'btn btn-info']) ?>
                        <?php if (!$handbook->isNewRecord) { ?>
                            <a href="<?= Url::toRoute(['handbook/update', 'id' => $handbook->id]) ?>"
                               class="btn btn-danger"> Перейти к данным </a>
                        <?php } ?>
                        <button class="btn btn-warning add_field pull-right"
                                data-state="<?= $handbook->isNewRecord && count($fields) < 2 ? 1 : 2 ?>">Дополнительные
                            поля
                        </button>
                        <hr>
                    </div>

                </div>
                <div class="col-md-12 block_on_top <?= $handbook->isNewRecord && count($fields) < 2 ? 'hidden' : '' ?> additional_fields">
                    <h4 style="text-align: center">Добавить поля к справочнику</h4>
                    <hr>

                    <div class="panel-body">
                        <?php DynamicFormWidget::begin([
                            'id'              => 'fields_is',
                            'widgetContainer' => 'dynamicform_wrapper',
                            'widgetBody'      => '.container-items',
                            'widgetItem'      => '.item',
                            'limit'           => 999,
                            'min'             => 1,
                            'insertButton'    => '.add-item',
                            'deleteButton'    => '.remove-item',
                            'model'           => $fields[0],
                            'formId'          => 'dynamic-form',
                            'formFields'      => [
                                'name',
                                'description',
                                'type',
                                'notNull',
                            ],
                        ]); ?>

                        <div class="container-items">
                            <?php foreach ($fields as $i => $item): ?>
                                <div class="item panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title pull-left">Добавить поля</h3>
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
                                            <div class="col-sm-3">
                                                <?= $form->field($item, "[{$i}]name")->textInput() ?>
                                            </div>
                                            <div class="col-sm-3">
                                                <?= $form->field($item, "[{$i}]description")->textInput() ?>
                                            </div>
                                            <div class="col-sm-3">
                                                <?= $form->field($item, "[{$i}]type")->dropDownList(TypeHelper::getTitleTypes(), ['prompt' => '--Тип поля--']) ?>
                                            </div>
                                            <div class="col-sm-3">
                                                <?= $form->field($item, "[{$i}]notNull")->checkbox() ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <?php DynamicFormWidget::end(); ?>
                        </div>
                    </div>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
</article>