<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 04.06.2018
 * Time: 23:28
 */

use common\models\categories\Category;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

/**
 * @var Category $category
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \yii\data\Sort $sort
 */

$sortClass = 'desc';
if (Yii::$app->request->get('sort')) {
    $sortClass = Yii::$app->request->get('sort') == 'price' ? 'desc' : 'asc';
}

?>
<div class="headline">
    <div class="container">
        <div class="headline__breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb__item"><a class="breadcrumb__link" href="<?= Url::toRoute(['site/index']) ?>"
                                                title="Главная">Главная</a></li>
                <?php if ($category->parent_id) {
                    $parent = Category::findOneStrictException($category->parent_id);
                    ?>
                    <li class="breadcrumb__item"><a class="breadcrumb__link"
                                                    href="<?= Url::toRoute(['catalog/category', 'alias' => $parent->alias]) ?>"
                                                    title="Корпусная мебель"><?= $parent->name ?></a></li>
                <?php } ?>
                <li class="breadcrumb__item"><?= $category->name ?></li>
            </ul>
        </div>
        <h1 class="headline__title"><?= $category->caption ? $category->caption : $category->name ?></h1>
    </div>
</div>
<?php Pjax::begin() ?>
<div class="section is-wide">
    <div class="products">
        <div class="products__sort">
            <div class="sort">
                <div class="sort__inner"><span class="sort__label">Сортировать:</span>
                    <div class="sort__list">
                        <button class="sort__item is-active is-<?= $sortClass ?>">
                            <span><?= $sort->link('price') ?></span>
                            <svg>
                                <use xlink:href="<?= Yii::getAlias('@assetsImages/') ?>img/sprite.svg#arrow-sort"></use>
                            </svg>
                        </button>
                        <button class="sort__item"><span>по скидке</span>
                            <svg>
                                <use xlink:href="<?= Yii::getAlias('@assetsImages/') ?>img/sprite.svg#arrow-sort"></use>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="products__list grid">
            <?php foreach ($dataProvider->getModels() as $product) {
                echo $this->render('product_item', ['model' => $product]);
            } ?>
        </div>
        <div class="products__pagination">
            <div class="pagination">
                <div class="pagination__inner">
                    <?php echo LinkPager::widget([
                        'pagination'           => $dataProvider->getPagination(),
                        'firstPageLabel'       => false,
                        'lastPageLabel'        => false,
                        'prevPageLabel'        => false,
                        'nextPageLabel'        => false,
                        'options'              => [
                            'tag'   => 'ul',
                            'class' => 'pagination__list'
                        ],
                        'linkContainerOptions' => ['class' => 'pagination__item'],
                        'linkOptions'          => ['class' => 'pagination__link'],
                        'activePageCssClass'   => 'is-current',
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="products__text text">
            <?= $category->description_text ?>
        </div>
    </div>
</div>
<?php Pjax::end() ?>
