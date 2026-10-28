<?php


use cnd\core\components\Migration;

/**
 * Class m240821_181435_add_fields_to_competitors_table
 */
class m240821_181435_add_fields_to_competitors_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%competitor}}', 'city', $this->text());
        $this->addColumn('{{%competitor}}', 'number_of_factories', $this->text());
        $this->addColumn('{{%competitor}}', 'installed_capacities', $this->text());
        $this->addColumn('{{%competitor}}', 'sales_volumes', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%competitor}}', 'city');
        $this->dropColumn('{{%competitor}}', 'number_of_factories');
        $this->dropColumn('{{%competitor}}', 'installed_capacities');
        $this->dropColumn('{{%competitor}}', 'sales_volumes');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240821_181435_add_fields_to_competitors_table cannot be reverted.\n";

        return false;
    }
    */
}
