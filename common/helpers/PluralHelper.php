<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 30.08.17
 * Time: 16:15
 */

namespace common\helpers;

/**
 * Class PluralHelper
 *
 * @package common\helpers
 */
class PluralHelper
{

    /**
     *  Возвращает нужную форму слова в зависимости от количества ставок
     *
     * @param $number
     * @param $after
     * @return string
     */
    public static function plural_form($number, $after)
    {
        $cases = array (2, 0, 1, 1, 1, 2);

        return $number.' '.$after[ ($number%100>4 && $number%100<20)? 2: $cases[min($number%10, 5)] ];
    }

}