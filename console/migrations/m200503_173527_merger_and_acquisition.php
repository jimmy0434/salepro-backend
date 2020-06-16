<?php

use cnd\core\components\Migration;

/**
 * Class m200503_173527_merger_and_acquisition
 */
class m200503_173527_merger_and_acquisition extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%competitor}}', 'merger_company_name', $this->string());
        $this->addColumn('{{%competitor}}', 'merger_country', $this->text());
        $this->addColumn('{{%competitor}}', 'acquisition_company_name', $this->string());
        $this->addColumn('{{%competitor}}', 'acquisition_country', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%competitor}}', 'merger_company_name');
        $this->dropColumn('{{%competitor}}', 'merger_country');
        $this->dropColumn('{{%competitor}}', 'acquisition_company_name');
        $this->dropColumn('{{%competitor}}', 'acquisition_country');
        return false;
    }

}
