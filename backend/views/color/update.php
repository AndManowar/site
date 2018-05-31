<?php

$this->title = 'Обновление цвета';

/**
 * @var \common\models\forms\ColorForm $model
 */
echo $this->render('_form', [
    'model'       => $model,
    'isNewRecord' => false,
]);


