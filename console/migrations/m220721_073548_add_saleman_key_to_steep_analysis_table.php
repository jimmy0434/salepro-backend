<?php

use yii\db\Migration;

/**
 * Class m220721_073548_add_saleman_key_to_steep_analysis_table
 */
class m220721_073548_add_saleman_key_to_steep_analysis_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'salemanidd',
           
            '{{%steep_analysis}}',
            'salesman_id',
            '{{%base_user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220721_073548_add_saleman_key_to_steep_analysis_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220721_073548_add_saleman_key_to_steep_analysis_table cannot be reverted.\n";

        return false;
    }
    */
}
