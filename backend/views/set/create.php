<?php

$this->title = 'Добавление подборки';

/**
 * @var \common\models\forms\SetForm $model
 */
echo $this->render('_form', [
    'model'       => $model,
    'isNewRecord' => true
]);


