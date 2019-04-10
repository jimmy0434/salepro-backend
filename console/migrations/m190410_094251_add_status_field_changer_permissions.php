<?php

use cnd\core\components\Migration;
use cnd\admin\models\activerecords\Permission;

/**
 * Class m190410_094251_add_status_field_changer_permissions
 */
class m190410_094251_add_status_field_changer_permissions extends Migration
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
            '/competition/status' => 'Change competitor status',
            '/portfolio/status' => 'Change portfolio status',
        ];
    }
}
