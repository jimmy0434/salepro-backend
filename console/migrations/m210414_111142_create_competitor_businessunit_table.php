<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%competitor_businessunit}}`.
 */
class m210414_111142_create_competitor_businessunit_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%competitor_businessunit}}', [
            'id' => $this->primaryKey(),
            'competitor_id' => $this->integer(),
            'value' => $this->integer(),
            'created_at'=>
            $this->integer()->defaultValue(null),
            'updated_at'=>
            $this->integer()->defaultValue(null)

        ]);
      

        $this->addForeignKey(
            'competitor_id_bu',
           
            '{{%competitor_businessunit}}',
            'competitor_id',
            '{{%competitor}}',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'business_unit_bu',
           
            '{{%competitor_businessunit}}',
            'value',
            '{{%business_unit}}',
            'id',
            'CASCADE'
        );
    
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%competitor_businessunit}}');
    }
}
