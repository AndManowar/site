<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 31.05.18
 * Time: 14:05
 */

namespace backend\controllers;

use common\components\AjaxValidationTrait;
use common\components\rbac\baseController;
use common\models\forms\ColorForm;
use common\models\products\ColorSearch;
use Yii;
use yii\web\UploadedFile;

/**
 * Class ColorController
 * @package backend\controllers
 */
class ColorController extends baseController
{
    use AjaxValidationTrait;

    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ColorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Create color action
     *
     * @return array|string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionCreate()
    {
        $model = new ColorForm();

        if ($model->load(Yii::$app->request->post())) {

            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->create()) {

                Yii::$app->session->setFlash('success', 'Цвет добавлен');

                return $this->redirect(['index']);
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * Update color action
     *
     * @param $id
     * @return array|string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = new ColorForm($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->file = UploadedFile::getInstance($model, 'file');

            if (($errors = $this->modelAjaxValidation($model)) !== null) {
                return $errors;
            }

            if($model->update()) {
                Yii::$app->session->setFlash('success', 'Цвет обновлен');

                return $this->redirect(['index']);
            }
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * Delete color action
     *
     * @param integer $id
     * @return \yii\web\Response
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDelete($id)
    {
        if ((new ColorForm($id))->delete()) {
            Yii::$app->session->setFlash('danger', 'Цвет удален');
        }

        return $this->redirect(['index']);
    }
}