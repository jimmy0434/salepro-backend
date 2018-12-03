<?php

use cnd\core\components\Migration;

use cnd\admin\models\activerecords\Permission;

/**
 * Class m181203_121326_add_admin_permissions_of_masterpak_v1
 */
class m181203_121326_add_admin_permissions_of_masterpak_v1 extends Migration
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
            '/salesman/index' => 'View salesman list',
            '/salesman/manage' => 'Add/Edit salesman',
            '/salesman/delete' => 'Delete salesman',
            '/salesman/view' => 'View salesman',
            '/salesman/access-list' => 'View salesman Devices',
            '/salesman/api-access-log' => 'View salesman Restful Api Access Log',

            '/file/index' => 'View files list',
            '/file/manage-meta-data' => 'Add/Edit File',
            '/file/manage-upload' => 'Upload File',
            '/file/delete' => 'Delete File',
            '/file/download' => 'Download File',

            '/form/index' => 'View forms list',
            '/form/manage-meta-data' => 'Add/Edit Form',
            '/form/manage-structure' => 'Build Form',
            '/form/delete' => 'Delete Form',
            '/form/publish-request' => 'Publish Form Request (Review)',

            '/approval/role' => 'Create Approval Process',
            '/approval/find-user' => 'Approval Process Find User',

            '/form-approval/index' => 'Show Form Request Review List',
            '/form-approval/view' => 'Show Details form for review (accept/reject)',
            '/form-approval/response' => 'Show Response of form review (accept/reject)',
        ];
    }
}
