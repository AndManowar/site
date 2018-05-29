<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 09.03.18
 * Time: 14:39
 */

namespace common\helpers;

use common\models\Orders;
use common\models\OrdersProducts;
use common\models\OrdersStatuses;
use common\services\Discount;

/**
 * Class OrderHelper
 * @package common\helpers
 */
class OrderHelper
{
    /**
     * @param Orders $order
     * @return bool
     */
    public static function recalculateOrder($order)
    {
        $order->old_price = 0;

        foreach ($order->ordersProducts as $ordersProduct) {

            $ordersProduct->price = $ordersProduct->productsProperty->product->price;
            $order->old_price += $ordersProduct->total_price;
        }

        return (new Discount($order))->calculateDiscount();
    }

    /**
     * @param Orders $order
     * @param integer $previous_status
     * @return bool
     */
    public static function setStatus($order, $previous_status)
    {
        if ($previous_status != $order->status_id) {
            $orderStatus = new OrdersStatuses(['order_id' => $order->id, 'current_status_id' => $order->status_id]);

            if ($previous_status != null) {
                $orderStatus->previous_status_id = $previous_status;
            }

            if (!$orderStatus->save()) {
                return false;
            }
        }

        $order->status_at = time();

        return true;
    }

    /**
     * @param OrdersProducts $product
     * @return bool
     */
    public static function addProduct($product)
    {
        $product->price = $product->productsProperty->product->price;
        $product->total_price = $product->price * $product->quantity;

        return $product->save();
    }
}