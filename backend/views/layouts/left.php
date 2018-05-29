<?php
/** @var string $directoryAsset */

use yii\helpers\Url;
use yii\widgets\Menu;

?>

<aside id="left-panel">
    <nav>
        <?= Menu::widget([
            'items' => [
                ['encode' => false, 'label' => '<i class="fa fa-lg fa-fw fa-indent"></i> <span class="menu-item-parent">Категории</span>', 'url' => ['/category']],
                ['encode' => false, 'label' => '<i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Настройки</span>', 'url' => ['/settings']],
                ['encode' => false, 'label' => '<i class="fa fa-lg fa-fw fa-book"></i> <span class="menu-item-parent">Справочник</span>', 'url' => ['/handbook']],
                [
                    'encode' => false,
                    'label'  => '<i class="fa fa-lg fa-fw fa-bug"></i> <span class="menu-item-parent">RBAC</span>',
                    'url'    => '#',
                    'items'  =>
                        [
                            [
                                'label' => 'Группы/разрешения',
                                'url'   => ['/roles']
                            ],
                            [
                                'label' => 'Сканер роутов',
                                'url'   => ['/scan']
                            ],
                        ],
                ],
            ],
        ]) ?>
    </nav>
    <span class="minifyme" data-action="minifyMenu">
				<i class="fa fa-arrow-circle-left hit"></i>
			</span>

</aside>