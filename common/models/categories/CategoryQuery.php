<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 29.05.2018
 * Time: 19:13
 */

namespace common\models\categories;

use creocoder\nestedsets\NestedSetsQueryBehavior;
use paulzi\adjacencyList\AdjacencyListQueryTrait;
use yii\db\ActiveQuery;

/**
 * Class CategoryQuery
 * @package common\models\categories
 * @see Category
 * @method CategoryQuery roots();
 */
class CategoryQuery extends ActiveQuery
{
    use AdjacencyListQueryTrait;
}