<?php

use cnd\core\components\Migration;
use cnd\admin\models\activerecords\Permission;

/**
 * Class m190527_091003_add_delete_competitor_permission
 */
class m190527_091003_add_delete_competitor_permission extends Migration
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
          '/competition/delete' => 'Delete Competitor',
      ];
  }
}
