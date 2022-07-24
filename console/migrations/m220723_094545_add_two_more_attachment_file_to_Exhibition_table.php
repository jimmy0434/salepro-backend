<?php

use yii\db\Migration;

/**
 * Class m220723_094545_add_two_more_attachment_file_to_Exhibition_table
 */
class m220723_094545_add_two_more_attachment_file_to_Exhibition_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%exhibition}}', 'file_id_2',  $this->integer());
        $this->addColumn('{{%exhibition}}', 'file_id_3',  $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220723_094545_add_two_more_attachment_file_to_Exhibition_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220723_094545_add_two_more_attachment_file_to_Exhibition_table cannot be reverted.\n";

        return false;
    }
    */
}
