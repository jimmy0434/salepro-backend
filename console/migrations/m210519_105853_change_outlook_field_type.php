<?php

use yii\db\Migration;

/**
 * Class m210519_105853_change_outlook_field_type
 */
class m210519_105853_change_outlook_field_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%sector_outlook}}', 'outlook', 'text');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210519_105853_change_outlook_field_type cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210519_105853_change_outlook_field_type cannot be reverted.\n";

        return false;
    }
    */
}
