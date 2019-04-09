<?php

use cnd\core\components\Migration;
use cnd\admin\models\activerecords\Permission;

/**
 * Class m190409_131034_add_custom_notification_permission
 */
class m190409_131034_add_custom_notification_permission extends Migration
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
            '/custom-notification/index' => 'Custom Notification Panel',
        ];
    }
}
