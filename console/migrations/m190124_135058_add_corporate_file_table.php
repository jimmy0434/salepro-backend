<?php

use cnd\core\components\Migration;

/**
 * Class m190124_135058_add_corporate_file_table
 */
class m190124_135058_add_corporate_file_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('corporate_file', [
            'id' => $this->primaryKey(),
            'corporate_id' => $this->integer(),
            'file_id' => $this->integer(),
        ]);

        $this->addRelations(function(){
            $this->createIndexForeignKey('corporate_file.corporate_id','corporate.id');
            $this->createIndexForeignKey('corporate_file.file_id','file.id');
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190124_135058_add_corporate_file_table cannot be reverted.\n";

        return false;
    }
}
