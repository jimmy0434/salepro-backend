<?php

use cnd\core\components\Migration;

/**
 * Class m181130_083723_add_approval_process_tables
 */
class m181130_083723_add_approval_process_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('role_approval',[
            'id' => 'INT(11) NOT NULL primary key',
            'type' => $this->tinyInteger(),
        ]);

        $this->createTable('role_approval_user',[
            'id' => $this->primaryKey(),
            'role_approval_id' => $this->integer(),
            'user_id' => $this->integer(),
        ]);

        $this->createTable('form_approval',[
            'id' => $this->primaryKey(),
            'role_approval_id' => $this->integer(),
            'form_id' => $this->integer(),
            'type' => $this->tinyInteger(),
            'status' => $this->tinyInteger(),
        ]);

        $this->createTable('form_approval_user',[
            'id' => $this->primaryKey(),
            'form_approval_id' => $this->integer(),
            'user_id' => $this->integer(),
            'status' => $this->tinyInteger(),
        ]);

        $this->addRelations(function(){
            $this->createIndexForeignKey('role_approval.id','base_role.id');
            $this->createIndexForeignKey('role_approval_user.role_approval_id','role_approval.id');
            $this->createIndexForeignKey('role_approval_user.user_id','base_user.id');
            $this->createIndexForeignKey('form_approval.role_approval_id','role_approval.id');
            $this->createIndexForeignKey('form_approval.form_id','form.id');
            $this->createIndexForeignKey('form_approval_user.form_approval_id','form_approval.id');
            $this->createIndexForeignKey('form_approval_user.user_id','base_user.id');
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181130_083723_add_approval_process_tables cannot be reverted.\n";

        return false;
    }
}
