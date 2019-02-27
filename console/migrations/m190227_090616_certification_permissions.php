<?php

use cnd\core\components\Migration;
use cnd\admin\models\activerecords\Permission;

/**
 * Class m190227_090616_certification_permissions
 */
class m190227_090616_certification_permissions extends Migration
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
            '/certification/index' => 'Show Certifications List',
            '/certification/manage' => 'Add/Edit Certification',
            '/certification/delete' => 'Delete Certification',
            '/certification/find-certifications' => 'Autocomplete / Find Certification',
            '/certification/add-certification' => 'Autocomplete / Add Certification',
        ];
    }
}
