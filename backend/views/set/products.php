<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 03.06.2018
 * Time: 18:37
 */
use common\models\sets\SetProduct;
use kartik\widgets\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \common\models\forms\SetForm $model
 */
/* @var $this \yii\web\View */

$this->title = 'Товары';

$this->params['breadcrumbs'][] = ['label' => 'Подборки ', 'url' => ['/set']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

$product = new SetProduct();
?>


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
                <?php $form = ActiveForm::begin(['action' => Url::toRoute(['set/add-product', 'id' => $model->set->id])]) ?>
                <?= $form->field($product, 'set_id')->hiddenInput(['value' => $model->set->id])->label(false) ?>
                <?= $form->field($product, "product_id")->widget(Select2::class, [
                    'data'          => $model->getActiveProducts(),
                    'language'      => 'ru',
                    'options'       => ['placeholder' => 'Товар'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]);
                ?>
                <?= $form->field($product, 'quantity')->textInput() ?>
            </div>
            <div class="modal-footer">
                <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>

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
                <h3 class="text-center">Товары в подборке</h3>
                <!-- Button trigger modal -->
                <div class="col-md-12">
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#add_color">
                        Добавить товар
                    </button>
                    <hr>
                </div>
                <?php if (count($model->set->products) > 0) { ?>
                    <div class="col-md-12">
                        <table class="table">
                            <tr>
                                <th>Товар</th>
                                <th>Количество</th>
                                <th>Действия</th>
                            </tr>
                            <?php foreach ($model->set->products as $setProduct) { ?>
                                <tr>
                                    <td><?= $setProduct->product->name ?></td>
                                    <td><?= $setProduct->quantity ?></td>
                                    <td><a href="" class="btn btn-warning edit_color" data-id=""
                                           data-url="<?= Url::toRoute(['ajax/get-color-form']) ?>"><i
                                                    class="fa fa-lg fa-fw fa-edit"></i></a>
                                        <a href="<?= Url::toRoute(['product/delete-color', 'id' => 3]) ?>"
                                           class="btn btn-danger"
                                           onclick="return confirm('Вы уверены, что хотите открепить цвет от товара?')"><i
                                                    class="fa fa-lg fa-fw fa-trash"></i></a></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                <?php } ?>
            </div>
        </div>
</article>
