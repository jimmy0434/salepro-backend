<?php

use yii\db\Migration;

/**
 * Class m210730_100229_Add_competitor_salesman_table
 */
class m210730_100229_Add_competitor_salesman_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%competitor_salesman}}', [
            'id' => $this->primaryKey(),
            'competitor_id' => $this->integer(),
            'value' => $this->integer(),
            'created_at'=>
            $this->integer()->defaultValue(null),
            'updated_at'=>
            $this->integer()->defaultValue(null)

        ]);
      

        $this->addForeignKey(
            'competitor_id_sl',
           
            '{{%competitor_salesman}}',
            'competitor_id',
            '{{%competitor}}',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'business_unit_sl',
           
            '{{%competitor_salesman}}',
            'value',
            '{{%salesman}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210730_100229_Add_competitor_salesman_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210730_100229_Add_competitor_salesman_table cannot be reverted.\n";

        return false;
    }
    */
}
