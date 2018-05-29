<?php

/** @var boolean $isCreate */
$this->title = (!is_array($permissions) && $permissions->systemName != '') ? 'Группа - ' . $permissions->systemName : 'Новая группа разрешений';

$this->params['breadcrumbs'][] = ['label' => 'RBAC', 'url' => ['/roles']];
$this->params['breadcrumbs'][] = $this->title;
echo $this->render('group_form', ['permissions' => $permissions, 'isCreate' => $isCreate]);