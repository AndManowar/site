<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 26.07.17
 * Time: 18:33
 */

namespace backend\controllers;

use backend\models\Model;
use common\components\AjaxValidationTrait;
use common\components\handbook\models\Handbook;
use common\components\handbook\models\HandbookData;
use common\components\handbook\models\HandbookFields;
use common\components\handbook\services\HbService;
use common\components\rbac\baseController;
use Yii;
use yii\base\Module;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
 * Class HandbookController
 *
 * @package backend\controllers
 */
class HandbookController extends baseController
{
    use AjaxValidationTrait;

    /**
     * @var HbService
     */
    private $hbService;

    /**
     * HandbookController constructor.
     * @param integer $id
     * @param Module $module
     * @param HbService $hbService
     * @param array $config
     */
    public function __construct($id, Module $module, HbService $hbService, array $config = [])
    {
        $this->hbService = $hbService;
        parent::__construct($id, $module, $config);
    }

    /**
     * Handbook list
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new Handbook(['scenario' => Handbook::SCENARIO_SEARCH]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Handbook create
     *
     * @return array|string|Response
     */
    public function actionCreate()
    {
        $handbook = new Handbook(['scenario' => Handbook::SCENARIO_CREATE]);

        if ($handbook->load(Yii::$app->request->post())) {

            $additionalFields = Model::createMultiple(HandbookFields::class);
            Model::loadMultiple($additionalFields, Yii::$app->request->post());

            if (($errors = $this->validateModelAndModels($handbook, $additionalFields)) !== null) {
                return $errors;
            }

            if ($this->hbService->createOrEditHandbook($handbook, $additionalFields)) {

                Yii::$app->session->setFlash('success', 'Справочник создан');

                return $this->redirect(['handbook/update', 'id' => $handbook->id]);
            }
        }

        return $this->render('structure_form', [
            'handbook' => $handbook,
            'fields'   => empty($additionalFields) ? [new HandbookFields()] : $additionalFields,
        ]);
    }

    /**
     * Adding handbookData action
     *
     * @param integer $id
     * @return array|null|string|Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $handbook = Handbook::findOneStrictException($id);
        $handbook->scenario = Handbook::SCENARIO_CREATE;
        $data = $handbook->getData();

        if (Yii::$app->request->post('HandbookData')) {

            $oldIDs = ArrayHelper::map($data, 'id', 'id');
            $data = Model::createMultiple(HandbookData::class, $data);
            Model::loadMultiple($data, Yii::$app->request->post());

            if (($errors = $this->validateMultipleModels($data)) !== null) {
                return $errors;
            }

            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($data, 'id', 'id')));
            HandbookData::deleteAll(['id' => $deletedIDs]);

            if ($this->hbService->addData($data)) {

                Yii::$app->session->setFlash('warning', 'Информация справочника изменена');

                return $this->redirect(['index']);
            }
        }

        return $this->render('_form', [
            'handbook' => $handbook,
            'fields'   => $handbook->getFields(),
            'data'     => empty($data) ? [new HandbookData()] : $data,
        ]);
    }

    /**
     * Updating handbook structure action
     *
     * @param integer $id
     * @return array|null|string|Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdateStructure($id)
    {
        $handbook = Handbook::findOneStrictException($id);
        $handbook->scenario = Handbook::SCENARIO_CREATE;

        if ($handbook->load(Yii::$app->request->post())) {

            $additionalFields = Model::createMultiple(HandbookFields::class);
            Model::loadMultiple($additionalFields, Yii::$app->request->post());

            if (($errors = $this->validateModelAndModels($handbook, $additionalFields)) !== null) {
                return $errors;
            }

            if ($this->hbService->createOrEditHandbook($handbook, $additionalFields)) {

                Yii::$app->session->setFlash('success', 'Структура изменена');

                return $this->redirect(['handbook/update', 'id' => $handbook->id]);
            }
        }

        return $this->render('structure_form', [
            'handbook' => $handbook,
            'fields'   => $handbook->getFields() ? $handbook->getFields() : [new HandbookFields()],
        ]);
    }

    /**
     * Delete action
     *
     * @param integer $id
     * @return Response
     */
    public function actionDelete($id)
    {
        if ($this->hbService->deleteHandbook($id)) {
            Yii::$app->session->setFlash('success', 'Справочник удален');

        } else {
            Yii::$app->session->setFlash('danger', 'Невозможно удалить справочник');
        }

        return $this->redirect('index');
    }

    /**
     * Cache regeneration
     *
     * @return Response
     */
    public function actionResetCache()
    {
        Yii::$app->handbook->refreshCache();

        Yii::$app->session->setFlash('success', 'Кэш перегенерирован');

        return $this->redirect('index');
    }
}