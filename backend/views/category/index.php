<?php

use common\models\categories\Category;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var \common\models\categories\CategorySearch $searchModel */
/** @var \yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;
?>
<section id="widget-grid" class="">
    <div class="row">
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                    <h2><?= $this->title ?></h2>
                </header>
                <div>
                    <div class="jarviswidget-editbox">
                    </div>
                    <a href="<?= Url::toRoute(['category/create']) ?>" class="btn btn-success"><i
                                class="fa fa-lg fa-fw fa-plus"></i></a>
                    <a href="<?= Url::toRoute(['category/configurate-tree']) ?>" class="btn btn-warning"><i
                                class="fa fa-lg fa-fw fa-gear"></i></a>
                    <a href="<?= Url::toRoute(['category/reset-cache']) ?>" class="btn btn-danger">Очистить кэш</a>
                    <br>
                    <br>
                    <div class="widget-body no-padding">
                        <?php \yii\widgets\Pjax::begin() ?>
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel'  => $searchModel,
                            'tableOptions' => [
                                'class' => 'table'
                            ],
                            'layout'       => '{items} <div class="box-footer clearfix">{pager}</div>',
                            'pager'        => [
                                'options' => [
                                    'class' => 'pagination pagination-sm no-margin pull-right'
                                ],
                            ],
                            'columns'      => [
                                [
                                    'class'          => 'yii\grid\SerialColumn',
                                    'headerOptions'  => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center']
                                ],
                                [
                                    'label'  => 'Картинка',
                                    'format' => 'html',
                                    'value'  => function ($model) {
                                        return Html::img('@categoryImagePreviewPath/'.$model->image, ['width' => 100]);
                                    },
                                ],
                                'name',
                                'caption',
                                [
                                    'format' => 'html',
                                    'label'  => 'Положение в дереве',
                                    'value'  => function ($model) {
                                        /** @var Category $model */
                                        if ($model->isRoot()) {
                                            return '<span class="label label-success">Root</span>';
                                        }

                                        return '<span class="label label-danger">Child</span>';
                                    }
                                ],
                                [
                                    'format' => 'html',
                                    'label'  => 'Активность',
                                    'value'  => function ($model) {
                                        /** @var Category $model */
                                        if ($model->active) {
                                            return '<span class="label label-success">Active</span>';
                                        }

                                        return '<span class="label label-danger">Not Active</span>';
                                    }
                                ],
                                'created_at:datetime',
                                [
                                    'class'          => 'yii\grid\ActionColumn',
                                    'header'         => 'Действия',
                                    'headerOptions'  => ['class' => 'text-right'],
                                    'contentOptions' => ['class' => 'td-actions text-right'],
                                    'template'       => '{update} {delete}',
                                    'buttons'        => [
                                        'update' => function ($url) {
                                            return Html::a(
                                                '<i class="material-icons">edit</i>',
                                                $url, ['class' => 'btn btn-success']);
                                        },
                                        'delete' => function ($url) {
                                            return Html::a(
                                                '<i class="material-icons">close</i>',
                                                $url, [
                                                'class'        => 'btn btn-danger',
                                                'title'        => 'Удалить',
                                                'aria-label'   => 'Удалить',
                                                'data-pjax'    => '0',
                                                'data-confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                                                'data-method'  => 'post'
                                            ]);
                                        },
                                    ],
                                ],
                            ],
                        ]); ?>
                        <?php \yii\widgets\Pjax::end() ?>
                        <br>
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>