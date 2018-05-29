<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 31.01.18
 * Time: 11:26
 */

namespace common\components\settings\helpers;

use kartik\date\DatePicker;
use kartik\widgets\DateTimePicker;
use yii\base\InvalidArgumentException;
use yii\base\UnknownPropertyException;
use yii\helpers\ArrayHelper;
use yii\validators\BooleanValidator;
use yii\validators\DateValidator;
use yii\validators\NumberValidator;
use yii\validators\StringValidator;

/**
 * Class FormFieldsHelper
 *
 * @package common\helpers
 */
class FormFieldsHelper
{
    /**
     * @const
     */
    const FIELD_TYPE_TEXT_INPUT = 1;

    /**
     * @const
     */
    const FIELD_TYPE_TEXT_AREA = 2;

    /**
     * @const
     */
    const FIELD_TYPE_CHECKBOX = 3;

    /**
     * @const
     */
    const FIELD_TYPE_INTEGER = 4;

    /**
     * @const
     */
    const FIELD_TYPE_DATE = 5;


    /**
     * @const
     */
    const FIELD_TYPE_DATETIME = 6;

    /**
     * @var array
     */
    public static $errors;

    /**
     * @var array
     */
    private static $typeList = [

        self::FIELD_TYPE_TEXT_INPUT => [
            'StringValidator',                      // Класс Валидатора
            ['max' => 30],                          // Параметры класа Валидатора
            'Текстовое поле (макс. 30 знаков)',     // Описание
            'textInput',                            // Элемент формы (Класс Виджета)
            ['string', 'max' => 30],
        ],
        self::FIELD_TYPE_TEXT_AREA  => [
            'StringValidator',
            ['max' => 250],
            'Большое текст. поле (макс. 250 знаков)',
            'textInput',
            ['string', 'max' => 250],
        ],
        self::FIELD_TYPE_CHECKBOX   => [
            'BooleanValidator',
            [],
            'Чекбокс (Да / Нет)',
            'checkbox',
            ['boolean'],
        ],
        self::FIELD_TYPE_INTEGER    => [
            'NumberValidator',
            ['integerOnly' => true],
            'Целое число',
            'textInput',
            ['integer'],
        ],
        self::FIELD_TYPE_DATE       => [
            'DateValidator',
            [
                'type'   => DateValidator::TYPE_DATE,
                'format' => 'd/mm/yyyy'
            ],
            'Дата'
        ],
        self::FIELD_TYPE_DATETIME   => [
            'DateTimeValidator',
            [
                'type'   => DateValidator::TYPE_DATETIME,
                'format' => 'd/mm/yyyy HH:mm'
            ],
            'Дата и время'
        ]
    ];

    /**
     * @return array
     */
    public static function getFileList()
    {
        return ArrayHelper::getColumn(self::$typeList, function ($array) {
            return $array[2];
        });
    }

    /**
     * @param integer $fieldType
     * @param mixed $value
     * @return bool
     * @throws UnknownPropertyException
     */
    public static function validation($fieldType, $value)
    {
        if (!isset(self::$typeList[$fieldType])) {
            throw new UnknownPropertyException;
        }

        self::$errors = null;
        $validator = self::createValidator(self::$typeList[$fieldType][0], self::$typeList[$fieldType][1]);

        if ($validator->validate($value, self::$errors)) {
            return true;
        }

        return false;

    }

    /**
     * Валидация
     *
     * @param string $sysName
     * @param array $params
     * @return BooleanValidator|DateValidator|NumberValidator|StringValidator
     */
    private static function createValidator($sysName, array $params)
    {
        switch ($sysName) {
            case 'NumberValidator':
                return new NumberValidator($params);
                break;
            case 'BooleanValidator':
                return new BooleanValidator($params);
                break;
            case 'StringValidator':
                return new StringValidator($params);
                break;
            case 'DateValidator':
                return new DateValidator($params);
                break;
            case 'DateTimeValidator':
                return new DateValidator($params);
                break;
        }

        throw new InvalidArgumentException();
    }

    /**
     * Получение поля для формы
     *
     * @param \yii\widgets\ActiveForm $form
     * @param $model
     * @param integer $field_type
     * @param string $field_attr
     * @param array $field_options
     *
     * @return \yii\widgets\ActiveField
     */
    public static function getFormField($form, $model, $field_attr, $field_type, $field_options = [])
    {

        switch ($field_type) {

            case self::FIELD_TYPE_TEXT_INPUT:
                return $form->field($model, $field_attr)->textInput($field_options);
                break;
            case self::FIELD_TYPE_TEXT_AREA:
                return $form->field($model, $field_attr)->textarea(['rows']);
                break;
            case self::FIELD_TYPE_CHECKBOX:
                return $form->field($model, $field_attr)->checkbox();
                break;
            case self::FIELD_TYPE_INTEGER:
                return $form->field($model, $field_attr)->textInput($field_options);
                break;
            case self::FIELD_TYPE_DATE:
                return $form->field($model, $field_attr)->widget(DatePicker::class, [
                    'options'       => ['placeholder' => 'Дата'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format'    => 'd/mm/yyyy'
                    ]
                ]);
                break;
            case self::FIELD_TYPE_DATETIME:
                return $form->field($model, $field_attr)->widget(DateTimePicker::class, [
                    'options'       => ['placeholder' => 'Дата и время'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format'    => 'd/mm/yyyy HH:mm'
                    ]
                ]);
                break;
        }

        throw new InvalidArgumentException();
    }
}
