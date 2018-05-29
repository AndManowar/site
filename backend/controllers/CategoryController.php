<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 29.05.2018
 * Time: 17:58
 */

namespace backend\controllers;

use common\components\AjaxValidationTrait;
use common\components\rbac\baseController;
use common\models\categories\Category;
use common\models\categories\CategorySearch;
use common\models\forms\CategoryForm;
use Yii;

/**
 * Class CategoryController
 * @package backend\controllers
 */
class CategoryController extends baseController
{
    use AjaxValidationTrait;

    /**
     * Categories list
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return array|null|string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new CategoryForm();

        if ($model->load(Yii::$app->request->post())) {

            if (($errors = $this->modelAjaxValidation($model)) !== null) {
                return $errors;
            }

            if ($model->create()) {
                Yii::$app->session->setFlash('success', 'Категория создана');

                return $this->redirect(['/category']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'roots' => Category::getRootList(),
        ]);
    }

    /**
     * @param integer $id
     * @return array|null|string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = new CategoryForm($id);

        if ($model->load(Yii::$app->request->post())) {

            if (($errors = $this->modelAjaxValidation($model)) !== null) {
                return $errors;
            }

            if ($model->update()) {
                Yii::$app->session->setFlash('success', 'Категория обновлена');

                return $this->redirect(['/category']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'roots' => Category::getRootList($id),
        ]);
    }

    public function actionDelete($id)
    {

    }
}