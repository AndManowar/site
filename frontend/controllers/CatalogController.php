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
use yii\data\Sort;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class CatalogController
 * @package frontend\controllers
 */
class CatalogController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('catalog', ['categories' => Category::getChildren(1)]);
    }

    /**
     * @param string $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionCategory($alias)
    {
        $category = Category::find()->where(['alias' => $alias])->one();

        $searchModel = new ProductSearch(['category_id' => $category->id, 'is_admin' => false]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $sort = new Sort([
            'attributes' => [
                'price' => [
                    'asc'   => ['price' => SORT_ASC],
                    'desc'  => ['price' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'по цене',
                ],
            ],
        ]);

        if (!$category) {
            throw new NotFoundHttpException();
        }

        Yii::$app->view->registerMetaTag(['name' => 'title', 'content' => $category->title]);
        Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => $category->keywords]);
        Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => $category->description]);

        return $this->render('category', [
            'sort'         => $sort,
            'dataProvider' => $dataProvider,
            'category'     => $category,
        ]);
    }
}