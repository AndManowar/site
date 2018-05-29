<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 01.02.18
 * Time: 9:44
 */

namespace common\components\settings;

use common\components\settings\models\Settings;

/**
 * Class Main
 *
 * @package common\components\settings
 */
class Main
{
    /**
     * @param string $systemName
     *
     * @return mixed|string
     */
    public function getValue($systemName)
    {
        $setting = Settings::find()->where(['systemName' => $systemName])->one();

        if (!$setting) {
            return null;
        }

        return $setting->value;
    }
}