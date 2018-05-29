<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 06.07.2016
 * Time: 9:43
 */

namespace common\components\handbook;

use yii\base\InvalidArgumentException;
use yii\base\UnknownPropertyException;
use yii\helpers\ArrayHelper;

use yii\validators\StringValidator;
use yii\validators\BooleanValidator;
use yii\validators\NumberValidator;

/**
 * Class TypeHelper
 * @package common\components\handbook
 */
class TypeHelper
{
    /**
     * Array vith validation errors
     *
     * @var array
     */
    public static $errors;

    /**
     * Array of validation rules and description for additional fields
     *
     * @var array
     */
    private static $types = [
        1 => [
            'StringValidator',                      // Validator class
            ['max' => 30],                          // Validation params
            'Текстовое поле (макс. 30 знаков)',     // Description
            'textInput',                            // Type of form field
            ['string', 'max' => 30],
        ],
        2 => [
            'StringValidator',
            ['max' => 250],
            'Большое текст. поле (макс. 250 знаков)',
            'textInput',
            ['string', 'max' => 250],
        ],
        3 => [
            'BooleanValidator',
            [],
            'Чекбокс (Да / Нет)',
            'checkbox',
            ['boolean'],
        ],
        4 => [
            'NumberValidator',
            ['integerOnly' => true],
            'Целое число',
            'textInput',
            ['integer'],
        ],
        5 => [
            'NumberValidator',
            [],
            'Число',
            'textInput',
            ['integer'],
        ]
    ];

    /**
     * Field titles for dropdown
     *
     * @param null|integer $id
     * @return array
     */
    public static function getTitleTypes($id = null)
    {
        if (isset(self::$types[$id])) {
            return self::$types[$id][2];
        } else {
            return ArrayHelper::getColumn(self::$types, function ($array) {
                return $array[2];
            });
        }
    }

    /**
     * Get Field types
     *
     * @param null|integer $id
     * @return array
     */
    public static function getTypes($id = null)
    {
        if (isset(self::$types[$id])) {
            return self::$types[$id];
        } else {
            return self::$types;
        }
    }

    /**
     * Value validation
     *
     * @param integer $id
     * @param mixed $value
     * @return bool
     * @throws UnknownPropertyException
     *
     */
    public static function validation($id, $value)
    {
        if (!isset(self::$types[$id])) {
            throw new UnknownPropertyException;
        }

        self::$errors = null;
        /** @var NumberValidator|BooleanValidator|StringValidator $validator */
        $validator = self::createValidator(self::$types[$id][0], self::$types[$id][1]);

        if ($validator->validate($value, self::$errors)) {
            return true;
        }

        return false;

    }

    /**
     * Creating validators
     *
     * @param integer $fieldType
     * @param array $params
     * @return BooleanValidator|NumberValidator|StringValidator
     */
    private static function createValidator($fieldType, $params)
    {
        switch ($fieldType) {
            case 'NumberValidator':
                return new NumberValidator($params);
                break;
            case 'BooleanValidator':
                return new BooleanValidator($params);
                break;
            case 'StringValidator':
                return new StringValidator($params);
                break;
        }

        throw new InvalidArgumentException();
    }
}