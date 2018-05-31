<?php

use kartik\sortable\Sortable;
use yii\helpers\Html;
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
            <div class="widget-body no-padding">
                <ul id="sortable" style="list-style-type: none;">
                    <?php
                    echo Sortable::widget([
                        'type' => Sortable::TYPE_GRID,
                        'items' => $model->buildSortable()
                    ]);
                    ?>

                </ul>
            </div>
        </div>
    </div>
</article>
