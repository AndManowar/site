<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 30.03.18
 * Time: 16:27
 */

namespace common\helpers;

use SergeyNezbritskiy\PrivatBank\Client;

/**
 * Class PBHelper
 *
 * @package common\helpers
 */
class PBHelper
{
    /**
     * @var Client
     */
    private static $client;

    /**
     * @return Client
     */
    public static function getClient()
    {
        if (self::$client == null) {
            self::$client = new Client();
        }

        return self::$client;
    }


    private static function test()
    {
//        $client = new \SergeyNezbritskiy\PrivatBank\Client();
////create request instance
//        $request = $client->infrastructure();
////run the request
//        $response = $request->execute([
//            'type' => \SergeyNezbritskiy\PrivatBank\Request\InfrastructureRequest::TYPE_ATM,
//            'city' => 'Днепропетровск',
//        ])->toArray();
    }

}