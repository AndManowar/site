<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 11.08.17
 * Time: 12:48
 */

namespace backend\controllers;

use common\components\rbac\baseController;
use Yii;

/**
 * Class ScanController
 * @package backend\controllers
 */
class ScanController extends baseController
{
    /**
     * Список отсканированных роутов
     *
     * @return string
     */
    public function actionIndex()
    {
        $scanList = [];
        $branch = Yii::$app->accessControl->branches;
        $group = Yii::$app->accessControl->getAllGroupPermission();

        if (Yii::$app->request->post('branch') != null) {
            $branchItem = $branch[Yii::$app->request->post('branch')];
            $scanList = Yii::$app->accessControl->scanNewMethod(Yii::getAlias($branchItem[1]), Yii::$app->request->post('branch'));
        }


        return $this->render('index', [
            'scanList' => $scanList,
            'branch'   => $branch,
            'group'    => $group,
            'branchId' => Yii::$app->request->post('branch'),
        ]);
    }

    /**
     * Добавить роут в группу
     *
     * @return bool
     *
     * @throws \Exception
     * @throws \yii\base\Exception
     */
    public function actionAddRout()
    {
        if (Yii::$app->request->isPost) {

            $routName = Yii::$app->accessControl->addRoutePermission(trim(Yii::$app->request->post('rout')), trim(Yii::$app->request->post('branch')));

            if ($routName != null) {
                Yii::$app->accessControl->addRouteToGroup($routName, trim(Yii::$app->request->post('group')));

                return true;
            }
        }

        return false;
    }
}