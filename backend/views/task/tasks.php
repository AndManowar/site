<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 25.04.18
 * Time: 15:49
 */

use common\components\tasks\models\Task;
use yii\helpers\StringHelper;
use yii\widgets\Pjax;

/**
 * @var array $tasks
 */

?>

<article class="col-sm-12 col-md-12 col-lg-12">

    <div class="new_task_block"></div>
    <div class="jarviswidget jarviswidget-color-blue" id="wid-id-4" data-widget-editbutton="false"
         data-widget-colorbutton="false">
        <header>
            <span class="widget-icon"> <i class="fa fa-check txt-color-white"></i> </span>
            <h2> Задачи </h2>
            <div class="widget-toolbar">


                <div class="btn-group" data-toggle="buttons">
                    <button class="btn bg-color-blueDark txt-color-white btn-xs add_new_task"><i class="fa fa-plus"
                                                                                                 data-toggle="tooltip"
                                                                                                 data-placement="top"
                                                                                                 title="Создать задачу"></i>
                    </button>
                    <button class="btn bg-color-blueDark txt-color-white btn-xs remove_complete_tasks"
                            data-toggle="tooltip" data-placement="top" title="Очистить завершенные задачи"><i
                                class="fa fa-trash"></i></button>
                </div>
            </div>
        </header>
        <?php Pjax::begin(['id' => 'tasks_pjax']) ?>
        <!-- widget div-->
        <div>
            <!-- widget edit box -->
            <div class="jarviswidget-editbox">
                <div>
                    <label>Title:</label>
                    <input type="text" title=""/>
                </div>
            </div>
            <!-- end widget edit box -->
            <div class="progress">
                <div class="progress-bar bg-color-redLight" data-transitiongoal="100" aria-valuenow="100"
                     style="width: <?= $tasks['progress'] ?>%;"><?= $tasks['progress'] ?>%
                </div>
            </div>
            <div class="widget-body no-padding smart-form">
                <!-- content goes here -->
                <h5 class="todo-group-title"><i
                            class="fa fa-tasks"></i> <?= Task::$statusList[Task::STATUS_DEFAULT] ?> (
                    <small class="num-of-tasks"><?= count($tasks[Task::STATUS_DEFAULT]) ?></small>
                    )
                </h5>

                <ul id="sortable1" class="todo" data-status="<?= Task::STATUS_DEFAULT ?>">
                    <?php foreach ($tasks[Task::STATUS_DEFAULT] as $task) { ?>
                        <li>
												<span class="handle"> <label class="checkbox">
														<input type="checkbox" name="checkbox-inline"
                                                               data-id="<?= $task->id ?>">
														<i></i> </label> </span>
                            <p>
                                <strong>Задача #<?= $task->id ?></strong>
                                - <?= StringHelper::truncate($task->title, 30) ?> [<a
                                        class="font-xs update_task" style="cursor: pointer">Подробно</a>] <span
                                        class="text-muted"><?= StringHelper::truncate($task->description, '100') ?> </span>
                                <span class="date"><?= date('d/M/Y', $task->created_at) ?></span>
                            </p>
                        </li>
                    <?php } ?>
                </ul>
                <h5 class="todo-group-title"><i
                            class="fa fa-tasks"></i> <?= Task::$statusList[Task::STATUS_IMPORTANT] ?> (
                    <small class="num-of-tasks"><?= count($tasks[Task::STATUS_IMPORTANT]) ?></small>
                    )
                </h5>
                <ul id="sortable2" class="todo" data-status="<?= Task::STATUS_IMPORTANT ?>">
                    <?php foreach ($tasks[Task::STATUS_IMPORTANT] as $task) { ?>
                        <li>
												<span class="handle"> <label class="checkbox">
														<input type="checkbox" name="checkbox-inline"
                                                               data-id="<?= $task->id ?>">
														<i></i> </label> </span>
                            <p>
                                <strong>Задача #<?= $task->id ?></strong>
                                - <?= StringHelper::truncate($task->title, 30) ?> [<a
                                        class="font-xs update_task" style="cursor: pointer">Подробно</a>] <span
                                        class="text-muted"><?= StringHelper::truncate($task->description, '100') ?> </span>
                                <span class="date"><?= date('d/M/Y', $task->created_at) ?></span>
                            </p>
                        </li>
                    <?php } ?>
                </ul>
                <h5 class="todo-group-title"><i
                            class="fa fa-tasks"></i> <?= Task::$statusList[Task::STATUS_URGENT] ?> (
                    <small class="num-of-tasks"><?= count($tasks[Task::STATUS_URGENT]) ?></small>
                    )
                </h5>
                <ul id="sortable3" class="todo" data-status="<?= Task::STATUS_URGENT ?>">
                    <?php foreach ($tasks[Task::STATUS_URGENT] as $task) { ?>
                        <li>
												<span class="handle"> <label class="checkbox">
														<input type="checkbox" name="checkbox-inline"
                                                               data-id="<?= $task->id ?>">
														<i></i> </label> </span>
                            <p>
                                <strong>Задача #<?= $task->id ?></strong>
                                - <?= StringHelper::truncate($task->title, 30) ?> [<a
                                        class="font-xs update_task" style="cursor: pointer">Подробно</a>] <span
                                        class="text-muted"><?= StringHelper::truncate($task->description, '100') ?> </span>
                                <span class="date"><?= date('d/M/Y', $task->created_at) ?></span>
                            </p>
                        </li>
                    <?php } ?>
                </ul>

                <h5 class="todo-group-title"><i class="fa fa-check"></i> <?= Task::$statusList[Task::STATUS_DONE] ?>
                    (
                    <small class="num-of-tasks"><?= count($tasks[Task::STATUS_DONE]) ?></small>
                    )
                </h5>
                <ul id="sortable5" class="todo">
                    <?php foreach ($tasks[Task::STATUS_DONE] as $task) { ?>
                        <li class="complete">
												<span class="handle"> <label
                                                            class="checkbox state-disabled">
														<input type="checkbox" name="checkbox-inline" checked="checked"
                                                               data-id="<?= $task->id ?>">
														<i></i> </label> </span>
                            <p>
                                <strong>Задача #<?= $task->id ?></strong> - <?= $task->title ?> [<a
                                        class="font-xs update_task" style="cursor: pointer">Подробно</a>] <span
                                        class="text-muted"><?= $task->description ?> </span>
                                <span class="date"><?= date('d/M/Y', $task->created_at) ?></span>
                            </p>
                        </li>
                    <?php } ?>
                </ul>
                <!-- end content -->
            </div>
        </div>
        <!-- end widget div -->
        <?php Pjax::end() ?>
    </div>
    <!-- end widget -->
</article>
