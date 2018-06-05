<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 04.06.2018
 * Time: 23:54
 */

/**
 * @var \common\models\products\Product $model
 */

?>

<div class="products__item col-3 col-xl-4 col-l-6 col-md-4 col-m-6 col-s-12 is-collapse"><a
            class="product is-fold" href="<?= \yii\helpers\Url::toRoute('/product/'.$model->id) ?>"
            title="<?= $model->name ?>">
        <div class="product__cover"><img class="product__image" alt="<?= $model->name ?>"
                                         src="<?= Yii::getAlias('@productImagePreviewPath/') . $model->title_image ?>">
            <div class="product__overlay"></div>
        </div>
        <div class="product__body">
            <h3 class="product__title"><?= $model->name ?></h3>
            <div class="product__price">
                <div class="product__price-new"><?= round($model->price) ?>₽
                    <?php if ($model->old_price) { ?>
                        <div class="product__price-old"><?= round($model->old_price) ?>₽</div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </a>
</div>
