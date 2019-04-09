<?php

use cnd\core\components\Migration;

/**
 * Class m190409_060615_add_salesman_extra_fields
 */
class m190409_060615_add_salesman_extra_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%salesman}}','first_name', $this->string());
        $this->addColumn('{{%salesman}}','last_name', $this->string());
        $this->addColumn('{{%salesman}}','dob', $this->date());
        $this->addColumn('{{%salesman}}','gender', 'enum("male","female")');
        $this->addColumn('{{%salesman}}','city', $this->string());
        $this->addColumn('{{%salesman}}','address', $this->text());
        $this->addColumn('{{%salesman}}','phone', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190409_060615_add_salesman_extra_fields cannot be reverted.\n";

        return false;
    }
}
