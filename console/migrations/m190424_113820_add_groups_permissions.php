<?php

use cnd\core\components\Migration;
use cnd\admin\models\activerecords\Permission;

/**
 * Class m190424_113820_add_groups_permissions
 */
class m190424_113820_add_groups_permissions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Permission::adminPermissions($this->routes);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Permission::removeAdminPermissions($this->routes);
        return false;
    }

    public function getRoutes()
    {
        return [
            '/group/index' => 'Show Groups List',
            '/group/manage' => 'Add/Edit Group',
            '/group/delete' => 'Delete Group',
            '/salesman/change-group' => 'Change Salesman Group',
        ];
    }
}
