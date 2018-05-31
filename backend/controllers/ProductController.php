<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 31.05.18
 * Time: 13:05
 */

namespace backend\controllers;

use common\components\rbac\baseController;
use common\models\categories\Category;
use common\models\forms\ProductForm;
use common\models\products\Color;
use common\models\products\Product;
use common\models\products\ProductColor;
use common\models\products\ProductSearch;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * Class ProductController
 * @package backend\controllers
 */
class ProductController extends baseController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionCreate()
    {
        $model = new ProductForm();

        if ($model->load(Yii::$app->request->post())) {

            $model->title_file = UploadedFile::getInstance($model, 'title_file');
            $model->files = UploadedFile::getInstances($model, 'files');

            if ($model->create()) {
                Yii::$app->session->setFlash('success', 'Товар создан');

                return $this->redirect(['product/step-two']);
            }
        }

        return $this->render('create', [
            'model'      => $model,
            'categories' => ArrayHelper::map(Category::find()->all(), 'id', 'name'),
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionStepTwo($id)
    {
        $model = new ProductForm($id);
        /** @var Product $product */
        $product = $model->product;

        if ($model->load(Yii::$app->request->post())) {


        }

        return $this->render('step-two', [
            'model'  => $model,
            'data'   => $product->productsColors ? $product->productsColors : [new ProductColor()],
            'colors' => ArrayHelper::map(Color::find()->all(), 'id', 'name'),
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = new ProductForm($id);

        if ($model->load(Yii::$app->request->post())) {

            if ($model->update()) {
                Yii::$app->session->setFlash('success', 'Товар обновлен');

                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model'      => $model,
            'categories' => ArrayHelper::map(Category::find()->all(), 'id', 'name'),
        ]);
    }
}