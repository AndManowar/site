<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 03.06.2018
 * Time: 17:39
 */

namespace backend\controllers;

use common\components\AjaxValidationTrait;
use common\components\rbac\baseController;
use common\models\forms\SetForm;
use common\models\sets\SetSearch;
use Yii;
use yii\base\Module;
use yii\web\UploadedFile;

/**
 * Class SetController
 * @package backend\controllers
 */
class SetController extends baseController
{
    use AjaxValidationTrait;

    /**
     * @var SetForm
     */
    private $setForm;

    /**
     * SetController constructor.
     * @param string $id
     * @param Module $module
     * @param SetForm $setForm
     * @param array $config
     */
    public function __construct($id, Module $module, SetForm $setForm, array $config = [])
    {
        $this->setForm = $setForm;
        parent::__construct($id, $module, $config);
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SetSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Create set action
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if ($this->setForm->load(Yii::$app->request->post())) {

            $this->setForm->file = UploadedFile::getInstance($this->setForm, 'file');

            if ($this->setForm->create()) {
                Yii::$app->session->setFlash('success', 'Подборка создана');

                return $this->redirect(['set/add-products', 'id' => $this->setForm->set->id]);
            }
        }

        return $this->render('create', ['model' => $this->setForm]);
    }

    /**
     * Update set action
     *
     * @param integer $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $this->setForm->setModel($id);

        if ($this->setForm->load(Yii::$app->request->post())) {

            $this->setForm->file = UploadedFile::getInstance($this->setForm, 'file');

            if ($this->setForm->update()) {
                Yii::$app->session->setFlash('success', 'Подборка изменена');

                return $this->redirect(['set/set-products', 'id' => $this->setForm->set->id]);
            }
        }

        return $this->render('update', ['model' => $this->setForm]);
    }

    /**
     * Set settings
     *
     * @param integer $id
     * @return string
     */
    public function actionSetProducts($id)
    {
        $this->setForm->setModel($id);

        return $this->render('products', [
            'model' => $this->setForm,
        ]);
    }

    /**
     * Add product to set action
     *
     * @param integer $id
     * @return \yii\web\Response
     */
    public function actionAddProduct($id)
    {
        $this->setForm->setModel($id);

        if ($this->setForm->addProductToSet(Yii::$app->request->post())) {
            Yii::$app->session->setFlash('success', 'Товар добавлен в подборку');
        } else {
            Yii::$app->session->setFlash('danger', $this->setForm->errorsMessage);
        }

        return $this->redirect(['set/set-products', 'id' => $this->setForm->set->id]);
    }

    public function actionDeleteFromSet($id)
    {
        
    }

    /**
     * Delete set action
     *
     * @param integer $id
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        $this->setForm->setModel($id);

        if ($this->setForm->delete()) {
            Yii::$app->session->set('success', 'Подборка удалена');
        } else {
            Yii::$app->session->set('success', 'Невозможно удалить подборку');
        }

        return $this->redirect(['index']);
    }
}