<?php

use yii\db\Migration;

/**
 * Class m220126_142009_add_sector_to_competitor_table
 */
class m220126_142009_add_sector_to_competitor_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%competitor}}', 'sector',  $this->string());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220126_142009_add_sector_to_competitor_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220126_142009_add_sector_to_competitor_table cannot be reverted.\n";

        return false;
    }
    */
}
