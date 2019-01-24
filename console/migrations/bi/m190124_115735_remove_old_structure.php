<?php

use cnd\core\components\Migration;

/**
 * Class m190124_115735_remove_old_structure
 */
class m190124_115735_remove_old_structure extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->safeOperation(function () {
            $this->ignoreErr(function () {
                $this->truncateTable('{{%category}}');
            });
            $this->ignoreErr(function () {
                $this->dropTable('{{%category}}');
            });
            $this->ignoreErr(function () {
                $this->truncateTable('{{%tag}}');
            });
            $this->ignoreErr(function () {
                $this->dropTable('{{%tag}}');
            });
            $this->ignoreErr(function () {
                $this->truncateTable('{{%content}}');
            });
            $this->ignoreErr(function () {
                $this->dropTable('{{%content}}');
            });
            $this->ignoreErr(function () {
                $this->truncateTable('{{%content_category}}');
            });
            $this->ignoreErr(function () {
                $this->dropTable('{{%content_category}}');
            });
            $this->ignoreErr(function () {
                $this->truncateTable('{{%content_attribute}}');
            });
            $this->ignoreErr(function () {
                $this->dropTable('{{%content_attribute}}');
            });
            $this->ignoreErr(function () {
                $this->truncateTable('{{%content_attribute}}');
            });
            $this->ignoreErr(function () {
                $this->dropTable('{{%content_attribute}}');
            });
            $this->ignoreErr(function () {
                $this->truncateTable('{{%content_image}}');
            });
            $this->ignoreErr(function () {
                $this->dropTable('{{%content_image}}');
            });
            $this->ignoreErr(function () {
                $this->truncateTable('{{%content_tag}}');
            });
            $this->ignoreErr(function () {
                $this->dropTable('{{%content_tag}}');
            });
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190124_115735_remove_old_structure cannot be reverted.\n";

        return false;
    }

    public function ignoreErr($callback)
    {
        try {
            $callback();
        } catch (\Throwable $t) {

        } catch (\Exception $e) {

        }
    }
}
