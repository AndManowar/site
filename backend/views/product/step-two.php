<?php

use common\models\products\ProductColor;
use kartik\sortable\Sortable;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var \common\models\forms\ProductForm $model
 * @var ProductColor[] $data
 * @var ProductColor[] $productColors
 * @var array $colors
 * @var boolean $isNewRecord
 */

$this->title = 'Настройки товара';

$this->params['breadcrumbs'][] = ['label' => 'Товары ', 'url' => ['/product']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

/** @var \common\models\products\Product $product */
$product = $model->product;
$this->registerJsFile('@web/js/product.js');
$color = new ProductColor();
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
                <?php if (!empty($product->productsImages)) { ?>
                    <h3 class="text-center">Сортировка изображений</h3>
                    <span class="url_handler hidden"
                          data-url="<?= Url::toRoute(['ajax/save-product-settings']) ?>"></span>
                    <div class="col-md-12 sort_ul">
                        <?= Sortable::widget([
                            'type'         => Sortable::TYPE_GRID,
                            'items'        => $model->buildSortable(),
                            'handleLabel'  => '<i class="glyphicon glyphicon-move"><i>',
                            'pluginEvents' => [
                                'sortupdate' => 'function() { sort(); }',
                            ],
                        ]); ?>
                    </div>
                    <br>
                    <hr>
                <?php } ?>
                <h3 class="text-center">Цвета товара</h3>
                <!-- Button trigger modal -->
                <div class="col-md-12">
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#add_color">
                        Добавить цвет
                    </button>
                    <hr>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="add_color" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Новый цвет</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <?php $form = ActiveForm::begin(['action' => Url::toRoute(['product/add-color', 'id' => $product->id])]) ?>
                                <?= $form->field($color, 'product_id')->hiddenInput(['value' => $product->id])->label(false) ?>
                                <?= $form->field($color, "color_id")->widget(Select2::class, [
                                    'data'          => $colors,
                                    'language'      => 'ru',
                                    'options'       => ['placeholder' => 'Цвет'],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                    ],
                                ]);
                                ?>
                            </div>
                            <div class="modal-footer">
                                <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                            </div>
                            <?php ActiveForm::end() ?>
                        </div>
                    </div>
                </div>
                <?php if (!empty($productColors)) { ?>
                    <table class="table">
                        <tr>
                            <th>Изображение</th>
                            <th>Цвет</th>
                            <th>Действия</th>
                        </tr>
                        <?php
                        /** @var ProductColor $color */
                        foreach ($productColors as $color) { ?>
                            <tr>
                                <td><img src="<?= Yii::getAlias('@colorImagePreviewPath/') . $color->color->image ?>"
                                         alt=""
                                         style="width: 50px">
                                </td>
                                <td class="color_name"><?= $color->color->name ?>
                                    <div class="hidden_form hidden"></div>
                                </td>
                                <td>
                                    <a href="" class="btn btn-warning edit_color" data-id="<?= $color->id ?>"
                                       data-url="<?= Url::toRoute(['ajax/get-color-form']) ?>"><i
                                                class="fa fa-lg fa-fw fa-edit"></i></a>
                                    <a href="<?= Url::toRoute(['product/delete-color', 'id' => $color->id]) ?>"
                                       class="btn btn-danger"
                                       onclick="confirm('Вы уверены, что хотите открепить цвет от товара?')"><i
                                                class="fa fa-lg fa-fw fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } ?>
            </div>
        </div>
</article>

<script>
    function sort() {
        var sort_order = [];

        $('.sort_ul ul li img').each(function () {
            sort_order.push($(this).data('id'));
        });

        $.ajax({
            url: $('.url_handler').data('url'),
            type: "POST",
            data: {
                sort_order: sort_order,
                product_id: $('.product_id').data('id')
            },
            error: function () {
                alert('Error');
            }
        });
    }
</script>