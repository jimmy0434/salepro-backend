<?php

use cnd\core\components\Migration;

/**
 * Class m181214_131752_add_cms_tables
 */
class m181214_131752_add_cms_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('content', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'excerpt' => $this->text(),
            'text' => $this->longText(),
            'status' => $this->string(),
            'position' => $this->integer(),
            'view_count' => $this->integer(),
        ]);

        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'status' => $this->string(),
            'parent_id' => $this->integer(),
        ]);

        $this->createTable('tag', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);

        $this->createTable('content_category', [
            'id' => $this->primaryKey(),
            'content_id' => $this->integer(),
            'category_id' => $this->integer(),
            'is_primary' => $this->boolean(),
        ]);

        $this->createTable('content_tag', [
            'id' => $this->primaryKey(),
            'content_id' => $this->integer(),
            'tag_id' => $this->integer(),
        ]);

        $this->createTable('content_image', [
            'id' => $this->primaryKey(),
            'content_id' => $this->integer(),
            'image' => $this->text(),
        ]);

        $this->createTable('content_attribute', [
            'id' => $this->primaryKey(),
            'content_id' => $this->integer(),
            'name' => $this->string(),
            'value' => $this->string(),
        ]);

        $this->addRelations(function () {
            $this->createIndexForeignKey('category.parent_id', 'category.id');
            $this->createIndexForeignKey('content_category.content_id', 'content.id');
            $this->createIndexForeignKey('content_category.category_id', 'category.id');
            $this->createIndexForeignKey('content_tag.content_id', 'content.id');
            $this->createIndexForeignKey('content_tag.tag_id', 'tag.id');
            $this->createIndexForeignKey('content_image.content_id', 'content.id');
            $this->createIndexForeignKey('content_attribute.content_id', 'content.id');
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181214_131752_add_cms_tables cannot be reverted.\n";

        return false;
    }
}
