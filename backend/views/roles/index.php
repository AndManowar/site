<?php


use yii\helpers\Url;

/** @var \yii\rbac\Role $roles */

$this->title = 'Разрешения';

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-12">
    <div class="jarviswidget well" id="wid-id-3" data-widget-colorbutton="false" data-widget-editbutton="false"
         data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false"
         data-widget-custombutton="false" data-widget-sortable="false">
        <header>
            <span class="widget-icon"> <i class="fa fa-comments"></i> </span>
            <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>
        <div>
            <div class="jarviswidget-editbox">
            </div>
            <div class="widget-body">
                <p>Редактирование RBAC</p>
                <hr class="simple">
                <ul id="myTab1" class="nav nav-tabs bordered">
                    <li class="active">
                        <a href="#s1" data-toggle="tab" aria-expanded="true">Роли</a>
                    </li>
                    <li>
                        <a href="#s2" data-toggle="tab" aria-expanded="true">Группы разрешений</a>
                    </li>
                    <li>
                        <a href="#s3" data-toggle="tab" aria-expanded="true">Роли/разрешения </a>
                    </li>
                </ul>

                <div id="myTabContent1" class="tab-content padding-10">
                    <div class="tab-pane fade active in" id="s1">
                        <a href="<?= Url::to(['/roles/create-update']) ?>"
                           class="btn btn-success"><i
                                    class="fa fa-lg fa-fw fa-plus"></i></a>
                        <hr>
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Системное имя</th>
                                <th>Описание</th>
                                <th>Создано</th>
                                <th>Изменено</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($roles as $item) { ?>
                                <tr data-key="<?= $item->name ?>">
                                    <td data-af-name="name"
                                        data-af-value="<?= $item->name ?>"><?= $item->name ?></td>
                                    <td data-af-name="description"
                                        data-af-value="<?= $item->description ?>"><?= $item->description ?></td>
                                    <td><?= date('H:i / d-m-Y', $item->createdAt) ?></td>
                                    <td><?= date('H:i / d-m-Y', $item->updatedAt) ?></td>
                                    <td>
                                        <a class="btn btn-success btn-sm btn-flat"
                                           href="<?= Url::to(['create-update', 'name' => $item->name]) ?>"><i
                                                    class="material-icons">build</i></a>

                                        <a class="btn btn-danger btn-sm btn-flat"
                                           onclick="return confirm('Вы уверены, что хотите удалить роль?')"
                                           href="<?= Url::to(['index', 'name' => $item->name]) ?>"><i
                                                    class="material-icons">delete</i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="s2">
                        <a href="<?= Url::to(['/roles/create-update-group-permission']) ?>"
                           class="btn btn-success"><i
                                    class="fa fa-lg fa-fw fa-plus"></i></a>
                        <hr>
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Системное имя</th>
                                <th>Описание</th>
                                <th>Создано</th>
                                <th>Изменено</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($permissions as $item) { ?>
                                <tr data-key="<?= $item->name ?>">
                                    <td data-af-name="name"
                                        data-af-value="<?= $item->name ?>"><?= $item->name ?></td>
                                    <td data-af-name="description"
                                        data-af-value="<?= $item->description ?>"><?= $item->description ?></td>
                                    <td><?= date('H:i / d-m-Y', $item->createdAt) ?></td>
                                    <td><?= date('H:i / d-m-Y', $item->updatedAt) ?></td>
                                    <td>
                                        <a class="btn btn-success btn-sm btn-flat"
                                           href="<?= Url::to(['create-update-group-permission', 'name' => $item->name]) ?>"><i
                                                    class="material-icons">build</i></a>

                                        <a class="btn btn-warning btn-sm btn-flat"
                                           href="<?= Url::to(['route-list', 'name' => $item->name]) ?>"><i
                                                    class="material-icons">description</i></a>
                                        <a class="btn btn-danger btn-sm btn-flat"
                                           href="<?= Url::to(['index', 'name' => $item->name, 'type' => 2]) ?>"
                                           onclick="return confirm('Вы уверены, что хотите удалить группу разрешений?')"><i
                                                    class="material-icons">delete</i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="s3">
                        <table class="table table-bordered table-hover"
                               id="access-permission-change-tbl">
                            <thead>
                            <tr>
                                <th></th>
                                <?php foreach ($roles as $item) { ?>
                                    <th><?= $item->description ?></th>
                                <?php } ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($permissions as $gItem) {
                                $tableTr = '';
                                foreach ($roles as $rItem) {
                                    $tmpP = Yii::$app->authManager->getPermissionsByRole($rItem->name);
                                    if (isset($tmpP[$gItem->name])) {

                                        $tableTr .= '<td data-role="' . $rItem->name . '"><div class="checkbox checkbox-slider--b-flat"><label><input class="access-permission-change-checkbox" type="checkbox" checked><span class="access-permission-change-checkbox"></span></label></div></td>';
                                    } else {
                                        $tableTr .= '<td data-role="' . $rItem->name . '"><div class="checkbox checkbox-slider--b-flat"> <label><input class="access-permission-change-checkbox" type="checkbox"><span class="access-permission-change-checkbox"></span></label></div></td>';
                                    }
                                }

                                ?>
                                <tr data-group="<?= $gItem->name ?>">
                                    <td style="text-align: left;"><?= $gItem->description ?></td>
                                    <?= $tableTr ?>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>