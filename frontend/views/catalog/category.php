<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 04.06.2018
 * Time: 23:28
 */
use common\models\categories\Category;
use common\models\products\Product;
use yii\helpers\Url;
use yii\widgets\ListView;

/**
 * @var Category $category
 * @var Product $products
 */
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
<div class="section is-wide">
    <div class="products">
        <div class="products__sort">
            <div class="sort">
                <div class="sort__inner"><span class="sort__label">Сортировать:</span>
                    <div class="sort__list">
                        <button class="sort__item is-active is-desc"><span>по цене</span>
                            <svg>
                                <use xlink:href="../img/sprite.svg#arrow-sort"></use>
                            </svg>
                        </button>
                        <button class="sort__item"><span>по скидке</span>
                            <svg>
                                <use xlink:href="../img/sprite.svg#arrow-sort"></use>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="products__list grid">
            <div class="col-md-12">
            <?php echo ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView'     => 'product_item',
                'layout'       => "{items}<div class='col-sm-12'>{pager}</div>",
                'summary'      => '',
            ]); ?>
            </div>
        </div>
<!--        <div class="products__pagination">-->
<!--            <div class="pagination">-->
<!--                <div class="pagination__inner">-->
<!--                    <ul class="pagination__list">-->
<!--                        <li class="pagination__item"><a class="pagination__link" href="#" title="Страница 1">1</a></li>-->
<!--                        <li class="pagination__item is-current"><a class="pagination__link" href="#" title="Страница 2">2</a>-->
<!--                        </li>-->
<!--                        <li class="pagination__item"><a class="pagination__link" href="#" title="Страница 3">3</a></li>-->
<!--                        <li class="pagination__item"><a class="pagination__link" href="#" title="Страница 4">4</a></li>-->
<!--                        <li class="pagination__item"><a class="pagination__link" href="#" title="Страница 5">5</a></li>-->
<!--                        <li class="pagination__item"><a class="pagination__link" href="#" title="Страница 6">6</a></li>-->
<!--                    </ul>-->
<!--                    <span class="pagination__amount">Страница 1 из 21</span>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
        <div class="products__text text">
            <p>Если у вас подрастает маленький ребенок, то, скорее всего, на первом месте стоит покупка детской
                кроватки. На самом деле в течение всего периода взросления ребенку нужна отдельная детская кроватка:
                начиная с рождения и вплоть до подросткового возраста. Ведь дети, как известно, растут не по дням, а по
                часам, поэтому раз в несколько лет кроватку нужно менять в соответствии с возрастом ваших чад.</p>
            <p>Важно понимать, что детская кровать всегда занимает одно из самых главных мест в комнате ребенка. Это не
                просто спальное место, но еще и волшебный мир для вашего ребенка, где он должен чувствовать себя
                комфортно, легко и уютно. Ведь здоровый сон – это залог хорошего настроения и жизнерадостности. В то же
                время детская кровать играет еще и очень важную декоративную роль при оформлении детской комнаты.</p>
            <p>К счастью, сегодня приобрести подходящую детскую кровать для своего ребенка можно на любой вкус: в
                зависимости от возраста ребенка, особенную по своему дизайнерскому исполнению для мальчика или девочки,
                а также различную по конфигурациям. Это может быть как просто кровать, так и изделия со встроенными
                небольшими ящичками, если детская комната ограничена в плане пространства. Кроме того, подразделить все
                кровати можно на следующие разновидности:</p>
        </div>
    </div>
</div>
