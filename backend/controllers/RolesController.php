<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 09.08.17
 * Time: 15:45
 */

namespace backend\controllers;

use backend\models\Model;
use common\components\rbac\baseController;
use common\components\rbac\models\GroupPermissionForm;
use common\components\rbac\models\RoleEditForm;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * Class RolesController
 * @package backend\controllers
 */
class RolesController extends baseController
{
    /**
     * Список ролей
     *
     * @param null $name
     * @param int $type
     * @return string
     */
    public function actionIndex($name = null, $type = 1)
    {
        $roles = Yii::$app->authManager->getRoles();

        $groupPermissions = Yii::$app->accessControl->getAllGroupPermission();
        if ($name != null) {
            if ($type == 1) {
                $role = Yii::$app->authManager->getRole($name);
                Yii::$app->authManager->remove($role);
                Yii::$app->session->setFlash('danger', 'Роль удалена');
                return $this->redirect(['index', 'roles' => $roles, 'permissions' => $groupPermissions]);
            } else {
                Yii::$app->accessControl->deleteGroupPermission($name);
                Yii::$app->session->setFlash('danger', 'Группа разрешений удалена');
                return $this->redirect(['index', 'roles' => $roles, 'permissions' => $groupPermissions]);
            }
        }
        return $this->render('index', [
            'roles'       => $roles,
            'permissions' => $groupPermissions,
        ]);
    }

    /**
     * Создание/обновление ролей
     *
     * @param null $name
     *
     * @return string|\yii\web\Response
     *
     * @throws \yii\db\Exception
     * @throws \Exception
     */
    public function actionCreateUpdate($name = null)
    {

        if ($name == null) {
            $rbacs = Model::createMultiple(new RoleEditForm());
            if (Model::loadMultiple($rbacs, Yii::$app->request->post()) && Model::validateMultiple($rbacs)) {
                $transaction = Yii::$app->db->beginTransaction();

                if (Yii::$app->accessControl->addRoles($rbacs)) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Роль успешно создана');
                    return $this->redirect('index');
                } else {
                    $transaction->rollBack();

                }

            }
            return $this->render('create', [
                'rbacs'    => (empty($rbacs)) ? [new RoleEditForm()] : $rbacs,
                'isCreate' => true
            ]);
        } else {

            $role = Yii::$app->authManager->getRole($name);
            $rbacs = new RoleEditForm(['scenario' => 'update']);
            $rbacs->loadAttributes($role);
            if ($rbacs->load(Yii::$app->request->post())) {
                if (Yii::$app->accessControl->editRole($rbacs->name, $rbacs->description)) {
                    Yii::$app->session->setFlash('success', 'Роль успешно изменена');
                    $this->redirect('index');
                }

            }
            return $this->render('create', [
                'rbacs'    => $rbacs,
                'isCreate' => false
            ]);
        }

    }

    /**
     * Создание/обновление груп разрешений
     *
     * @param null $name
     *
     * @return string|\yii\web\Response
     *
     * @throws \yii\db\Exception
     * @throws \Exception
     */
    public function actionCreateUpdateGroupPermission($name = null)
    {
        if ($name == null) {
            $permissions = Model::createMultiple(new GroupPermissionForm());
            if (Model::loadMultiple($permissions, Yii::$app->request->post()) && Model::validateMultiple($permissions)) {
                $transaction = Yii::$app->db->beginTransaction();

                if (Yii::$app->accessControl->addGroupPermissions($permissions)) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Группа разрешений успешно создана');
                    return $this->redirect('index');
                } else {
                    $transaction->rollBack();
                }

            }
            return $this->render('group_create', [
                'permissions' => (empty($permissions)) ? [new GroupPermissionForm()] : $permissions,
                'isCreate'    => true
            ]);
        } else {

            $permission = Yii::$app->accessControl->getGroupPermission($name);

            $form = new GroupPermissionForm();
            $form->systemName = $permission->description;
            if ($form->load(Yii::$app->request->post())) {

                if (Yii::$app->accessControl->addGroupPermission($form->systemName)) {
                    Yii::$app->session->setFlash('success', 'Группа разрешений успешно создана');
                    $this->redirect('index');
                }

            }
            return $this->render('group_create', [
                'permissions' => $form,
                'isCreate'    => false
            ]);
        }
    }

    /**
     * Метод добавления пользователя к групе разрешений
     *
     * @return bool
     *
     * @throws \yii\base\Exception
     */
    public function actionUpdate()
    {

        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            if (isset($data['role']) and isset($data['group']) and isset($data['status'])) {

                if ($data['status'] == 1) {
                    Yii::$app->accessControl->addGroupToRole($data['role'], $data['group']);
                    return true;
                }

                if ($data['status'] == 0) {
                    Yii::$app->accessControl->deleteGroupToRole($data['role'], $data['group']);
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Список роутов группы
     *
     * @param $name
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionRouteList($name)
    {
        $group = Yii::$app->authManager->getPermission($name);
        $list = Yii::$app->authManager->getChildren($name);
        if ($list === null) throw new NotFoundHttpException();

        return $this->render('route-list', ['list' => $list, 'group' => $group]);
    }

    /**
     * Удаление роута из группы
     *
     * @param $name
     * @param $group
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionRemoveRoute($name, $group)
    {
        Yii::$app->accessControl->deleteRouteToGroup($name, $group);
        return $this->actionRouteList($group);
    }
}