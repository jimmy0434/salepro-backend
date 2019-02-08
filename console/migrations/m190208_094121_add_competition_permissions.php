<?php

use cnd\core\components\Migration;
use cnd\admin\models\activerecords\Permission;

/**
 * Class m190208_094121_add_competition_permissions
 */
class m190208_094121_add_competition_permissions extends Migration
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
            '/competition/index' => 'Show Competitions Profiles List',
            '/competition/view' => 'Show Competition Profile Page',
        ];
    }
}
