<?php

use cnd\cms\models\activerecords\Category;
use cnd\cms\models\activerecords\Content;
use cnd\core\components\Migration;
use common\models\File;
use common\models\Form;

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
        Category::deleteAll();
        Content::deleteAll();
        File::deleteAll();
        Form::deleteAll();

        $this->createCategory("Hub Content","contentHub");
        $this->createCategory("Market Intelligence","marketIntelligence");
        $this->createCategory("Competition","competition");
        $this->createCategory("Brands","brands");
        $this->createCategory("Corporates","corporates");
        $this->createCategory("Sectors","sectors");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181220_072033_define_constants_categories_and_remove_old_data cannot be reverted.\n";

        return false;
    }

    public function createCategory($name, $staticName)
    {
        $model = new Category();
        $model->status = Category::STATUS_ACTIVE;
        $model->config = '{"template":"none","comments":"0","tags":"0","category":"0","related":"0","reaction":"0","share":"0"}';
        $model->setting = '{"markdown":"0"}';
        if ($model->save()) {
            $modelLang = new Category();
            $modelLang->language = "en";
            $modelLang->original_id = $model->id;
            $modelLang->name = $name;
            if ($modelLang->save()) {
                Yii::$app->cms->setId("cms.category.".$staticName, $model->id);
            }
        }
    }
}
