<?php

use yii\db\Migration;

/**
 * Class m210427_122625_change_URL_type_in
 */
class m210427_122625_change_URL_type_in extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%exhibition}}', 'url', 'text');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210427_122625_change_URL_type_in cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210427_122625_change_URL_type_in cannot be reverted.\n";

        return false;
    }
    */
}
