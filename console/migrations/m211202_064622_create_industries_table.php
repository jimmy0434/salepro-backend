<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%industries}}`.
 */
class m211202_064622_create_industries_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {  $this->createTable('industries',[
        'id' => $this->primaryKey(),
        'uid' => $this->string()->unique(),
        'portfolio_id' => $this->integer(),
    ]);

$this->createTable('product_industries', [
        'id' => $this->primaryKey(),
        'product_id' => $this->integer(),
        'industries_id' => $this->integer(),
    ]);


    $this->createTable('industries_sector', [
        'id' => $this->primaryKey(),
        'industries_id' => $this->integer(),
        'sector_id' => $this->integer(),
    ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%industries}}');
    }
}
