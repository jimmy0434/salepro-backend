<?php

use cnd\core\components\Migration;

/**
 * Class m200504_165727_include_exhibitions_2_search
 */
class m200504_165727_include_exhibitions_2_search extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%exhibition}}', 'uid', $this->string());
        $this->addColumn('{{%exhibition}}', 'search_id', $this->integer());

        $this->safeOperation(function () {
            $this->createIndex(
                'uid',
                '{{%exhibition}}',
                'uid'
            );
            $this->createIndex(
                'search_id',
                '{{%exhibition}}',
                'search_id'
            );
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'uid',
            '{{%exhibition}}'
        );

        $this->dropIndex(
            'search_id',
            '{{%exhibition}}'
        );

        $this->dropColumn('{{%exhibition}}', 'uid');
        $this->dropColumn('{{%exhibition}}', 'search_id');

        return true;
    }
}
