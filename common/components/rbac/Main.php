<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 25.04.2016
 * Time: 10:20
 */

namespace common\components\rbac;

use yii;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseInflector;
use common\helpers\CirilicTranslit;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use yii\rbac\Role;

/**
 * Class Main
 * @package common\components\rbac
 */
class Main extends Component
{
    /**
     * @const
     */
    const ROLE_ROOT = 'admin';

    /**
     * @const
     */
    const ROLE_GUEST = 'guest';

    /**
     * @const
     */
    const GROUP_PERMISSION_PREFIX = 'GR';

    /**
     * @const
     */
    const ROUTE_PERMISSION_PREFIX = 'RT';

    /**
     * @var array
     */
    public $branches = [];

    /**
     *
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @param $branchId
     * @return bool
     *
     * Проверка доступа к текущему роуту
     */
    public function control($branchId)
    {
        $role = self::ROLE_GUEST;

        if (Yii::$app->user->id == 1) {
            return true;
        }

        if (!Yii::$app->user->isGuest) {
            $role = key(Yii::$app->authManager->getRolesByUser(Yii::$app->user->id));
        }

        return ArrayHelper::keyExists($this->parseRoute(Yii::$app->controller->id . '/' . Yii::$app->requestedAction->id, $branchId), Yii::$app->authManager->getPermissionsByRole($role));
    }

    /**
     * @param $roles
     * @return bool
     * @throws \Exception
     */
    public function addRoles($roles)
    {
        foreach ($roles as $role_) {
            $role = Yii::$app->authManager->createRole($role_->name);
            $role->description = $role_->description;
            Yii::$app->authManager->add($role);
        }
        return true;
    }

    /**
     * Изменить описание роли
     *
     * @param $name
     * @param $description
     * @return bool
     * @throws \Exception
     */
    public function editRole($name, $description)
    {
        $role = Yii::$app->authManager->createRole($name);
        $role->description = $description;

        Yii::$app->authManager->update($name, $role);
        return true;
    }

    /**
     * @param $name
     * Удалить Роль по имени
     */
    public function deleteRole($name)
    {
        $role = Yii::$app->authManager->getRole($name);
        Yii::$app->authManager->remove($role);
    }

    /**
     * @param $name
     * @return null|Role
     * Получить Роль по имени
     */
    public function getRole($name)
    {
        return Yii::$app->authManager->getRole($name);
    }

    /**
     * @return Role[]
     * Получить все роли
     */
    public function getRoles()
    {
        $roles = Yii::$app->authManager->getRoles();
        return $roles;
    }

    /**
     * @param $userId
     * @param $roleName
     * @throws \Exception
     */
    public function changeUserRole($userId, $roleName)
    {
        // Получаем роли пользователя
        $userRoles = Yii::$app->authManager->getRolesByUser($userId);

        // Если переданая роль новая
        if (!isset($userRoles[$roleName])) {

            // Получаем обект роли
            $role = $this->getRole($roleName);

            // Удаляем старую роль
            Yii::$app->authManager->revoke(array_shift($userRoles), $userId);

            // Добавляем новую
            Yii::$app->authManager->assign($role, $userId);
        }

    }

    /**
     * @param $permisions
     * @return bool
     * @throws \Exception
     */
    public function addGroupPermissions($permisions)
    {
        foreach ($permisions as $permision) {
            $name = $this->uniqNamePermission($permision->systemName, self::GROUP_PERMISSION_PREFIX);
            $permission = Yii::$app->authManager->createPermission($name);
            $permission->description = $permision->systemName;

            Yii::$app->authManager->add($permission);
        }
        return true;
    }

    /**
     * @param $description
     * @throws \Exception
     */
    public function addGroupPermission($description)
    {
        $name = $this->uniqNamePermission($description, self::GROUP_PERMISSION_PREFIX);
        $permission = Yii::$app->authManager->createPermission($name);
        $permission->description = $description;

        Yii::$app->authManager->add($permission);
    }

    /**
     * @param $description
     * @param $prefix
     * @return mixed|string
     */
    public function uniqNamePermission($description, $prefix)
    {
        $name = CirilicTranslit::strictLowCaseTranslit($description, 58);
        $name = $prefix . $name;

        // Проверяем на уникальность, добавляем номер
        $ind = 0;
        while (Yii::$app->authManager->getPermission($name) != null) {
            $ind++;
            $name = $name . $ind;
        }

        return $name;
    }

    /**
     * @param $name
     * @param $description
     * Изменить описание групы разрешений
     * @throws \Exception
     */
    public function editGroupPermission($name, $description)
    {
        $permission = Yii::$app->authManager->createPermission($name);
        $permission->description = $description;

        Yii::$app->authManager->update($name, $permission);
    }

    /**
     * @param $name
     * Удалить групу разрешений по имени
     */
    public function deleteGroupPermission($name)
    {
        $permission = Yii::$app->authManager->getPermission($name);
        Yii::$app->authManager->remove($permission);
    }

    /**
     * @param $name
     * @return null|yii\rbac\Permission
     */
    public function getGroupPermission($name)
    {
        return Yii::$app->authManager->getPermission($name);
    }

    /**
     * @return array
     */
    public function getAllGroupPermission()
    {
        $list = Yii::$app->authManager->getPermissions();
        $out = [];
        foreach ($list as $key => $item) {
            if (substr($item->name, 0, 2) == self::GROUP_PERMISSION_PREFIX) {
                $out[$key] = $item;
            }
        }
        return $out;
    }

    /**
     * @param $role
     * @param $group
     * @throws yii\base\Exception
     */
    public function addGroupToRole($role, $group)
    {
        $role = Yii::$app->authManager->getRole($role);
        $group = Yii::$app->authManager->getPermission($group);
        Yii::$app->authManager->addChild($role, $group);
    }

    /**
     * @param $role
     * @param $group
     * Удаление групы из роли
     */
    public function deleteGroupToRole($role, $group)
    {
        $role = Yii::$app->authManager->getRole($role);
        $group = Yii::$app->authManager->getPermission($group);
        Yii::$app->authManager->removeChild($role, $group);
    }

    /**
     * @param $route
     * @param $branchId
     * @return null|string
     * @throws \Exception
     */
    public function addRoutePermission($route, $branchId)
    {
        if (isset($this->branches[$branchId])) {
            $permission = Yii::$app->authManager->createPermission($this->parseRoute($route, $branchId));
            Yii::$app->authManager->add($permission);
            return $this->parseRoute($route, $branchId);
        }

        return null;
    }

    /**
     * Генерация внутренего представления роута
     *
     * @param $route
     * @param $branchId
     * @return string
     */
    private function parseRoute($route, $branchId)
    {
        return static::ROUTE_PERMISSION_PREFIX . $this->branches[$branchId][0] . '/' . $route;
    }

    /**
     * Парсинг внутренего представления роута
     *
     * @param $route
     * @return array
     */
    public function unParseRoute($route)
    {
        $return = ['branch' => '', 'rout' => $route];
        foreach ($this->branches as $item) {
            $prefix = substr($route, 0, 3);
            if ($prefix == static::ROUTE_PERMISSION_PREFIX . $item[0]) {
                $return['branch'] = $item[2];
                $return['rout'] = str_replace(static::ROUTE_PERMISSION_PREFIX . $item[0], '', $route);
            }
        }
        return $return;
    }

    /**
     * @param $route
     * @param $group
     * @throws yii\base\Exception
     */
    public function addRouteToGroup($route, $group)
    {
        $route = Yii::$app->authManager->getPermission($route);
        $group = Yii::$app->authManager->getPermission($group);
        Yii::$app->authManager->addChild($group, $route);
    }

    /**
     * Удаление роута из групы
     *
     * @param $route
     * @param $group
     */
    public function deleteRouteToGroup($route, $group)
    {
        $route = Yii::$app->authManager->getPermission($route);
        $group = Yii::$app->authManager->getPermission($group);

        Yii::$app->authManager->removeChild($group, $route);
        Yii::$app->authManager->remove($route);
    }

    /**
     * Сканирование контролеров
     *
     * @param $controllerPath
     * @param $branchId
     * @return array
     */
    public function scanNewMethod($controllerPath, $branchId)
    {
        $path = $controllerPath;
        $list = [];

        $dir = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
        foreach ($dir as $name => $object) {
            // Проверка или файл
            if ($object->isFile()) {
                // Проверка или PHP
                if (strtolower($object->getExtension()) == 'php') {

                    // определяем локальное пространство имен контролера (роут)
                    $space = str_replace($path, '', $name);
                    $space = $this->spaceConvertCamel2id($space);

                    // парсим файл, поиск методов
                    $file = file_get_contents($name);
                    preg_match_all('|public\s+function\s+action([A-Za-z0-9-_]+)|', $file, $match);
                    if (isset($match[1])) {

                        // проверка методов
                        foreach ($match[1] as $item) {
                            if ($item != 's') {
                                $route = $space . '/' . yii\helpers\BaseInflector::camel2id($item);

                                // проверка на существования правил
                                if (Yii::$app->authManager->getPermission($this->parseRoute($route, $branchId)) == null) {
                                    $list[] = $route;
                                }
                            }
                        }
                        // проверка подключаемых методов  actions()
                        $actions = $this->parseDynamicActions($file);
                        foreach ($actions as $item) {
                            $route = $space . '/' . yii\helpers\BaseInflector::camel2id($item);
                            // проверка на существования правил
                            if (Yii::$app->authManager->getPermission($this->parseRoute($route, $branchId)) == null) {
                                $list[] = $route;
                            }
                        }
                    }
                }
            }
        }

        return $list;
    }

    /**
     * @param $space
     * @return bool|mixed|string
     */
    private function spaceConvertCamel2id($space)
    {
        // определяем локальное пространство имен контролера (роут)
        $space = str_replace('\\', '/', $space);
        $space = str_replace('Controller.php', '', $space);
        $space = substr($space, 1);

        $arr = explode('/', $space);
        foreach ($arr as $key => $item) {

            $arr[$key] = BaseInflector::underscore($item);
            $arr[$key] = str_replace('_', '-', $arr[$key]);

        }

        $space = implode('/', $arr);

        return $space;
    }

    /**
     * @param string $text
     * @return array
     */
    private function parseDynamicActions($text)
    {
        $action = [];
        if (preg_match('|public\s+function\s+actions\(\s*\)\s*{(.*)return(.+);|Ums', $text, $match)) {
            $actionsArray = eval('return ' . $match[2] . ';');
            if (is_array($actionsArray)) {
                foreach ($actionsArray as $k => $v) $action[] = $k;
            }
        }
        return $action;
    }
}