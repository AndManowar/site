<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 31.01.18
 * Time: 11:06
 */

namespace backend\controllers;

use common\components\AjaxValidationTrait;
use common\components\rbac\baseController;
use common\components\settings\helpers\FormFieldsHelper;
use common\components\settings\models\Settings;
use common\components\settings\models\SettingsSearch;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Class SettingsController
 * @package backend\controllers
 */
class SettingsController extends baseController
{
    use AjaxValidationTrait;

    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SettingsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return array|string|Response
     */
    public function actionCreate()
    {
        $model = new Settings();

        if ($model->load(Yii::$app->request->post())) {

            if (($errors = $this->modelAjaxValidation($model)) !== null) {
                return $errors;
            }

            if ($model->save()) {

                Yii::$app->session->setFlash('success', 'Настройка сохранена');

                return $this->redirect(['index']);
            }
        }

        return $this->render('create', ['model' => $model]);

    }

    /**
     * @param integer $id
     * @return array|string|Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {

        $model = Settings::findOneStrictException($id);

        if ($model->load(Yii::$app->request->post())) {

            if (($errors = $this->modelAjaxValidation($model)) !== null) {
                return $errors;
            }

            if ($model->save()) {

                Yii::$app->session->setFlash('success', 'Настройка сохранена');

                return $this->redirect(['index']);
            }
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * @param integer $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        if (Settings::findOneStrictException($id)->delete()) {

            Yii::$app->session->setFlash('danger', 'Настройка удалена');
        }

        return $this->redirect(['index']);
    }

    /**
     * @return string
     */
    public function actionGetField()
    {
        $field = FormFieldsHelper::getFormField(
            new ActiveForm(['id' => 'settings-form', 'enableAjaxValidation' => false, 'enableClientValidation' => false]),
            new Settings(),
            'value',
            Yii::$app->request->post('type')
        );

        return $this->renderAjax('dynamicField', ['field' => $field]);
    }

}