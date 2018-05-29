<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;

/**
 * @var bool $isCreate
 * @var \common\components\rbac\models\GroupPermissionForm $permissions
 */

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
                <?php $form = ActiveForm::begin(['id' => 'dynamic-form']) ?>
                <div class="col-md-12">
                    <?= Html::submitButton(($isCreate) ? 'Добавить' : 'Изменить', ['class' => 'btn btn-info']) ?>
                </div>
                <hr>
                <?php if ($isCreate) { ?>
                <div class="panel-body">
                    <?php DynamicFormWidget::begin([
                        'widgetContainer' => 'dynamicform_wrapper',
                        'widgetBody'      => '.container-items',
                        'widgetItem'      => '.item',
                        'limit'           => 20,
                        'min'             => 1,
                        'insertButton'    => '.add-item',
                        'deleteButton'    => '.remove-item',
                        'model'           => $permissions[0],
                        'formId'          => 'dynamic-form',
                        'formFields'      => [
                            'systemName',
                        ],
                    ]); ?>
                    <div class="container-items">
                        <?php foreach ($permissions as $i => $item): ?>
                            <div class="item panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title pull-left">Группа разрешений</h3>
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
                                        <div class="col-md-8 col-md-offset-2">
                                            <?= $form->field($item, "[{$i}]systemName")->textInput() ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php DynamicFormWidget::end(); ?>
                    </div>
                    <?php } else { ?>
                        <div class="col-md-12">
                            <?= $form->field($permissions, 'systemName')->textInput() ?>
                        </div>
                    <?php } ?>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
</article>
