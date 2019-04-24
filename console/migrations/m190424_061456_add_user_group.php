<?php

use cnd\core\components\Migration;

/**
 * Class m190424_061456_add_user_group
 */
class m190424_061456_add_user_group extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('group', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);

        $this->addColumn('{{%base_user}}', 'group_id', $this->integer());

        $this->safeOperation(function () {
            $this->createIndexForeignKey('base_user.group_id', 'group.id', 'SET NULL');
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190424_061456_add_user_group cannot be reverted.\n";

        return false;
    }
}
