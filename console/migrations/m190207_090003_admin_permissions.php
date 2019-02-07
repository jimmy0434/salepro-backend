<?php

use cnd\core\components\Migration;
use cnd\admin\models\activerecords\Permission;

/**
 * Class m190207_090003_admin_permissions
 */
class m190207_090003_admin_permissions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Permission::removeAdminPermissions([
            '/business-unit/index' => 'Business Unit List',
            '/business-unit/manage' => 'Add/Edit Business Unit',
            '/business-unit/delete' => 'Delete Business Unit',
        ]);
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
            '/portfolio/find-business-unit' => 'Autocomplete / Find Business Unit',
            '/portfolio/add-business-unit' => 'Autocomplete / Add Business Unit',

            '/data-list/index' => 'Show Data List Items',
            '/data-list/manage' => 'Add/Edit Data List Item',
            '/data-list/delete' => 'Delete Data List Item',

            '/statistic-number/index' => 'Statistic Numbers List',
            '/statistic-number/save' => 'Save Statistic Numbers',

            '/product-details/index' => 'Show Product Details List',
            '/product-details/manage' => 'Add/Edit Product Detail',
            '/product-details/delete' => 'Delete Product Detail',

            '/product-details-item/index' => 'Show Product Details Items List',
            '/product-details-item/manage' => 'Add/Edit Product Detail Item',
            '/product-details-item/delete' => 'Delete Product Detail Item',

            '/sales-office/index' => 'Show Sales Offices List',
            '/sales-office/manage' => 'Add/Edit Sales Office',
            '/sales-office/delete' => 'Delete Sales Office',
            '/sales-office/find-offices' => 'Autocomplete / Find Sales Offices',
            '/sales-office/add-office' => 'Autocomplete / Add Sales Office',
        ];
    }
}
