<?php

namespace common\helpers;

use yii;
use yii\helpers\ArrayHelper;

/**
 * Class SessionHelper
 * @package common\modules\chatbot\helpers
 */
class SessionHelper
{

    /**
     * Очистить текущую сессию
     */
    public static function cleanSession()
    {
        $session = Yii::$app->session;
        $session->open();
        $session->destroy();
    }

    /**
     * @param string $key
     * @return array
     */
    public static function getParams($key = null)
    {
        $session = Yii::$app->session;
        $session->open();

        if (is_null($key)) {
            return [];
        }

        if (ArrayHelper::keyExists($key, $session)) {
            return $session[$key];
        }

        return [];
    }

    /**
     * @param string $key
     * @param array $values
     */
    public static function setParamsInSession($key, array $values)
    {
        $session = Yii::$app->session;
        $session->open();

        $newSession = [];

        foreach ($values as $value) {
            $newSession[] = $value;
        }

        $session[$key] = $newSession;
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public static function addParamsToSession($key, $value)
    {
        $session = Yii::$app->session;
        $session->open();

        $newSession = [];

        $newSession[$key] = $session[$key] ? $session[$key] : [];

        array_push($newSession[$key], $value);

        $session[$key] = $newSession[$key];
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function unsetFromSession($key, $value)
    {
        $session = Yii::$app->session;
        $session->open();

        if (ArrayHelper::keyExists($key, $session)) {

            $id = array_search($value, $session[$key]);

            unset($_SESSION[$key][$id]);
        }
    }

    /**
     * @param array $keys
     */
    public static function clearByKeys(array $keys)
    {
        $session = Yii::$app->session;
        $session->open();

        foreach ($keys as $key){
            unset($session[$key]);
        }
    }
}