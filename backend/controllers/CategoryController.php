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

    private $modelClass = Category::class;

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'moveNode'   => [
                'class'      => 'common\components\nested\src\actions\MoveNodeAction',
                'modelClass' => $this->modelClass,
            ],
            'deleteNode' => [
                'class'      => 'common\components\nested\src\actions\DeleteNodeAction',
                'modelClass' => $this->modelClass,
            ],
            'updateNode' => [
                'class'      => 'common\components\nested\src\actions\UpdateNodeAction',
                'modelClass' => $this->modelClass,
            ],
            'createNode' => [
                'class'      => 'common\components\nested\src\actions\CreateNodeAction',
                'modelClass' => $this->modelClass,
            ],
        ];
    }

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
     * @throws \yii\web\BadRequestHttpException
     * @throws \yii\web\NotFoundHttpException
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
     * @throws \yii\web\NotFoundHttpException
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

    /**
     * Delete category with children
     *
     * @param integer $id
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $model = new CategoryForm($id);

        if ($model->delete()) {
            Yii::$app->session->setFlash('danger', 'Категория удалена');
        }

        return $this->redirect(['index']);
    }

    /**
     * @return string
     */
    public function actionConfigurateTree()
    {
        return $this->render('tree');
    }
}