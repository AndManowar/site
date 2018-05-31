<?php

$this->title = 'Добавление цвета';

/**
 * @var \common\models\forms\ColorForm $model
 */
echo $this->render('_form', [
    'model'       => $model,
    'isNewRecord' => true
]);


