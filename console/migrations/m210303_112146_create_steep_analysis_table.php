<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%steep_analysis}}`.
 */
class m210303_112146_create_steep_analysis_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%steep_analysis}}', [
            'id' => $this->primaryKey(),
            'uid' => $this->string()->unique(),
            'name'=>$this->string(),
            'salesman_id'=> $this->integer(),
            'status'=> "ENUM('enabled', 'disabled') DEFAULT ('disabled')",
           
            'subsequent'=>$this->string(),
            'impact'=>$this->string(),
            'trend_status'=>$this->string(),
            'risk_category'=>$this->string(),
            'control_measure'=>$this->string(),

            'created_at'=>
            $this->integer()->defaultValue(null),
            'updated_at'=>
            $this->integer()->defaultValue(null)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%steep_analysis}}');
    }
}
