<?php

use cnd\core\components\Migration;

use cnd\admin\models\activerecords\Permission;

/**
 * Class m190124_144958_remove_cms_permissions
 */
class m190124_144958_remove_cms_permissions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Permission::removeAdminPermissions($this->routes);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190124_144958_remove_cms_permissions cannot be reverted.\n";

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

            '/cms/category/index' => 'View categories list',
            '/cms/category/manage' => 'Add/Edit categories',
            '/cms/category/delete' => 'Delete categories',
            '/cms/content/index' => 'View contents list',
            '/cms/content/manage' => 'Add/Edit contents',
            '/cms/content/delete' => 'Delete contents',
            '/cms/content/view' => 'View contents',
            '/cms/content/status' => 'Change contents status',
            '/cms/content/duplicate' => 'Duplicate contents',
            '/cms/id/index' => 'View static id',
            '/cms/id/save' => 'Save static id',
            '/cms/id/delete' => 'Delete static id',
            '/cms/tag/index' => 'View tags list',
            '/cms/tag/manage' => 'Add/Edit tags',
            '/cms/tag/delete' => 'Delete tags',
            '/cms/tag/search' => 'Search tags',
            '/cms/tag/add' => 'Add tags',

            '/cms/category/view' => 'View category contents',
            '/cms/content/position' => 'Change contents position',
            '/cms/tag/view' => 'View tag contents',

            '/cms/gallery/index' => 'Show Advanced Gallery List',
            '/cms/gallery/manage' => 'Add/Edit Advanced Gallery',
            '/cms/gallery/delete' => 'Delete Advanced Gallery',
            '/cms/gallery/media' => 'Show Items of Advanced Gallery',
            '/cms/gallery/save-item' => 'Save Advanced Gallery Item',
            '/cms/gallery/delete-item' => 'Delete Advanced Gallery Item',
        ];
    }
}
