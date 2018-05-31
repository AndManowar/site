<?php

$this->title = 'Новый товар';

/**
 * @var \common\models\forms\ProductForm $model
 * @var array $categories
 */
echo $this->render('_form', [
    'model'       => $model,
    'isNewRecord' => true,
    'categories'  => $categories
]);