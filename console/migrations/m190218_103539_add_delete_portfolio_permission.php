<?php

use cnd\core\components\Migration;
use cnd\admin\models\activerecords\Permission;

/**
 * Class m190218_103539_add_delete_portfolio_permission
 */
class m190218_103539_add_delete_portfolio_permission extends Migration
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

    public function getRoutes(){
        return [
            '/portfolio/delete' => 'Delete Portfolio',
        ];
    }
}
