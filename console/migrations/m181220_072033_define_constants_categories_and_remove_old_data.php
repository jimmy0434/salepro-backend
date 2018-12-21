<?php

use cnd\cms\models\activerecords\Category;
use cnd\cms\models\activerecords\Content;
use cnd\core\components\Migration;
use common\models\File;
use common\models\Form;
use yii\helpers\Json;

/**
 * Class m181220_072033_define_constants_categories_and_remove_old_data
 */
class m181220_072033_define_constants_categories_and_remove_old_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addRelations(function(){
            $this->truncateTable(Category::tableName());
            $this->truncateTable(Content::tableName());
            $this->truncateTable(File::tableName());
            $this->truncateTable(Form::tableName());
        });

        $directories = $this->createCategory("Directories", "directories");
        $classifications = $this->createCategory("Classifications", "classifications");
        if($directories) {
            $this->createCategory("Content Hub", "contentHub", $directories->id);
            $this->createCategory("Market Intelligence", "marketIntelligence", $directories->id);
            $this->createCategory("Competitor Profiles", "competitor", $directories->id);
        }
        if($classifications) {
            $this->createCategory("Corporate", "corporates", $classifications->id);
            $this->createCategory("Sector", "sectors", $classifications->id);
            $this->createCategory("Brand", "brands", $classifications->id);
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181220_072033_define_constants_categories_and_remove_old_data cannot be reverted.\n";

        return false;
    }

    public function createCategory($name, $staticName = null, $parentId = null)
    {
        $model = new Category();
        $model->status = Category::STATUS_ACTIVE;
        $model->config = Json::decode('{"template":"none","comments":"0","tags":"0","category":"0","related":"0","reaction":"0","share":"0"}');
        $model->setting = Json::decode('{"markdown":"0"}');
        $model->parent_id = $parentId;
        $model->path = $parentId;
        if ($model->save()) {
            $modelLang = new Category();
            $modelLang->language = "en";
            $modelLang->original_id = $model->id;
            $modelLang->name = $name;
            if ($modelLang->save()) {
                if($staticName) {
                    Yii::$app->cms->setId("cms.category." . $staticName, $model->id);
                }
            }
            return $model;
        }
        return null;
    }
}
