<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 28.03.18
 * Time: 15:25
 */

namespace common\helpers;

use common\models\Orders;
use common\models\User;

/**
 * Class StatisticHelper
 * @package common\helpers
 */
class StatisticHelper
{

    /**
     * @return array
     */
    public static function getMainStatistic()
    {
        $statistic = [
            'ordersCount' => Orders::find()->where(['status_id' => Orders::STATUS_NEW])->count().'/'.Orders::find()->count(),
            'usersCount' => User::find()->count(),
            'totalIncome' => Orders::find()->sum('total_price'),
        ];

        $statistic['factIncome'] = $statistic['totalIncome'] - Orders::find()
                ->joinWith(['ordersProducts as o_p', 'ordersProducts.productsProperty.product as pr'])
                ->sum('pr.hidden_price * o_p.quantity');

        return $statistic;
    }

}