<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 11.03.2018
 * Time: 22:13
 */

namespace frontend\controllers;

use common\components\AjaxValidationTrait;
use common\components\handbook\models\HandbookData;
use common\helpers\MailHelper;
use common\helpers\PBHelper;
use common\helpers\ProductsHelper;
use common\models\Banners;
use common\models\Contacts;
use common\models\LoginForm;
use common\models\Subscriptions;
use frontend\models\SignupForm;
use Yii;
use yii\web\Controller;
use yii\web\Response;

/**
 * Class SiteController
 * @package frontend\controllers
 */
class SiteController extends Controller
{
    use AjaxValidationTrait;

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @return array|string|\yii\web\Response
     * @throws \Exception
     * @throws \yii\base\Exception
     */
    public function actionSignUp()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['index']);
        }

        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {

            if (($errors = $this->modelAjaxValidation($model)) !== null) {
                return $errors;
            }
            if ($user = $model->signup()) {

                if (Yii::$app->getUser()->login($user)) {

                    MailHelper::sendEmail($user->email, MailHelper::TEMPLATE_REGISTER, ['user' => $user], 'Дякуємо за реєстрацію');

                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * @return string
     */
    public function actionContacts()
    {
        $model = new Contacts();

        if($model->load(Yii::$app->request->post()) && $model->create()){

            Yii::$app->session->setFlash('success', 'Дякуємо за звернення, очікуйте на відповідь!');
            return $this->redirect(['/site']);
        }

        return $this->render('contact', ['model' => $model]);
    }

    /**
     * @return string
     */
    public function actionFaq()
    {
        return $this->render('faq', ['faq' => isset(Yii::$app->handbook->faq->handbookData) ? Yii::$app->handbook->faq->handbookData : []]);
    }

    /**
     * @return array|bool
     */
    public function actionSubscribe()
    {
        $model = new Subscriptions();

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return true;
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->statusCode = 404;

        return ['errors' => $model->errors];
    }
}