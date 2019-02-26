<?php

use cnd\core\components\Migration;
use cnd\admin\models\activerecords\Permission;

/**
 * Class m190226_101037_admin_permissions
 */
class m190226_101037_admin_permissions extends Migration
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
            '/sustainability/index' => 'Show Sustainability List',
            '/sustainability/manage' => 'Add/Edit Sustainability',
            '/sustainability/delete' => 'Delete Sustainability',

            '/logistic/index' => 'Show Logistics List',
            '/logistic/manage' => 'Add/Edit Logistic',
            '/logistic/delete' => 'Delete Logistic',

            '/logistic-category/index' => 'Show Logistics Category List',
            '/logistic-category/manage' => 'Add/Edit Logistic Category',
            '/logistic-category/delete' => 'Delete Logistic Category',
        ];
    }
}
