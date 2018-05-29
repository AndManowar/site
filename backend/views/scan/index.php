<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var integer $branchId
 */

$this->title = 'Сканер роутов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-12">
    <div class="jarviswidget jarviswidget-color-blueDark jarviswidget-sortable" id="wid-id-0"
         data-widget-editbutton="false">
        <header class="ui-sortable-handle">
            <span class="widget-icon"> <i class="fa fa-table"></i> </span>
            <h2><?= $this->title ?></h2>
            <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>
        <div>
            <div class="jarviswidget-editbox">
            </div>
            <div class="widget-body">
                <div class="table">
                    <div class="row">
                        <?= Html::beginForm(['index'], 'post') ?>
                        <div class="col-xs-6">
                            <h3 class="box-title"><?= $this->title ?></h3>
                        </div>
                        <div class="col-xs-6">
                            <div class="input-group">
                                <span class="input-group-addon">Выбрать ветку</span>
                                <?= Html::dropDownList('branch', $branchId, ArrayHelper::getColumn($branch, 2), ['class' => 'form-control']) ?>
                                <span class="input-group-btn">
                        <?= Html::submitInput('Сканировать', ['class' => 'btn btn-primary btn-flat']) ?>
                    </span>
                            </div>
                        </div>
                        <?php echo Html::endForm(); ?>
                    </div>
                    <table class="table table-bordered table-hover" id="scan-new-rout-table" data-branch-id="<?= $branchId ?>">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Контроллер/метод</th>
                            <th>Добавить в группу</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>


                        <?php foreach ($scanList as $key => $item) { ?>
                            <tr data-rout-name="<?= $item ?>">
                                <td><?= $key ?></td>
                                <td><?= $item ?></td>
                                <td><?= Html::dropDownList('group', null, ArrayHelper::map($group, 'name', 'description')) ?></td>
                                <td><?= Html::submitButton('Добавить', ['class' => 'item-save-btn btn btn-primary btn-flat btn-xs']) ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
