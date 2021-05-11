<?php

use yii\db\Migration;

/**
 * Class m210510_082945_add_business_unit_to_steep_and_sector_outlook
 */
class m210510_082945_add_business_unit_to_steep_and_sector_outlook extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%steep_analysis}}', 'business_unit_id',  $this->integer());
        $this->addForeignKey(
            'steep_BU',
           
            '{{%steep_analysis}}',
            'business_unit_id',
            '{{%business_unit}}',
            'id',
            'CASCADE'
        );
        $this->addColumn('{{%sector_outlook}}', 'business_unit_id',  $this->integer());
        $this->addForeignKey(
            'sector_outlook_BU',
           
            '{{%sector_outlook}}',
            'business_unit_id',
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
        echo "m210510_082945_add_business_unit_to_steep_and_sector_outlook cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210510_082945_add_business_unit_to_steep_and_sector_outlook cannot be reverted.\n";

        return false;
    }
    */
}
