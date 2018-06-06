<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 04.06.18
 * Time: 12:16
 */

use yii\helpers\Url;

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@webroot/style');
?>
<div class="section is-collapse is-clear">
    <div class="grid">
        <div class="col-6 col-l-12 col-md-6 col-m-12 is-collapse"><a class="cat is-card" href="catalog.html">
                <div class="cat__object is-item1"></div>
                <div class="cat__object is-item2"></div>
                <div class="cat__object is-item3"></div>
                <div class="cat__object is-item4"></div>
                <div class="cat__content"><span class="cat__label">01</span>
                    <h2 class="cat__title"> <i>Готовая<br>корпусная мебель</i></h2>
                    <div class="cat__arrow"></div>
                </div>
                <div class="cat__footer">
                    <div class="cat__offer">Готовые кухни <i>от 29 500₽</i></div>
                    <div class="cat__offer">Шкафы-купе <i>от 9 500₽</i></div>
                    <div class="cat__offer">Кровати <i>от 7 300₽</i></div>
                    <div class="cat__dots"><span></span><span></span><span></span></div>
                </div></a>
        </div>
        <div class="col-6 col-l-12 col-md-6 col-m-12 is-collapse"><a class="cat is-card is-alt" href="category.html">
                <div class="cat__cover" style="background-image: url(<?= $directoryAsset ?>/img/cat-cover.jpg);"></div>
                <div class="cat__content"><span class="cat__label">02</span>
                    <h2 class="cat__title"> <i>Мебель на заказ</i></h2>
                    <div class="cat__arrow"></div>
                </div></a>
        </div>
    </div>
</div>
<div class="is-md-hide">
    <div class="features grid">
        <div class="features__item col-4 col-md-6 col-s-12 is-collapse">
            <div class="feature has-image" style="background-image: url(<?= $directoryAsset ?>/img/feature-1.jpg)">
                <div class="feature__title">Удовольствие от использования</div>
                <div class="feature__caption">изо дня в день</div>
            </div>
        </div>
        <div class="features__item col-4 col-md-6 col-s-12 is-collapse is-md-hide">
            <div class="feature is-accent">
                <div class="feature__title">Доступная цена</div>
                <div class="feature__caption">за высокое качество</div>
            </div>
        </div>
        <div class="features__item col-4 col-md-6 col-s-12 is-collapse">
            <div class="feature has-image" style="background-image: url(<?= $directoryAsset ?>/img/feature-2.jpg)">
                <div class="feature__title">Безупречный дизайн</div>
                <div class="feature__caption">и ничего лишнего</div>
            </div>
        </div>
    </div>
</div>
<section class="section is-clear">
    <header class="section__header is-center">
        <h1 class="section__title">Корпусная мебель в Смоленске</h1>
    </header>
    <div class="section__body">
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
</section>
<div class="portfolio is-roll">
    <div class="portfolio__list grid">
        <div class="portfolio__item col-3 col-xl-4 col-s-12 is-collapse"><a class="portfolio-item" href="portfolio-item.html" title="Кухня на Королёвке">
                <div class="portfolio-item__cover" style="background-image: url(<?= $directoryAsset ?>/img/portfolio-1.jpg)"></div>
                <div class="portfolio-item__content">
                    <h4 class="portfolio-item__title">Кухня на Королёвке</h4>
                </div><span class="portfolio-item__tag">Кухни</span></a>
        </div>
        <div class="portfolio__item col-3 col-xl-4 col-s-12 is-collapse"><a class="portfolio-item is-yellow" href="portfolio-item.html" title="Кухня на 8 Марта («Никольская слобода»)">
                <div class="portfolio-item__cover" style="background-image: url(<?= $directoryAsset ?>/img/portfolio-2.jpg)"></div>
                <div class="portfolio-item__content">
                    <h4 class="portfolio-item__title">Кухня на 8 Марта («Никольская слобода»)</h4>
                </div><span class="portfolio-item__tag">Кухни</span></a>
        </div>
        <div class="portfolio__item col-3 col-xl-4 col-s-12 is-collapse"><a class="portfolio-item" href="portfolio-item.html" title="Экологичная кухня без фасадов">
                <div class="portfolio-item__cover" style="background-image: url(<?= $directoryAsset ?>/img/portfolio-3.jpg)"></div>
                <div class="portfolio-item__content">
                    <h4 class="portfolio-item__title">Экологичная кухня без фасадов</h4>
                </div><span class="portfolio-item__tag">Кухни</span></a>
        </div>
        <div class="portfolio__item col-3 col-xl-4 col-s-12 is-collapse"><a class="portfolio-item is-blue" href="portfolio-item.html" title="Кухня на 8 Марта («Никольская слобода»)">
                <div class="portfolio-item__cover" style="background-image: url(<?= $directoryAsset ?>/img/portfolio-4.jpg)"></div>
                <div class="portfolio-item__content">
                    <h4 class="portfolio-item__title">Кухня на 8 Марта («Никольская слобода»)</h4>
                </div><span class="portfolio-item__tag">Кухни</span></a>
        </div>
    </div>
</div>
<div class="section is-collapse is-clear">
    <div class="grid is-v-center">
        <div class="col-6 col-l-12 is-collapse is-stretch">
            <div class="map js-map" data-init="{ &quot;center&quot;: [54.823752, 32.103379], &quot;zoom&quot;: 12, &quot;markers&quot;: [{&quot;title&quot;: &quot;Большая Советская 14&quot;,&quot;address&quot;: &quot;Смоленск, Большая Советская 14&quot;, &quot;time&quot;: &quot;ПН-ПТ&lt;br&gt;10-00 — 18-00&quot;, &quot;phones&quot;: [&quot;+7 4812 63-03-27&quot;], &quot;coords&quot;: [54.783752, 32.053379], &quot;image&quot;: &quot;<?= $directoryAsset ?>/img/marker2.svg&quot; }, { &quot;title&quot;: &quot;Смоленск, Седова, 35&quot;, &quot;address&quot;: &quot;Смоленск, Седова, 35&quot;, &quot;time&quot;: &quot;ПН-ПТ&lt;br&gt;10-00 — 18-00&quot;, &quot;phones&quot;: [&quot;+7 4812 63-03-27&quot;, &quot;+7 4812 63-03-27&quot;], &quot;coords&quot;: [54.817868, 32.116491], &quot;image&quot;: &quot;<?= $directoryAsset ?>/img/marker1.svg&quot;, &quot;isOpen&quot;: true }]}">
                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGp6pOLSkRpcCD_AGJ4c9dlRZaHcuT9gs"></script>
                <div class="map__container js-map-container"></div>
            </div>
        </div>
        <div class="col-6 col-l-12 is-collapse">
            <div class="section is-text is-clear">
                <div class="text">
                    <p>В нашем интернет-магазине мы предлагаем исключительно качественные и долговечные предметы мебели. В производстве используются материалы, имеющие идеальное соотношение цены и качества, обладающие хорошей прочностью и влагоустойчивостью, прекрасно сочетающиеся с пластиковыми, стеклянными и металлическими элементами.</p>
                    <p>
                        Детскую мебель как в классических, так и красочных расцветках, которые помогают создать яркую и позитивную атмосферу;<br>
                        детские кровати – стандартные, в оригинальном дизайне, с выдвижными ящиками;<br>
                        комоды, трюмо, трельяжи – компактные системы для хранения домашних принадлежностей станут прекрасным дополнением к основной мебели;<br>
                        компьютерные столы – для дома, офиса, учебных классов;<br>
                        письменные столы – квадратные, прямоугольные, угловые;<br>
                        шкафы купе – угловые, прямые, с зеркалами и без;<br>
                        журнальные столики – деревянные, стеклянные, комбинированные, различных форм и размеров;<br>
                        кровати – односпальные, двуспальные, полуторные;<br>
                        прихожие — позволяют компактно разместить большое количество верхней одежды и обуви;<br>
                        кухни на заказ в Смоленске – могут содержать различное количество полок и шкафчиков, иметь специальное место под мойку и встроенную технику.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
