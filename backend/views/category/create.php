<?php

$this->title = 'Новая категория';

/**
 * @var \common\models\forms\CategoryForm $model
 * @var array $roots
 */
echo $this->render('_form', [
    'model'       => $model,
    'roots'       => $roots,
    'isNewRecord' => true
]);


