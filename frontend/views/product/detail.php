<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 05.06.18
 * Time: 8:37
 */

use yii\helpers\Url;

/**
 * @var \common\models\products\Product $product
 */
$parentCategory = \common\models\categories\Category::find()->where(['id' => $product->category->parent_id])->one();
?>

<div class="headline">
    <div class="container">
        <div class="headline__breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb__item"><a class="breadcrumb__link" href="<?= Url::toRoute(['site/index']) ?>"
                                                title="Главная">Главная</a>
                </li>
                <li class="breadcrumb__item"><a class="breadcrumb__link"
                                                href="<?= Url::toRoute(['catalog/category', 'alias' => $parentCategory->alias]) ?>"
                                                title="<?= $parentCategory->name ?>"><?= $parentCategory->name ?></a>
                </li>
                <li class="breadcrumb__item"><a class="breadcrumb__link"
                                                href="<?= Url::toRoute(['catalog/category', 'alias' => $product->category->alias]) ?>"
                                                title="<?= $product->category->name ?>"><?= $product->category->name ?></a>
                </li>
            </ul>
        </div>
        <h1 class="headline__title"><?= $product->caption ? $product->caption : $product->name ?></h1>
    </div>
</div>
<div class="section is-wide">
    <div class="product-card">
        <div class="product-card__inner grid">
            <div class="product-card__slider col-6 col-xl-4 col-l-12 is-collapse">
                <div class="product-slider js-product-slider">
                    <div class="product-slider__inner">
                        <button class="product-slider__arrow is-prev js-product-slider-prev"></button>
                        <button class="product-slider__arrow is-next js-product-slider-next"></button>
                        <div class="product-slider__container js-product-slider-container">
                            <div class="product-slider__slide"
                                 style="background-image: url(<?= Yii::getAlias('@productImagePreviewPath/') . $product->title_image ?>)"></div>
                            <?php foreach ($product->productsImages as $productImage) { ?>
                                <div class="product-slider__slide"
                                     style="background-image: url(<?= Yii::getAlias('@productImagePreviewPath/') . $productImage->image ?>)"></div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-card__order col-6 col-xl-8 col-l-12 is-collapse">
                <form class="product-order js-product-order" @submit.prevent="handler"
                      :class="{ &quot;is-added&quot;: inCart, &quot;is-visible&quot;: isReady }" data-id="1"
                      data-amount="1">
                    <div class="product-order__section">
                        <div class="product-order__group grid is-v-center">
                            <div class="product-order__price">
                                <div class="product-order__price-label">Цена</div>
                                <div class="product-order__price-value"><?= $product->price ?> ₽</div>
                            </div>
                            <div class="product-order__counter">
                                <counter v-if="!inCart" :update="updateAmount" :product-id="id"
                                         :current-amount="amount" :min="0" :max="10"></counter>
                            </div>
                            <a class="product-order__button button is-link" href="/cart.html" title=""
                               v-if="inCart">В корзине</a>
                            <button class="product-order__button button" :disabled="amount === 0"
                                    v-if="!inCart">В корзину
                            </button>
                        </div>
                    </div>
                    <?php if ($product->productsColors) { ?>
                        <div class="product-order__section">
                            <h3 class="product-order__title">Цвета</h3>
                            <div class="product-order__group is-color" style="opacity: 1">
                                <div class="product-color">
                                    <?php
                                    /** @var \common\models\products\Color $color */
                                    foreach ($product->productsColors as $productColor) { ?>
                                        <label class="product-color__item">
                                            <input class="product-color__field" type="radio" name="color"
                                                   :disabled="inCart" checked value="1" v-model="color">
                                            <div class="product-color__cover"><img class="product-color__image"
                                                                                   src="<?= Yii::getAlias('@colorImagePreviewPath/') . $productColor->color->image ?>"
                                                                                   alt></div>
                                            <div class="product-color__tooltip" data-title="<?= $productColor->color->image ?>"></div>
                                        </label>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="product-order__section">
                        <h3 class="product-order__title">Размер</h3>
                        <div class="product-order__group">
                            <div class="product-size">
                                <div class="product-size__item is-width"><?= $product->width ?>мм</div>
                                <div class="product-size__item is-height"><?= $product->height ?>мм</div>
                                <div class="product-size__item is-depth"><?= $product->thickness ?>мм</div>
                            </div>
                        </div>
                    </div>
                    <div class="product-order__section">
                        <h3 class="product-order__title">Описание</h3>
                        <div class="product-order__group text">
                            <p><?= $product->description_text ?></p>
                        </div>
                    </div>
                    <div class="product-order__section">
                        <h3 class="product-order__title">В составе комплекта</h3>
                        <div class="product-order__group">
                            <div class="product-set set"><a class="product-set__header" href="set.html"
                                                            title="Модульная стенка «Соната»">
                                    <div class="product-set__cover"><img class="product-set__image"
                                                                         src="<?= Yii::getAlias('@assetsImages/') ?>img/set-1.jpg" alt></div>
                                    <h3 class="product-set__title">Модульная стенка «Соната»</h3></a>
                                <ul class="product-set__list set__list is-numeric">
                                    <li class="set__item">
                                        <div class="set__item-title">Центр под TV (2100х1800х500)</div>
                                        <div class="set__item-price">9 800 ₽</div>
                                    </li>
                                    <li class="set__item is-current">
                                        <div class="set__item-title">Шкаф 3х створчатый №2 ЛДСП</div>
                                        <div class="set__item-price">26 000 ₽</div>
                                    </li>
                                    <li class="set__item">
                                        <div class="set__item-title">Шкаф для одежды (2100х800х450)</div>
                                        <div class="set__item-price">3 950 ₽</div>
                                    </li>
                                    <li class="set__item">
                                        <div class="set__item-title">Комод (870х840х440)</div>
                                        <div class="set__item-price">3 200 ₽</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="product-card__features">
                    <div class="product-card__feature">
                        <div class="product-feature"><img class="product-feature__image"
                                                          src="<?= Yii::getAlias('@assetsImages/') ?>img/product-feature-1.svg" alt>
                            <h4 class="product-feature__title">Рассрочка до 6-ти месяцев</h4>
                            <p class="product-feature__descr">Компания «Тея» предлагает корпусную мебель,
                                которая, благодаря своей функциональности</p>
                        </div>
                    </div>
                    <div class="product-card__feature">
                        <div class="product-feature"><img class="product-feature__image"
                                                          src="<?= Yii::getAlias('@assetsImages/') ?>img/product-feature-2.svg" alt>
                            <h4 class="product-feature__title">Доставка + занос + сборка</h4>
                            <p class="product-feature__descr">Компания «Тея» предлагает функциональности,
                                эстетичному внешнему виду и практичности</p>
                        </div>
                    </div>
                </div>
                <div class="product-card__share">
                    <div class="share js-share">
                        <div class="share__inner">
                            <div class="share__caption">Поделиться в соцстетях</div>
                            <div class="share__list">
                                <button class="share__item js-share-vk">
                                    <svg class="share__icon">
                                        <use xlink:href="<?= Yii::getAlias('@assetsImages/') ?>img/sprite.svg#share-vk"></use>
                                    </svg>
                                </button>
                                <button class="share__item js-share-ok">
                                    <svg class="share__icon">
                                        <use xlink:href="<?= Yii::getAlias('@assetsImages/') ?>img/sprite.svg#share-ok"></use>
                                    </svg>
                                </button>
                                <button class="share__item js-share-tw">
                                    <svg class="share__icon">
                                        <use xlink:href="<?= Yii::getAlias('@assetsImages/') ?>img/sprite.svg#share-tw"></use>
                                    </svg>
                                </button>
                                <button class="share__item js-share-fb">
                                    <svg class="share__icon">
                                        <use xlink:href="<?= Yii::getAlias('@assetsImages/') ?>img/sprite.svg#share-fb"></use>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
