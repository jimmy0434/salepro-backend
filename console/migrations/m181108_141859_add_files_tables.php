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
            'sectors' => $this->text()->null(),
            'corporates' => $this->text()->null(),
            'brands' => $this->text()->null(),
            'title' => $this->string(),
            'description' => $this->longText(),
            'version' => $this->integer(),
            'status' => $this->tinyInteger(),
        ]);

        $this->createTable('file_partition',[
            'id' => $this->primaryKey(),
            'file_id' => $this->integer(),
            'version' => $this->integer(),
            'order' => $this->integer(),
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
