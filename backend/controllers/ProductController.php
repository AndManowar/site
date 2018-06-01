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
     * @throws \yii\db\Exception
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

        return $this->render('step-two', [
            'model'         => $model,
            'colors'        => ArrayHelper::map(Color::find()->all(), 'id', 'name'),
            'productColors' => $product->productsColors,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionUpdate($id)
    {
        $model = new ProductForm($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->title_file = UploadedFile::getInstance($model, 'title_file');
            $model->files = UploadedFile::getInstances($model, 'files');

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

    /**
     * Delete product action
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
        $productForm = new ProductForm($id);

        if($productForm->delete()){
            Yii::$app->session->setFlash('warning', 'Товар удален');
        }else{
            Yii::$app->session->setFlash('danger', 'Невозможно удалить товар');
        }

        return $this->redirect(['index']);
    }

    /**
     * Add color action
     *
     * @param int $id
     * @return \yii\web\Response
     */
    public function actionAddColor($id)
    {
        $color = new ProductColor();

        if ($color->load(Yii::$app->request->post())) {

            if (ProductColor::find()->where(['product_id' => $id])->andWhere(['color_id' => $color->color_id])->exists()) {
                Yii::$app->session->setFlash('danger', 'Этот цвет уже добавлен');

                return $this->redirect(['step-two', 'id' => $id]);
            }

            if ($color->save()) {
                Yii::$app->session->setFlash('success', 'Цвет добавлен');
            } else {
                Yii::$app->session->setFlash('danger', 'Ошибка при добавлении цвета');
            }
        }

        return $this->redirect(['step-two', 'id' => $id]);
    }

    /**
     * Add color action
     *
     * @param int $id
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionEditColor($id)
    {
        $color = ProductColor::findOneStrictException($id);

        if ($color->load(Yii::$app->request->post())) {

            if ($color->save()) {
                Yii::$app->session->setFlash('success', 'Цвет изменен');
            } else {
                Yii::$app->session->setFlash('danger', 'Ошибка при добавлении цвета');
            }
        }

        return $this->redirect(['step-two', 'id' => $id]);
    }

    /**
     * Delete color action
     *
     * @param int $id
     * @return \yii\web\Response
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDeleteColor($id)
    {
        $color = ProductColor::findOneStrictException($id);

        if ($color->delete()) {
            Yii::$app->session->setFlash('warning', 'Цвет удален');
        } else {
            Yii::$app->session->setFlash('danger', 'Невозможно удалить цвет');
        }

        return $this->redirect(['step-two', 'id' => $color->product_id]);
    }
}