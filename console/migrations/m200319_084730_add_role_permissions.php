<?php

use cnd\core\components\Migration;

/**
 * Class m200306_131319_add_role_permission
 */
class m200319_084730_add_role_permissions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // '{{%base_role_permission}}'
        $this->insert('{{%base_role_permission}}', [
            'role_id' => '1',
            'permission_id' => '76', // /market-research/delete
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%base_role_permission}}', [
            'role_id' => '1',
            'permission_id' => '79', // /exhibition/delete
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%base_role_permission}}', [
            'role_id' => '1',
            'permission_id' => '96', // /sales-office/delete
            'created_at' => time(),
            'updated_at' => time(),
        ]);

         $this->insert('{{%base_role_permission}}', [
            'role_id' => '1',
            'permission_id' => '105', // /sustainability/delete
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%base_role_permission}}', [
            'role_id' => '1',
            'permission_id' => '108', // /logistic/delete
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%base_role_permission}}', [
            'role_id' => '1',
            'permission_id' => '111', // /logistic-category/delete
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%base_role_permission}}', [
            'role_id' => '1',
            'permission_id' => '114', // /logistic-category/delete
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%base_role_permission}}', [
            'role_id' => '1',
            'permission_id' => '76',
        ]);

        $this->delete('{{%base_role_permission}}', [
            'role_id' => '1',
            'permission_id' => '79', 
        ]);

        $this->delete('{{%base_role_permission}}', [
            'role_id' => '1',
            'permission_id' => '96',
        ]);

        $this->delete('{{%base_role_permission}}', [
            'role_id' => '1',
            'permission_id' => '105',
        ]);

        $this->delete('{{%base_role_permission}}', [
            'role_id' => '1',
            'permission_id' => '108',
        ]);

        $this->delete('{{%base_role_permission}}', [
            'role_id' => '1',
            'permission_id' => '111',
        ]);

        $this->delete('{{%base_role_permission}}', [
            'role_id' => '1',
            'permission_id' => '114', 
        ]);

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200306_131319_add_role_permission cannot be reverted.\n";

        return false;
    }
    */
}
