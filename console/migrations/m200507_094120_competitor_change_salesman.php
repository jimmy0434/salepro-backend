<?php

use cnd\core\components\Migration;
use cnd\admin\models\activerecords\Permission;

/**
 * Class m200507_094120_competitor_change_salesman
 */
class m200507_094120_competitor_change_salesman extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Permission::adminPermissions($this->routes);

        $this->insert('{{%base_role_permission}}', [
            'role_id' => '1',
            'permission_id' => Yii::$app->db->createCommand("SELECT `id` FROM `mpk_base_permission` WHERE `name` = '/competition/salesman'")->queryOne()['id'],
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Permission::removeAdminPermissions($this->routes);

        $this->delete('{{%base_role_permission}}', [
            'role_id' => '1',
            'permission_id' => Yii::$app->db->createCommand("SELECT `id` FROM `mpk_base_permission` WHERE `name` = '/competition/salesman'")->queryOne()['id'],
        ]);

        return true;
    }

    public function getRoutes(){
        return [
            '/competition/salesman' => 'Change salesman for competitor',
        ];
    }
}
