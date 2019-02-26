<?php

use cnd\core\components\Migration;

/**
 * Class m190226_084430_sale_office_region_and_product_bu_relation
 */
class m190226_084430_sale_office_region_and_product_bu_relation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%sales_office}}', 'region', $this->string());

        $this->createTable('product_business_unit', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'business_unit_id' => $this->integer(),
        ]);

        $this->safeOperation(function(){
            $this->createIndexForeignKey('product_business_unit.product_id','product.id');
            $this->createIndexForeignKey('product_business_unit.business_unit_id','business_unit.id');
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190226_084430_sale_office_region_and_product_bu_relation cannot be reverted.\n";

        return false;
    }
}
