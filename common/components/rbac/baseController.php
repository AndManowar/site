<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10.05.2016
 * Time: 12:54
 */

namespace common\components\rbac;

use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

/**
 * Class baseController
 * @package common\components\rbac
 */
class baseController extends Controller
{

    /**
     * @const
     */
    const BACKEND_BRANCH = 0;

    /**
     * @const
     */
    const FRONTEND_BRANCH = 1;

    /**
     * @param $action
     * @return bool|\yii\web\Response
     * @throws ForbiddenHttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {

        if (!Yii::$app->accessControl->control(Yii::$app->params['accessControl']['controlBranchId'])) {

            if (Yii::$app->params['accessControl']['controlBranchId'] == self::BACKEND_BRANCH && Yii::$app->user->isGuest) {
                return $this->redirect(['/site/login']);
            }

            throw new ForbiddenHttpException();
        }

        return parent::beforeAction($action);
    }
}