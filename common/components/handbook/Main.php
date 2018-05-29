<?php

namespace common\components\handbook;

use common\components\handbook\models\Handbook;
use common\components\handbook\models\HandbookData;
use Yii;
use yii\base\Component;
use yii\helpers\ArrayHelper;

/**
 * Handbook logic realization
 *
 * Class Main
 * @package common\components\handbook
 */
class Main extends Component
{
    /**
     * Cache name
     *
     * @const
     */
    const CACHE_NAME = 'handbook_cache';

    /**
     * Cache duration
     *
     * @const
     */
    const CACHE_DURATION = 172800;

    /**
     * Array of cached handbooks
     *
     * @var Handbook[]
     */
    private $cachedHandbooks;

    /**
     * Reading handbooks from cache
     */
    public function init()
    {
        $this->getFromCache();
        parent::init();
    }

    /**
     * Getting handbook by the name (Yii::$app->handbook->handbookName)
     *
     * @param string $name
     * @return Handbook|null
     */
    public function __get($name)
    {
        return isset($this->cachedHandbooks[$name]) ? $this->cachedHandbooks[$name] : null;
    }

    /**
     * Get handbook by the name
     *
     * @param string $name
     * @return array|Handbook
     */
    private function getHandbook($name)
    {
        return isset($this->cachedHandbooks[$name]) ? $this->cachedHandbooks[$name] : [];
    }

    /**
     * Get handbook data record by the name and data_id
     *
     * @param string $name
     * @param integer $data_id
     *
     * @return array|HandbookData
     */
    public function getHandbookDataItem($name, $data_id)
    {
        /** @var Handbook $handbook */
        $handbook = $this->getHandbook($name);

        if (!$handbook) {
            return [];
        }

        return HandbookData::find()->where(['handbook_id' => $handbook->id, 'data_id' => $data_id])->one();
    }

    /**
     * Getting handbookData values for dropdownList by the name
     *
     * @param string $name
     * @return array
     */
    public function getHandbooksListByName($name)
    {
        /** @var Handbook $handbook */
        $handbook = $this->getHandbook($name);

        if ($handbook) {
            return ArrayHelper::map($handbook->handbookData, 'data_id', 'title');
        }

        return [1 => 'Отсутствует'];
    }

    /**
     * Get handbook's list for dropdown
     *
     * @param null|integer $id
     * @return array
     */
    public function getHandbooksList($id = null)
    {
        if ($id != null) {

            $result = ArrayHelper::map($this->cachedHandbooks, 'id', 'description');
            ArrayHelper::remove($result, $id);

            return $result;
        }
        if ($this->cachedHandbooks) {
            return ArrayHelper::map($this->cachedHandbooks, 'id', 'description');
        }

        return [];
    }

    /**
     * Get parent handbookData by handbook->relation
     *
     * @param integer $related_handbook_id
     * @return array
     * @throws \yii\web\NotFoundHttpException
     */
    public function getDataForRelation($related_handbook_id)
    {
        return ArrayHelper::map(
            (Handbook::findOneStrictException($related_handbook_id))->getData(),
            'data_id',
            'title'
        );
    }

    /**
     * Get handbookData dependent on parent relation_data field
     *
     * F.e:
     * Parent:
     *  1 - val1
     *  2 - val2
     * Child:
     *  1 - va1 - dependent from Parent->val1
     *  2 - va2 - dependent from Parent->val1
     *
     * Result:
     * Request: Yii::$app->handbook->getRelatedData(Yii::$app->handbook->parent, Parent->val_id(1))
     * Response: [Child->val1, Child->val2]
     *
     *
     * @param Handbook $childHandbook - child handbook object
     * @param integer $id
     * @return array
     */
    public function getRelatedData($childHandbook, $id)
    {
        return ArrayHelper::map(HandbookData::find()
            ->where(['handbook_id' => $childHandbook->id, 'relation' => $id])
            ->all(), 'data_id', 'title');
    }

    /**
     * Refreshing cache
     */
    public function refreshCache()
    {
        $this->setToCache();
    }

    /**
     * Write handbooks to cache
     */
    private function setToCache()
    {
        /** @var Handbook $handbook */
        foreach (Handbook::find()->all() as $handbook) {
            $this->cachedHandbooks[$handbook->systemName] = $handbook;
        }

        Yii::$app->cache->set(self::CACHE_NAME, $this->cachedHandbooks, self::CACHE_DURATION);
    }

    /**
     * Get handbooks from cache
     */
    private function getFromCache()
    {
        $this->cachedHandbooks = Yii::$app->cache->get(self::CACHE_NAME);

        if (!$this->cachedHandbooks) {
            $this->cachedHandbooks = $this->setToCache();
        }
    }
}