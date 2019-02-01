<?php

use cnd\core\components\Migration;
use cnd\admin\models\activerecords\Permission;

/**
 * Class m190201_064553_add_portfolio_admin_permissions
 */
class m190201_064553_add_portfolio_admin_permissions extends Migration
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
            '/portfolio/index' => 'Portfolio List',
            '/portfolio/manage' => 'Add/Edit Portfolio',
            '/portfolio/find-sectors' => 'Autocomplete / Find Sectors',
            '/portfolio/find-brands' => 'Autocomplete / Find Brands',
            '/portfolio/find-products' => 'Autocomplete / Find Products',
            '/portfolio/add-sector' => 'Autocomplete / Add Sector',
            '/portfolio/add-brand' => 'Autocomplete / Add Brand',
            '/portfolio/add-product' => 'Autocomplete / Add Product',
            '/portfolio/find-business-unit' => 'Autocomplete / Find Business Unit',
            '/portfolio/add-business-unit' => 'Autocomplete / Add Business Unit',

            '/search/find-tags' => 'Autocomplete / Find Search Tags',
            '/search/add-tag' => 'Autocomplete / Add Search Tag',

            '/market-research/index' => 'Market Research List',
            '/market-research/manage' => 'Add/Edit Market Research',
            '/market-research/delete' => 'Delete Market Research',

            '/exhibition/index' => 'Exhibition List',
            '/exhibition/manage' => 'Add/Edit Exhibition',
            '/exhibition/delete' => 'Delete Exhibition',

            '/business-unit/index' => 'Business Unit List',
            '/business-unit/manage' => 'Add/Edit Business Unit',
            '/business-unit/delete' => 'Delete Business Unit',
        ];
    }
}
