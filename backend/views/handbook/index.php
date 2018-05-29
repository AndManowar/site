<?php

use common\components\handbook\models\Handbook;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/**
 * @var Handbook $searchModel
 * @var \yii\data\ActiveDataProvider $dataProvider
 */

$this->title = 'Справочники';
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
                    <a href="<?= Url::toRoute(['handbook/create']) ?>" class="btn btn-success"><i class="fa fa-lg fa-fw fa-plus"></i></a>
                    <a href="<?= Url::toRoute(['handbook/reset-cache']) ?>" class="btn btn-warning"><i class="fa fa-lg fa-fw fa-refresh"></i></a>
                    <br>
                    <br>
                    <div class="widget-body no-padding">
                        <?php Pjax::begin() ?>
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
                                'systemName',
                                'description',
                                [
                                    'header'  => 'Создано',
                                    'content' => function ($model) {
                                        return Yii::$app->formatter->asDatetime($model->created_at, 'dd/MM/Y H:i');
                                    },
                                ],
                                [
                                    'header'  => 'Обновлено',
                                    'content' => function ($model) {
                                        return Yii::$app->formatter->asDatetime($model->updated_at, 'dd/MM/Y H:i');
                                    },
                                ],
                                [
                                    'class'          => 'yii\grid\ActionColumn',
                                    'header'         => 'Действия',
                                    'headerOptions'  => ['class' => 'text-right'],
                                    'contentOptions' => ['class' => 'td-actions text-right'],
                                    'template'       => '{update} {clone} {delete}',
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
                                                'data-confirm' => 'Вы уверены, что хотите удалить справочник?',
                                                'data-method'  => 'post'
                                            ]);
                                        },
                                    ],
                                ],
                            ],
                        ]); ?>
                        <?php Pjax::end() ?>
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>