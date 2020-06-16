<?php

use cnd\core\components\Migration;
use cnd\admin\models\activerecords\Permission;


/**
 * Class m200523_184513_add_send_refresh_permission
 */
class m200523_184513_add_send_refresh_permission extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Permission::adminPermissions($this->routes);

        $this->insert('{{%base_role_permission}}', [
            'role_id' => '1',
            'permission_id' => Yii::$app->db->createCommand("SELECT `id` FROM `mpk_base_permission` WHERE `name` = '/salesman/notify'")->queryOne()['id'],
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
            'permission_id' => Yii::$app->db->createCommand("SELECT `id` FROM `mpk_base_permission` WHERE `name` = 'salesman/notify'")->queryOne()['id'],
        ]);

        return true;
    }

    public function getRoutes(){
        return [
            '/salesman/notify' => 'Notify App to refresh',
        ];
    }
}
