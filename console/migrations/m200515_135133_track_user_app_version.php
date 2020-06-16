<?php

use cnd\core\components\Migration;

/**
 * Class m200515_135133_track_user_app_version
 */
class m200515_135133_track_user_app_version extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%salesman}}', 'app_version', $this->string());
        $this->addColumn('{{%salesman}}', 'last_access_date', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('{{%salesman}}', 'app_version');
       $this->dropColumn('{{%salesman}}', 'last_access_date');
       return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200515_135133_track_user_app_version cannot be reverted.\n";

        return false;
    }
    */
}
