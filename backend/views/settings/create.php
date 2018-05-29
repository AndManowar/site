<?php


use common\components\settings\models\Settings;

$this->title = 'Создание настройки';

/**
 * @var Settings $model
 */

echo $this->render('_form', ['model' => $model]);

