<?php

$this->title = 'Обновление категории';

/**
 * @var \common\models\forms\CategoryForm $model
 * @var array $roots
 */
echo $this->render('_form', [
    'model'       => $model,
    'roots'       => $roots,
    'isNewRecord' => false,
]);


