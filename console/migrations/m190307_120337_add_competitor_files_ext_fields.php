<?php

use cnd\core\components\Migration;

/**
 * Class m190307_120337_add_competitor_files_ext_fields
 */
class m190307_120337_add_competitor_files_ext_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%competitor}}','logo_ext',$this->string());
        $this->addColumn('{{%competitor}}','file_ext',$this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190307_120337_add_competitor_files_ext_fields cannot be reverted.\n";

        return false;
    }
}
