<?php

use kartik\sortable\Sortable;
use kartik\widgets\Select2;
use wbraganca\dynamicform\DynamicFormAsset;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var \common\models\forms\ProductForm $model
 * @var \common\models\products\ProductColor[] $data
 * @var array $colors
 * @var boolean $isNewRecord
 */

$this->title = 'Настройки товара';

$this->params['breadcrumbs'][] = ['label' => 'Товары ', 'url' => ['/product']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

/** @var \common\models\products\Product $product */
$product = $model->product;
$this->registerJsFile('@web/js/yii2-dynamic-form.js', ['depends' => DynamicFormAsset::class]);
$this->registerJsFile('@web/js/product.js');
$js = <<<JS
  $(".dynamicform_wrapper").on('afterInsert',function () {
        $('.hidden_id').val($('.product_id').data('id'));
  });
JS;

$this->registerJs($js);
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

                <h3 class="text-center">Сортировка изображений</h3>
                <div class="col-md-12 sort_ul">
                    <?= Sortable::widget([
                        'type'        => Sortable::TYPE_GRID,
                        'items'       => $model->buildSortable(),
                        'handleLabel' => '<i class="glyphicon glyphicon-move"><i>',
                    ]); ?>
                </div>
                <br>
                <hr>
                <h3 class="text-center">Цвета товара</h3>
                <?php $form = ActiveForm::begin(['id' => 'properties-form']) ?>
                <div class="col-md-12 url_handler" data-url="<?= Url::toRoute(['ajax/save-product-settings'])?>">
                    <?php DynamicFormWidget::begin([
                        'widgetContainer' => 'dynamicform_wrapper',
                        'widgetBody'      => '.container-items',
                        'widgetItem'      => '.item',
                        'limit'           => 5000,
                        'min'             => 1,
                        'insertButton'    => '.add-item',
                        'deleteButton'    => '.remove-item',
                        'model'           => $data[0],
                        'formId'          => 'properties-form',
                        'formFields'      => [
                            'id',
                            'product_id',
                            'color_id',
                        ],
                    ]); ?>
                    <div class="container-items">
                        <?php foreach ($data as $i => $item): ?>
                            <div class="item panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title pull-left">Цвет</h3>
                                    <div class="pull-right">
                                        <button type="button" class="add-item btn btn-success btn-xs"><i
                                                    class="glyphicon glyphicon-plus"></i></button>
                                        <button type="button" class="remove-item btn btn-danger btn-xs"><i
                                                    class="glyphicon glyphicon-minus"></i></button>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <span class="hidden product_id" data-id="<?= $product->id ?>"></span>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?= $form->field($item, "[{$i}]product_id")->hiddenInput(['value' => $product->id, 'class' => 'hidden_id'])->label(false) ?>
                                        </div>
                                        <div class="col-md-12">
                                            <?= $form->field($item, "[{$i}]color_id")->widget(Select2::class, [
                                                'data'          => $colors,
                                                'language'      => 'ru',
                                                'options'       => ['placeholder' => 'Цвет'],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                ],
                                            ])->label(false);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php DynamicFormWidget::end(); ?>
                    </div>
                    <div class="col-md-12">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                        <hr>
                    </div>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
</article>
