<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 23.01.18
 * Time: 11:22
 */

namespace common\helpers;

use common\models\Profile;
use Yii;
use common\models\User;
use yii\base\Event;
use yii\base\Exception;

/**
 * Class MailHelper
 *
 * @package common\helpers
 */
class MailHelper
{

    /**
     * @const
     */
    const TEMPLATE_REGISTER = 1;

    /**
     * @const
     */
    const TEMPLATE_RESET_PASSWORD = 2;

    /**
     * @const
     */
    const TEMPLATE_REGISTER_VIA_ORDER = 3;

    /**
     * @const
     */
    const CONTACT_TO_ADMIN = 4;

    /**
     * @const
     */
    const CONTACT_REPLY = 5;

    /**
     * @param string $email
     * @param integer $template
     * @param array $params
     * @param string $subject
     * @return bool
     * @throws Exception
     */
    public static function sendEmail($email, $template, $params = [], $subject)
    {
        $message = self::getMailData($template, $params);

        $message->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->config->getValue('shop_name')]);
        $message->setTo($email);
        $message->setSubject($subject);

        return $message->send();
    }

    /**
     * @param integer $template
     * @param array $params
     * @return \yii\mail\MessageInterface
     * @throws Exception
     */
    private static function getMailData($template, $params = [])
    {
        switch ($template) {

            case self::TEMPLATE_REGISTER:
                return Yii::$app->mailer->compose('registerLetter', ['params' => $params]);
                break;
            case self::TEMPLATE_RESET_PASSWORD:
                return Yii::$app->mailer->compose('resetPasswordLetter', ['params' => $params]);
                break;
            case self::TEMPLATE_REGISTER_VIA_ORDER:
                return Yii::$app->mailer->compose('registerViaOrder', ['params' => $params]);
                break;
            case self::CONTACT_TO_ADMIN:
                return Yii::$app->mailer->compose('contact_letter', ['params' => $params]);
                break;
            case self::CONTACT_REPLY:
                return Yii::$app->mailer->compose('reply_contacts', ['params' => $params]);
                break;
            default:
                throw new Exception('Unknown mail template name.');
                break;
        }
    }
}