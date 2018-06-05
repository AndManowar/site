<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 05.06.18
 * Time: 8:31
 */

namespace frontend\controllers;

use common\models\products\Product;
use Yii;
use yii\web\Controller;

/**
 * Class ProductController
 * @package frontend\controllers
 */
class ProductController extends Controller
{

    /**
     * @param integer $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDetail($id)
    {
        $product = Product::findOneStrictException($id);

        Yii::$app->view->registerMetaTag(['name' => 'title', 'content' => $product->title]);
        Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => $product->keywords]);
        Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => $product->description]);

        return $this->render('detail', ['product' => $product]);
    }
}