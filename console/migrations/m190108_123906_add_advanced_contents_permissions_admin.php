<?php

use cnd\core\components\Migration;

use cnd\admin\models\activerecords\Permission;

/**
 * Class m190108_123906_add_advanced_contents_permissions_admin
 */
class m190108_123906_add_advanced_contents_permissions_admin extends Migration
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
            '/content/index' => 'AC : Canvas',
            '/content/save-category' => 'AC : Add/Edit Category',
            '/content/upload-category-icon' => 'AC : Change Category Icon',
            '/content/list' => 'AC : Open Contents',
            '/content/upload-content-cover' => 'AC : Change Cover',
            '/content/manage' => 'AC : Edit Content',
            '/content/create' => 'AC : Add Content',
            '/content/rename-title' => 'AC : Rename Title',
            '/content/delete-content' => 'AC : Delete Content',
        ];
    }
}
