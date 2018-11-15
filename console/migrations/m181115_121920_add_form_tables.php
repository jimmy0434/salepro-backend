<?php

use cnd\core\components\Migration;

/**
 * Class m181115_121920_add_form_tables
 */
class m181115_121920_add_form_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('form',[
            'id' => $this->primaryKey(),
            'content_id' => $this->integer(),
            'name' => $this->string(20),
            'title' => $this->string(),
            'version' => $this->integer(20),
            'status' => $this->tinyInteger(),
            'structure' => $this->longText(),
        ]);

        $this->addRelations(function(){
            $this->createIndexForeignKey('form.content_id','cms_content.id');
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181115_121920_add_form_tables cannot be reverted.\n";

        return false;
    }
}
