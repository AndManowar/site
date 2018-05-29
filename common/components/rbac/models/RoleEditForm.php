<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 09.08.17
 * Time: 15:48
 */

namespace common\components\rbac\models;

use Yii;
use yii\base\Model;

/**
 * Class RoleEditForm
 * @package common\components\rbac\models
 */
class RoleEditForm extends Model
{
    /**
     * @const
     */
    const SCENARIO_UPDATE = 'update';

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $description;

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name'        => 'Системное имя',
            'description' => 'Описание',
        ];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            ['description', 'string', 'length' => [4, 60]],
            ['name', 'string', 'length' => [4, 24]],
            ['name', function ($attribute) {
                if (Yii::$app->authManager->getRole($this->$attribute) !== null) {
                    $this->addError($attribute, 'Системное имя роли должно быть уникальным!');
                }
            }, 'on' => self::SCENARIO_UPDATE],
        ];
    }

    /**
     * @param $role
     * @return void
     */
    public function loadAttributes($role)
    {
        $this->name = $role->name;
        $this->description = $role->description;
    }
}