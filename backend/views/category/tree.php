<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 30.05.18
 * Time: 15:55
 */

$this->title = 'Настройка категорий';
\backend\assets\MainpageAsset::register($this);
?>



<section id="widget-grid" class="">
    <div class="row">
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                    <h2><?= $this->title ?></h2>
                </header>
                <div>
                    <div class="widget-body no-padding">
                        <h2 class="text-center">Настройка вложенности категорий</h2>
                        <div class="col-md-8 col-md-offset-2">
                        <?= \common\components\nested\src\widgets\nestable\Nestable::widget([
                            'modelClass' => \common\models\categories\Category::class,
                        ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>
