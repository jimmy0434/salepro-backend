<?php

use cnd\core\components\Migration;

/**
 * Class m190124_115349_remove_old_structure
 */
class m190124_115349_remove_old_structure extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->safeOperation(function(){
            $this->ignoreErr(function(){
                $this->truncateTable('{{%cms_category}}');
            });
            $this->ignoreErr(function(){
                $this->dropTable('{{%cms_category}}');
            });

            $this->ignoreErr(function(){
                $this->truncateTable('{{%cms_content}}');
            });
            $this->ignoreErr(function(){
                $this->dropTable('{{%cms_content}}');
            });

            $this->ignoreErr(function(){
                $this->truncateTable('{{%cms_tag}}');
            });
            $this->ignoreErr(function(){
                $this->dropTable('{{%cms_tag}}');
            });

            $this->ignoreErr(function(){
                $this->truncateTable('{{%cms_gallery}}');
            });
            $this->ignoreErr(function(){
                $this->dropTable('{{%cms_gallery}}');
            });

            $this->ignoreErr(function(){
                $this->truncateTable('{{%cms_gallery_media}}');
            });
            $this->ignoreErr(function(){
                $this->dropTable('{{%cms_gallery_media}}');
            });

            $this->ignoreErr(function(){
                $this->removeIndexForeignKey('form.content_id');
            });
            $this->ignoreErr(function(){
                $this->dropColumn('{{%form}}','content_id');
            });
            $this->ignoreErr(function(){
                $this->removeIndexForeignKey('file.content_id');
            });
            $this->ignoreErr(function(){
                $this->dropColumn('{{%file}}','content_id');
            });
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190124_115349_remove_old_structure cannot be reverted.\n";

        return false;
    }

    public function ignoreErr($callback){
        try{
            $callback();
        }catch(\Throwable $t){

        }catch (\Exception $e) {

        }
    }
}
