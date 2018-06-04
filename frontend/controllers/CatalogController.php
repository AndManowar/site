<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 04.06.2018
 * Time: 23:28
 */

namespace frontend\controllers;

use common\models\categories\Category;
use common\models\products\ProductSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class CatalogController
 * @package frontend\controllers
 */
class CatalogController extends Controller
{
    /**
     * @param string $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionCategory($alias)
    {
        $category = Category::find()->where(['alias' => $alias])->one();

        $searchModel = new ProductSearch(['category_id' => $category->id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        if (!$category) {
            throw new NotFoundHttpException();
        }

        return $this->render('category', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'category'     => $category,
        ]);
    }


}