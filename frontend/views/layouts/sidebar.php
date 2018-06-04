<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 04.06.18
 * Time: 12:21
 */

use common\helpers\CategoryHelper;
use common\models\categories\Category;
use yii\helpers\Url;

/**
 * @var string $directoryAsset
 * @var array $categories
 * @var $this \yii\web\View
 */

$categories = CategoryHelper::getFromCache();
?>

<div class="page__sidebar">
    <div class="sidebar">
        <div class="sidebar__menu">
            <div class="menu js-menu">
                <ul class="menu__list">
                    <?php
                    /** @var Category $category */
                    if ($categories) {
                        foreach ($categories as $category) {
                            if (!isset($category['root']['children'])) {?>
                                <li class="menu__item"><a class="menu__link js-menu-link" href="<?= Url::toRoute(['catalog/category', 'alias' => $category['root']['alias']]) ?>"
                                                          title="<?= $category['root']['name'] ?>"><?= $category['root']['name'] ?></a>
                                </li>
                            <?php } else { ?>
                                <li class="menu__item has-child"><a class="menu__link js-menu-link" href="<?= Url::toRoute(['catalog/category', 'alias' => $category['root']['alias']]) ?>"
                                                                    title="<?= $category['root']['name'] ?>"><?= $category['root']['name'] ?></a>
                                    <ul class="menu__list is-level2 js-menu-list">
                                        <?php
                                        /** @var Category $childCategory */
                                        foreach ($category['root']['children'] as $childCategory) { ?>
                                            <?php if (!isset($childCategory['sub'])) { ?>
                                                <li class="menu__item is-level2"><a
                                                            class="menu__link is-level2 js-menu-link"
                                                            href="<?= Url::toRoute(['catalog/category', 'alias' => $childCategory['alias']]) ?>"
                                                            title="<?= $childCategory['name'] ?>"><?= $childCategory['name'] ?></a>
                                                </li>
                                            <?php } else { ?>
                                                <li class="menu__item is-level2 has-child"><a
                                                            class="menu__link is-level2 js-menu-link"
                                                            href="<?= Url::toRoute(['catalog/category', 'alias' => $childCategory['alias']]) ?>"
                                                            title="<?= $childCategory['name'] ?>"><?= $childCategory['name'] ?></a>
                                                    <ul class="menu__list is-level3 js-menu-list">
                                                        <?php foreach ($childCategory['sub'] as $subCategory) { ?>
                                                            <li class="menu__item is-level3"><a
                                                                        class="menu__link is-level3"
                                                                        href="<?= Url::toRoute(['catalog/category', 'alias' => $subCategory['alias']]) ?>"
                                                                        title="<?= $subCategory['name'] ?>"><?= $subCategory['name'] ?></a>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                            <?php }
                                        } ?>
                                    </ul>
                                </li>
                            <?php }
                        }
                    } ?>
                </ul>
            </div>
        </div>
        <div class="sidebar__order-button"><a class="order-button" href="order.html"
                                              title="Заказать мебель по своим размерам">
                <svg class="order-button__icon">
                    <use xlink:href="<?= $directoryAsset ?>/img/sprite.svg#sizebox"></use>
                </svg>
                <div class="order-button__text"><i>Заказать</i> мебель по своим размерам</div>
            </a></div>
    </div>
</div>
