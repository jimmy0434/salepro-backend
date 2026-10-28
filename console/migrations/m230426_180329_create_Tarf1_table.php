<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%Tarf1}}`.
 */
class m230426_180329_create_Tarf1_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%Tarf1}}', [
            'id' => $this->primaryKey(),
            'uid' => $this->string()->unique(),
            'salesman_id'=> $this->integer(),
            'bu'=> $this->string(),
            'email'=> $this->string(),
            'type'=> $this->string(),
            'subject'=> $this->string(),
            'description'=> $this->text(),

            'sample_name_1'=> $this->string(),
            'sample_hs_code_1'=> $this->string(),
            'sample_type_1'=> $this->string(),
            'sample_specs_1'=> $this->string(),

            'sample_name_2'=> $this->string(),
            'sample_hs_code_2'=> $this->string(),
            'sample_type_2'=> $this->string(),
            'sample_specs_2'=> $this->string(),

            'sample_name_3'=> $this->string(),
            'sample_hs_code_3'=> $this->string(),
            'sample_type_3'=> $this->string(),
            'sample_specs_3'=> $this->string(),

            'sample_name_4'=> $this->string(),
            'sample_hs_code_4'=> $this->string(),
            'sample_type_4'=> $this->string(),
            'sample_specs_4'=> $this->string(),

            
            'approved'=> "ENUM('yes', 'no') DEFAULT ('no')",





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
        $this->dropTable('{{%Tarf1}}');
    }
}
