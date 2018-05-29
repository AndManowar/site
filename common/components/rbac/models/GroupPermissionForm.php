<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 11.08.17
 * Time: 11:36
 */

namespace common\components\rbac\models;

use yii\base\Model;

/**
 * Class GroupPermissionForm
 * @package common\components\rbac\models
 */
class GroupPermissionForm extends Model
{
    /**
     * @var string
     */
    public $systemName;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['systemName', 'required'],
            ['systemName', 'string', 'min' => 5, 'max' => 40]
        ];

    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'systemName' => 'Описание'
        ];
    }
}