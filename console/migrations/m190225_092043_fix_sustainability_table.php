<?php

use cnd\core\components\Migration;

/**
 * Class m190225_092043_fix_sustainability_table
 */
class m190225_092043_fix_sustainability_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->safeOperation(function(){
            $this->removeIndexForeignKey('sustainability.power_point');
            $this->removeIndexForeignKey('sustainability.brochure');
            $this->removeIndexForeignKey('sustainability.video');

            $this->dropColumn('{{%sustainability}}','power_point');
            $this->dropColumn('{{%sustainability}}','brochure');
            $this->dropColumn('{{%sustainability}}','video');
            $this->dropColumn('{{%sustainability}}','url');

            $this->addColumn('{{%sustainability}}','file_id', $this->integer());
            $this->addColumn('{{%sustainability}}','position', $this->integer());
            $this->addColumn('{{%sustainability}}','type', 'enum("download","environmental","social_responsibility")');

            $this->createIndexForeignKey('sustainability.file_id','file.id');
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190225_092043_fix_sustainability_table cannot be reverted.\n";

        return false;
    }
}
