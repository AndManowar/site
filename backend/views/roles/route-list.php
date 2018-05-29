<?php

use yii\helpers\Url;

/**
 * @var array $list
 * @var \common\components\rbac\models\GroupPermissionForm $group
 */
$this->title = 'Роуты';
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
                <div class="table-responsive">
                    <table class="table">
                        <th>Ветка</th>
                        <th>Путь</th>
                        <th></th>
                        <?php
                        foreach ($list as $item) { ?>
                            <tr>
                                <?php $info = Yii::$app->accessControl->unParseRoute($item->name);
                                echo '<td><small>' . $info['branch'] . '</small></td><td>' . $info['rout'] . '</td>'; ?>
                                <td>
                                    <a class="btn btn-sm btn-danger btn-flat"
                                       href="<?= Url::to(['/roles/remove-route', 'name' => $item->name, 'group' => $group->name]) ?>"
                                       onclick="return confirm('Вы уверены, что хотите удалить группу разрешений?')">
                                        X </a>
                                </td>
                            </tr>
                        <?php } ?>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

