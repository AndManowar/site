<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 04.06.18
 * Time: 12:17
 */

/**
 * @var string $directoryAsset
 */
?>
<header class="page__header">
    <div class="header">
        <div class="header__logo">
            <div class="logo">
                <div class="logo__label">Тея <i>Мебель</i></div>
            </div>
        </div>
        <div class="header__nav">
            <nav class="nav js-nav">
                <div class="nav__overlay js-nav-overlay"></div>
                <button class="nav__toggle js-nav-toggle">
                    <svg>
                        <use xlink:href="<?= $directoryAsset ?>/img/sprite.svg#menu"> </use>
                    </svg><span>меню</span>
                </button>
                <ul class="nav__list js-nav-list">
                    <li class="nav__item"><a class="nav__link" href="catalog.html" title="Каталог">Каталог</a></li>
                    <li class="nav__item"><a class="nav__link" href="sale.html" title="Распродажа">Распродажа</a></li>
                    <li class="nav__item"><a class="nav__link" href="single.html" title="Акции">Акции</a></li>
                    <li class="nav__item"><a class="nav__link" href="single.html" title="О компании">О компании</a></li>
                    <li class="nav__item"><a class="nav__link" href="portfolio.html" title="Наши работы">Наши работы</a></li>
                    <li class="nav__item"><a class="nav__link" href="contacts.html" title="Контакты">Контакты</a></li>
                </ul>
            </nav>
        </div>
        <div class="header__group">
            <div class="header__contacts">
                <div class="header__contact">
                    <div class="contact">
                        <div class="contact__address">Большая Советская, 14</div>
                        <div class="contact__phone">+7 4812 63-03-27</div>
                    </div>
                </div>
                <div class="header__contact">
                    <div class="contact">
                        <div class="contact__address">Седова, 35</div>
                        <div class="contact__phone">+7 4812 63-03-27</div>
                    </div>
                </div>
            </div>
            <div class="header__search">
                <form class="search js-search" action="search.html">
                    <div class="search__pole js-search-pole">
                        <input class="search__field js-search-field" type="search" name="q" placeholder="Найти" autocomplete="off">
                    </div>
                </form>
            </div>
        </div>
        <div class="header__cart">
            <script id="js-cart-mini-templete" type="text/x-template">
                <div class="cart-item is-mini" :data-id="product.id">
                    <h4 class="cart-item__title"><a class="cart-item__link" :href="product.url" :title="product.title">{{product.title}}</a></h4><a class="cart-item__cover" :href="product.url" :title="product.title" tabindex="-1"><?= $directoryAsset ?><img class="cart-item__image" :src="product.image" alt></a>
                    <div class="cart-item__counter">
                        <counter @change="calc" :update="updateAmount" :product-id="product.id" :current-amount="product.amount" :min="1" :max="10"></counter>
                    </div>
                    <button class="cart-item__remove" @click="remove(product.id)" title="Удалить" type="button">
                        <svg>
                            <use xlink:href="<?= $directoryAsset ?>/img/sprite.svg#cart-item-remove"></use>
                        </svg>
                    </button>
                    <div class="cart-item__price">{{format(product.price)}} ₽</div>
                </div>
            </script>
            <div class="minicart js-minicart"><a class="minicart__toggle" href="/cart.html" @click.prevent.stop="isVisible = !isVisible"> <span class="minicart__toggle-icon" :class="{ &quot;in-process&quot;: inProcess }" :data-amount="count"></span><span class="minicart__toggle-text">Корзина</span></a>
                <div class="minicart__inner" :class="{ &quot;is-visible&quot;: isVisible }">
                    <div class="minicart__body">
                        <div class="minicart__empty" v-if="!amount">В корзине ничего нет</div>
                        <div class="minicart__list" v-if="amount">
                            <div class="minicart__item" v-for="product in products">
                                <cart-item @update="product.amount = $event" :product="product" :key="product.id"></cart-item>
                            </div>
                        </div>
                    </div>
                    <div class="minicart__footer" v-if="amount">
                        <div class="minicart__amount" v-text="&quot;Товаров: &quot; + amount"></div>
                        <div class="minicart__price">
                            <div class="minicart__price-label">Итого:</div>
                            <div class="minicart__price-value" v-text="totalPrice + &quot; ₽&quot;"></div>
                        </div><a class="minicart__button button" href="cart.html">Оформить</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
