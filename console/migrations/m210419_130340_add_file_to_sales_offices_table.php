<?php

use yii\db\Migration;

/**
 * Class m210419_130340_add_file_to_sales_offices_table
 */
class m210419_130340_add_file_to_sales_offices_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%sales_office}}', 'file_id',  $this->integer());
        $this->addForeignKey(
            'sale_offic_file',
           
            '{{%sales_office}}',
            'file_id',
            '{{%file}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210419_130340_add_file_to_sales_offices_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210419_130340_add_file_to_sales_offices_table cannot be reverted.\n";

        return false;
    }
    */
}
