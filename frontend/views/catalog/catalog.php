<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 05.06.18
 * Time: 10:18
 */

use yii\helpers\Url;

/**
 * @var \common\models\categories\Category[] $categories
 */

?>
<div class="headline">
    <div class="container">
        <div class="headline__breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb__item"><a class="breadcrumb__link" href="<?= Url::toRoute(['site/index']) ?>"
                                                title="Главная">Главная</a>
                </li>
                <li class="breadcrumb__item">Корпусная мебель</li>
            </ul>
        </div>
        <h1 class="headline__title">Корпусная мебель в Смоленске</h1>
    </div>
</div>
<div class="section is-catalog">
    <div class="cats">
        <div class="cats__list">
            <?php foreach ($categories as $id => $category) { ?>
                <div class="cats__item"><a class="cat"
                                           href="<?= Url::toRoute(['catalog/category', 'alias' => $category->alias]) ?>">
                        <div class="cat__cover">
                            <svg class="cat__image" data-id="1">
                                <use xlink:href="<?= Yii::getAlias('@assetsImages/') ?>img/sprite.svg#cat-<?= $id + 1 ?>"></use>
                            </svg>
                        </div>
                        <h3 class="cat__title"><?= $category->name ?></h3>
                        <div class="cat__price">от 12 500 ₽</div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>