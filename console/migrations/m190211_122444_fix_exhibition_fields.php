<?php

use cnd\core\components\Migration;

/**
 * Class m190211_122444_fix_exhibition_fields
 */
class m190211_122444_fix_exhibition_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->safeOperation(function () {
            $this->removeIndexForeignKey('exhibition.file_id');
            $this->removeIndexForeignKey('exhibition_product.exhibition_id');
            $this->removeIndexForeignKey('exhibition_product.product_id');
            $this->dropTable('{{%exhibition_product}}');
            $this->dropColumn('{{%exhibition}}', 'file_id');

            $this->addColumn('{{%exhibition}}', 'city', $this->string());
            $this->addColumn('{{%exhibition}}', 'venue', $this->string());
            $this->addColumn('{{%exhibition}}', 'edition', $this->string());
            $this->addColumn('{{%exhibition}}', 'frequency', $this->string());
            $this->addColumn('{{%exhibition}}', 'url', $this->string());
            $this->addColumn('{{%exhibition}}', 'description', $this->longText());

            $this->addColumn('{{%portfolio}}', 'linkedin', $this->text());
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190211_122444_fix_exhibition_fields cannot be reverted.\n";

        return false;
    }
}
