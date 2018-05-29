<?php


/**
 * @var Settings $model
 */

use common\components\settings\models\Settings;

$this->title =  'Изменение настройки';

echo $this->render('_form', ['model' => $model]);

