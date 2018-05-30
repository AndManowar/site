<?php

namespace common\components\nested\src\interfaces;

use yii\db\ActiveQuery;


/**
 * Interface TreeQueryInterface
 * @package common\components\nested\src\interfaces
 */
interface TreeQueryInterface
{
    /**
     * @return ActiveQuery
     */
    public function roots();
}