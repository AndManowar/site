<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 06.03.18
 * Time: 16:31
 */

namespace common\helpers;

use common\components\newPost\src\Delivery\NovaPoshtaApi2;
use common\models\Orders;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class NewPostHelper
 * @package common\helpers
 */
class NewPostHelper
{
    /**
     * @var NovaPoshtaApi2
     */
    private static $newPostClient;

    /**
     * @return NovaPoshtaApi2
     */
    public static function getNewPostClient()
    {
        if (self::$newPostClient == null) {
            self::$newPostClient = new NovaPoshtaApi2(Yii::$app->config->getValue('new_post_api_key'));
        }

        return self::$newPostClient;
    }

    /**
     * @return array
     */
    public static function getRegionList()
    {
        $client = self::getNewPostClient();

        return ArrayHelper::map($client->getAreas()['data'], 'Ref', 'Description');
    }

    /**
     * @return array
     */
    public static function getCitiesList()
    {
        $client = self::getNewPostClient();

        return ArrayHelper::map($client->getCities()['data'], 'Description', 'Description');
    }

    /**
     * @param string $name
     * @return integer
     */
    public static function getCityId($name)
    {
        $client = self::getNewPostClient();

        return $client->getCity($name)['data'][0]['CityID'];
    }

    /**
     * @param string $name
     * @return integer
     */
    public static function getCityRef($name)
    {
        $client = self::getNewPostClient();

        return $client->getCity($name)['data'][0]['Ref'];
    }

    /**
     * @param string $city_name
     * @param bool $isAjax
     * @return array
     */
    public static function getWarehouseList($city_name, $isAjax = true)
    {
        $result = [];
        $client = self::getNewPostClient();

        $warehouses = $client->getWarehouses($client->getCity($city_name)['data'][0]['Ref']);

        if (!$isAjax) {
            return ArrayHelper::map($warehouses['data'], 'Description', 'Description');
        }

        $warehouses = ArrayHelper::map($warehouses['data'], 'Description', 'Description');

        foreach ($warehouses as $id => $warehouse) {
            $result[] = '<option value="' . $id . '">' . $warehouse . '</option>';
        }

        return $result;
    }

    /**
     * @param string $cityRecipient
     * @return string
     */
    public static function getDeliveryDate($cityRecipient)
    {
        $client = NewPostHelper::getNewPostClient();

        $response = $client->getDocumentDeliveryDate(Yii::$app->config->getValue('city_ref'), $cityRecipient, 'WarehouseWarehouse', date('d.m.Y'));

        $date = $response['data'][0]['DeliveryDate']['date'];
        $date = new \DateTime($date);

        return $date->format('d.m.Y');
    }

    /**
     * @param Orders $order
     *
     * @return array
     */
    public static function getTrackStatus($order)
    {
        $client = NewPostHelper::getNewPostClient();

        if (!$order->track_number) {
            return [];
        }

        $response = $client->documentsTracking($order->track_number);

        if (!isset($response['data'][0])) {
            return [];
        }

        $response = $response['data'][0];

        return [
            'route'   => $response['CitySender'] . ' - ' . $response['CityRecipient'],
            'address' => $response['WarehouseRecipient'],
            'status'  => $response['Status']
        ];
    }
}