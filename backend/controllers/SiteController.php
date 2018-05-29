<?php

namespace backend\controllers;

use common\components\AjaxValidationTrait;
use common\components\handbook\models\Handbook;
use common\components\tasks\models\Task;
use common\components\tasks\services\TaskService;
use common\models\forms\ForgotPasswordForm;
use common\models\forms\ResetPasswordForm;
use common\models\users\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\forms\LoginForm;

/**
 * Class SiteController
 * @package backend\controllers
 */
class SiteController extends Controller
{

    use AjaxValidationTrait;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow'   => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'lists'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                    [
                        'actions' => ['reset-password', 'forgot-password'],
                        'allow'   => true,
                        'roles'   => ['?'],
                    ],
                ],
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        return $this->render('index', ['tasks' => (new TaskService())->getTasksForDisplaying()]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionLogin()
    {
        $this->layout = 'main-login';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect('/dashboard');
        }

        return $this->render('login', ['model' => $model]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['site/login']);
    }

    /**
     * @param string $token
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionResetPassword($token)
    {
        $this->layout = 'main-login';

        $user = User::findOneStrictException(['password_reset_token' => $token]);
        $model = new ResetPasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->resetPassword($user)) {

            return $this->redirect('/dashboard');
        }

        return $this->render('reset-password', ['model' => $model]);
    }

    /**
     * Сброс пароля
     *
     * @return array|string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionForgotPassword()
    {
        $this->layout = 'main-login';

        $model = new ForgotPasswordForm();

        if ($model->load(Yii::$app->request->post())) {

            if (($errors = $this->modelAjaxValidation($model)) !== null) {
                return $errors;
            }

            if ($model->generatePasswordResetToken()) {

                Yii::$app->session->setFlash('warning', 'Запрос о посстановлении пароля получен, Вам на почту отправлено письмо');

                return $this->redirect(['site/login']);
            }
        }

        return $this->render('forgot-password', ['model' => $model]);
    }
}
