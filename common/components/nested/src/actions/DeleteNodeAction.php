<?php

namespace common\components\nested\src\actions;

use common\components\nested\src\interfaces\TreeInterface;
use Yii;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

/**
 * Class DeleteNodeAction
 * @package common\components\nested\src\actions
 */
class DeleteNodeAction extends BaseAction
{
    /**
     * Move a node (model) below the parent and in between left and right
     *
     * @param integer $id the primaryKey of the moved node
     * @return array
     * @throws NotFoundHttpException
     */
    public function run($id)
    {
        /** @var ActiveRecord|TreeInterface $model */
        $model = $this->findModel($id);

        return $model->deleteWithChildren();
    }
}