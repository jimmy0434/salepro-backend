<?php

use cnd\core\components\Migration;

/**
 * Class m181108_141859_add_files_tables
 */
class m181108_141859_add_files_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('file',[
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'version' => $this->string(50),
            'extension' => $this->string(20),
            'status' => $this->tinyInteger(),
        ]);

        $this->createTable('file_partition',[
            'id' => $this->primaryKey(),
            'file_id' => $this->integer(),
            'version' => $this->string(50),
            'order' => $this->integer(),
            'extension' => $this->string(20),
            'data' => 'MEDIUMBLOB',
        ]);

        $this->addRelations(function(){
            $this->createIndexForeignKey('file_partition.file_id', 'file.id');
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181108_141859_add_files_tables cannot be reverted.\n";

        return false;
    }
}
