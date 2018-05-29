<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 25.04.18
 * Time: 15:44
 */

namespace common\components\tasks\services;

use common\components\tasks\models\Task;
use Yii;

/**
 * Class TaskService
 * @package common\components\tasks\services
 */
class TaskService
{
    /**
     * @return array
     */
    public function getTasksForDisplaying()
    {

        $statusDefault = Task::find()->where(['status' => Task::STATUS_DEFAULT])->orderBy(['position' => SORT_ASC])->all();
        $statusImportant = Task::find()->where(['status' => Task::STATUS_IMPORTANT])->orderBy(['position' => SORT_ASC])->all();
        $statusUrgent = Task::find()->where(['status' => Task::STATUS_URGENT])->orderBy(['position' => SORT_ASC])->all();
        $statusDone = Task::find()->where(['status' => Task::STATUS_DONE])->orderBy(['position' => SORT_ASC])->all();

        $progress = count($statusDone) == 0
            ? 0 : count($statusDone) * 100 / Task::find()->where(['!=', 'status', Task::STATUS_REMOVED])->count();

        return [
            Task::STATUS_DEFAULT   => $statusDefault,
            Task::STATUS_IMPORTANT => $statusImportant,
            Task::STATUS_URGENT    => $statusUrgent,
            Task::STATUS_DONE      => $statusDone,
            'progress'             => round($progress)
        ];
    }

    /**
     * Устанавливает значение позиции в списке задач
     *
     * @param array $order
     * @return bool
     */
    public function setTaskPosition($order)
    {
        foreach ($order as $id => $value) {

            $task = Task::findOneStrictException($value);
            $task->position = $id + 1;

            if (!$task->save()) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param Task $task
     * @return boolean
     */
    public function createTask($task)
    {
        $task->created_by = $task->updated_by = Yii::$app->user->id;
        $task->position = Task::find()->where(['status' => $task->status])->count() + 1;

        return $task->save();
    }

    /**
     * @param Task $task
     * @return boolean
     */
    public function updateTask($task)
    {
        $task->updated_by = Yii::$app->user->id;

        return $task->save();
    }

    /**
     * @return bool
     */
    public function removeDoneTasks()
    {
        foreach (Task::find()->where(['status' => Task::STATUS_DONE])->all() as $doneTask) {
            $doneTask->status = Task::STATUS_REMOVED;

            if (!$doneTask->save()) {
                return false;
            }
        }

        return true;
    }
}