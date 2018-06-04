<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 04.06.18
 * Time: 12:21
 */

use common\helpers\CategoryHelper;

/**
 * @var string $directoryAsset
 * @var array $categories
 */

$categories = CategoryHelper::getFromCache();
?>

<div class="page__sidebar">
    <div class="sidebar">
        <div class="sidebar__menu">
            <div class="menu js-menu">
                <ul class="menu__list">

                    <?php
                    /** @var \common\models\categories\Category $category */
                    foreach ($categories as $category) { ?>

                        <?php if (empty($category['children'])) { ?>
                            <li class="menu__item"><a class="menu__link js-menu-link" href="category.html"
                                                      title="<?= $category['category']->name ?>"><?= $category['category']->name ?></a>
                            </li>
                        <?php } else { ?>
                            <li class="menu__item has-child"><a class="menu__link js-menu-link" href=""
                                                                title="<?= $category['category']->name ?>"><?= $category['category']->name ?></a>
                                <?php foreach ($category['children'] as $child) { ?>

                                <?php } ?>
                            </li>
                        <?php } ?>
                    <?php } ?>

                </ul>
                <ul class="menu__list">

                    <?php
                    /** @var \common\models\categories\Category $category */
                    foreach ($categories as $category) { ?>

                        <?php if (empty($category['children'])) { ?>
                            <li class="menu__item"><a class="menu__link js-menu-link" href="category.html"
                                                      title="<?= $category->name ?>"><?= $category->name ?></a></li>
                        <?php } else { ?>
                            <li class="menu__item has-child"><a class="menu__link js-menu-link" href="" title="<?= $category->name ?>"><?= $category->name ?></a>
                                <ul class="menu__list is-level2 js-menu-list">
                                    <li class="menu__item is-level2"><a class="menu__link is-level2 js-menu-link"
                                                                        href="category.html" title="Кухонная мебель">Кухонная
                                            мебель</a>
                                    </li>
                                    <li class="menu__item is-level2 has-child"><a class="menu__link is-level2 js-menu-link"
                                                                                  href="category.html" title="Стенки">Стенки</a>
                                        <ul class="menu__list is-level3 js-menu-list">
                                            <li class="menu__item is-level3"><a class="menu__link is-level3"
                                                                                href="category.html" title="Стеллажи полки">Стеллажи
                                                    полки</a></li>
                                            <li class="menu__item is-level3"><a class="menu__link is-level3"
                                                                                href="category.html" title="Диваны">Диваны</a>
                                            </li>
                                            <li class="menu__item is-level3"><a class="menu__link is-level3"
                                                                                href="category.html" title="Товары для сна">Товары
                                                    для сна</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                    <?php } ?>

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
