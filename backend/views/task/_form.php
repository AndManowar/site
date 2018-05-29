<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 26.04.18
 * Time: 12:08
 */

use common\components\tasks\models\Task;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var Task $task
 */
?>
<div class="jarviswidget jarviswidget-color-blueDark jarviswidget-sortable" id="wid-id-12"
     data-widget-colorbutton="false" data-widget-togglebutton="false" data-widget-editbutton="false"
     data-widget-fullscreenbutton="false" data-widget-deletebutton="false">

    <header class="ui-sortable-handle">
        <span class="widget-icon"> <i class="fa fa-arrow-down"></i> </span>
        <h2>Новая задача </h2>
        <div class="widget-toolbar" role="menu">

            <div class="btn-group">
                <button class="btn btn-xs bg-color-blueDark txt-color-white remove_task_block">
                    <i class="fa fa-remove"></i>
                </button>
            </div>
        </div>
        <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header role="heading">
    <div>
        <div class="jarviswidget-editbox">
        </div>
        <div class="widget-body">

            <?php $form = ActiveForm::begin(['action' => [$task->isNewRecord ? '/ajax/create-task' : '/ajax/update-task'], 'id' => 'new_task_form']) ?>

            <?php
            if (!$task->isNewRecord) {
                echo $form->field($task, 'id')->hiddenInput()->label(false);
            }
            ?>
            <?= $form->field($task, 'title')->textInput() ?>
            <?= $form->field($task, 'description')->textarea(['rows' => 6]) ?>
            <?= $form->field($task, 'status')->dropDownList(Task::$statusList, ['prompt' => 'Выбор статуса']) ?>
            <?= Html::submitButton($task->isNewRecord ? 'Создать' : 'Обновить', ['class' => 'btn btn-success']) ?>
            <?php ActiveForm::end() ?>

        </div>
    </div>
</div>
