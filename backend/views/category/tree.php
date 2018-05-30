<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 30.05.18
 * Time: 15:55
 */


\backend\assets\MainpageAsset::register($this);
?>

<section id="widget-grid" class="">
    <div class="row">

        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?= \common\components\nested\src\widgets\nestable\Nestable::widget([
                'modelClass' => \common\models\categories\Category::class,
            ]) ?>
        </article>

    </div>
</section>