<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 20.04.18
 * Time: 16:05
 */

namespace backend\controllers;

use common\components\tasks\models\Task;
use common\components\tasks\services\TaskService;
use common\models\categories\Category;
use common\models\forms\ProductForm;
use common\models\products\Color;
use common\models\products\ProductColor;
use common\models\products\ProductImage;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class AjaxController
 * @package backend\controllers
 */
class AjaxController extends Controller
{

    /**
     * @param $action
     * @return bool
     * @throws NotFoundHttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        return parent::beforeAction($action);
    }

    /**
     * Перевод задачи в завершенные
     *
     * @return bool
     * @throws NotFoundHttpException
     */
    public function actionCompleteTask()
    {
        $task = Task::findOneStrictException(Yii::$app->request->post('id'));

        $task->previousStatus = $task->status;
        $task->status = Task::STATUS_DONE;

        if ($task->save()) {
            return true;
        }

        Yii::$app->response->statusCode = 500;

        return false;
    }

    /**
     * Перевод задачи в завершенные
     *
     * @return array|bool
     * @throws NotFoundHttpException
     */
    public function actionRevertTask()
    {
        $task = Task::findOneStrictException(Yii::$app->request->post('id'));

        $task->status = $task->previousStatus;
        $task->previousStatus = null;

        if ($task->save()) {
            return ['sortable' => $task->status];
        }

        Yii::$app->response->statusCode = 500;

        return false;
    }

    /**
     * Изменения статуса задачи
     *
     * @return bool
     * @throws NotFoundHttpException
     */
    public function actionChangeTaskStatus()
    {
        $task = Task::findOneStrictException(Yii::$app->request->post('id'));
        $task->status = Yii::$app->request->post('status');

        if (!$task->save()) {
            return false;
        }

        return (new TaskService())->setTaskPosition(Yii::$app->request->post('order'));
    }

    /**
     * Сортировка задач
     *
     * @return bool
     */
    public function actionChangeTasksOrder()
    {
        return (new TaskService())->setTaskPosition(Yii::$app->request->post('order'));
    }

    /**
     * Создание новой задачи
     *
     * @return bool|string
     */
    public function actionCreateTask()
    {
        $task = new Task();

        if ($task->load(Yii::$app->request->post()) && (new TaskService())->createTask($task)) {
            return true;
        }

        return $this->renderAjax('/task/_form', ['task' => $task]);
    }

    /**
     * Обновление задачи
     *
     * @return bool|string
     * @throws NotFoundHttpException
     */
    public function actionUpdateTask()
    {
        if (Yii::$app->request->post('id')) {
            $task = Task::findOneStrictException(Yii::$app->request->post('id'));
        } else {
            $task = Task::findOneStrictException(Yii::$app->request->post('Task')['id']);
        }

        if ($task->load(Yii::$app->request->post()) && (new TaskService())->updateTask($task)) {
            return true;
        }

        return $this->renderAjax('/task/_form', ['task' => $task]);
    }

    /**
     * Mark category as a root
     *
     * @return bool
     * @throws NotFoundHttpException
     */
    public function actionMakeRoot()
    {
        return Category::findOneStrictException(Yii::$app->request->post('id'))->makeRoot()->save();
    }

    /**
     * Убираем завершенные задачи
     *
     * @return bool
     */
    public function actionRemoveDoneTasks()
    {
        return (new TaskService())->removeDoneTasks();
    }

    /**
     * @return boolean
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionSaveProductSettings()
    {
        $productForm = new ProductForm(Yii::$app->request->post('product_id'));

        if ($productForm->setSortOrder(Yii::$app->request->post('sort_order'))) {
            Yii::$app->response->statusCode = 200;

            return true;
        }

        throw new BadRequestHttpException();
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionGetColorForm()
    {
        return $this->renderPartial('/product/color_edit_form', [
            'model'  => ProductColor::findOneStrictException(Yii::$app->request->post('id')),
            'colors' => ArrayHelper::map(Color::find()->all(), 'id', 'name'),
        ]);
    }

    /**
     * @return bool
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteImage()
    {
        if (ProductImage::findOneStrictException(Yii::$app->request->post('id'))->delete()) {
            Yii::$app->response->statusCode = 200;
        } else {
            Yii::$app->response->statusCode = 500;
        }

        return true;
    }
}