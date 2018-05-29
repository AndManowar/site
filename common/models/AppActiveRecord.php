<?php

namespace common\models;

use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

/**
 * Class AppActiveRecord
 *
 * @package common\models
 */
class AppActiveRecord extends ActiveRecord
{
    /**
     * @const
     */
    const SCENARIO_SEARCH = 'search';

    /**
     * @var null
     */
    protected $customFormName = null;

    /**
     * @param $name
     */
    public function setFormName($name)
    {
        $this->customFormName = $name;
    }

    /**
     * @return null|string
     */
    public function formName()
    {
        if($this->customFormName == null) {
            return parent::formName();
        }else{
            return $this->customFormName;
        }
    }

    /**
     * Реализация метода  FindOne
     * При отсуствии выбрасывается исключение 404, для использования в CRUD методах
     *
     * @param $id
     * @return static
     * @throws NotFoundHttpException
     */
    public static function findOneStrictException($id)
    {
        if (($model = self::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * Получение зависимой (реляционой) записи по ID
     * Только для  hasMany
     *
     * @param $name
     * @param $id
     * @param bool $exp404
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function findOneRel($name, $id, $exp404 = false)
    {
        foreach ( $this->$name as $rel ){
            if( $rel->id == $id ) return $rel;
        }

        if( $exp404 ) throw new NotFoundHttpException('The requested page does not exist.');
        else return null;
    }

}
