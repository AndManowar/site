<?php

$this->title = 'Обновление товара';

/**
 * @var \common\models\forms\ProductForm $model
 * @var array $categories
 */
echo $this->render('_form', [
    'model'       => $model,
    'isNewRecord' => false,
    'categories'  => $categories
]);