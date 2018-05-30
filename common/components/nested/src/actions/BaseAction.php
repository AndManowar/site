<?php

namespace common\components\nested\src\actions;

use common\components\nested\src\interfaces\TreeInterface;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

/**
 * Class BaseAction
 * @package common\components\nested\src\actions
 */
abstract class BaseAction extends Action
{
    /**
     * Class to use to locate the supplied data ids
     * @var string
     */
    public $modelClass;

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (null == $this->modelClass) {
            throw new InvalidConfigException('Param "modelClass" must be contain model name with namespace.');
        }
    }

    /**
     * @param $id
     * @return ActiveRecord|TreeInterface
     * @throws NotFoundHttpException
     */
    public function findModel($id)
    {
        /** @var ActiveRecord $model */
        $model = $this->modelClass;
        /** @var ActiveRecord|TreeInterface $model */
        $model = $model::findOne($id);

        if ($model == null) {
            throw new NotFoundHttpException();
        }

        return $model;
    }
}