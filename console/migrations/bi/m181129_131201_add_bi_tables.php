<?php

use cnd\core\components\Migration;

/**
 * Class m181129_131201_add_bi_tables
 */
class m181129_131201_add_bi_tables extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //$this->db = Yii::$app->bi;
        $this->createTable('user', [
            "id" => $this->primaryKey(),
            "name" => $this->string(),
            "status" => $this->string(),
            "type" => $this->string(),
            "role_id" => $this->integer(),
        ]);

        $this->createTable('role', [
            "id" => $this->primaryKey(),
            "name" => $this->string(),
            "level" => $this->string(),
        ]);

        $this->addRelations(function(){
            $this->createIndexForeignKey('user.role_id','role.id','SET NULL');
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181129_131201_add_bi_tables cannot be reverted.\n";

        return false;
    }
}
