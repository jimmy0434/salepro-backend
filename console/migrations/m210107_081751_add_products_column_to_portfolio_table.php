<?php

use yii\db\Migration;

/**
 * Handles adding products to table `{{%portfolio}}`.
 */
class m210107_081751_add_products_column_to_portfolio_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%portfolio}}', 'specifications',  $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'));
        $this->addColumn('{{%portfolio}}', 'applications',  $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'));
        $this->addColumn('{{%portfolio}}', 'knowas',  $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext'));
        $this->addColumn('{{%portfolio}}', 'imageinside',  $this->getDb()->getSchema()->createColumnSchemaBuilder('mediumtext'));
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%portfolio}}', 'specifications');
        $this->dropColumn('{{%portfolio}}', 'applications');
        $this->dropColumn('{{%portfolio}}', 'knowas');
        $this->dropColumn('{{%portfolio}}', 'imageinside');
    }
}
