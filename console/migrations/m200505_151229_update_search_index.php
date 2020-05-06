<?php

use cnd\core\components\Migration;
use common\models\Exhibition;
use common\models\MarketResearch;
use common\models\Competitor;
/**
 * Class m200505_151229_update_search_index
 */
class m200505_151229_update_search_index extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       foreach (Exhibition::find()->each(100) as $exhibition) {
            $exhibition->save();
        }
        echo "Exhibition index updated.\n";

       foreach (MarketResearch::find()->each(100) as $marketResearch) {
            $marketResearch->save();
        }
        echo "MarketResearch index updated.\n";

        // please, comment some code common\models\Competitor before run migration
        // in functions beforeSave() and afterSave()
        // and remove comments after migration
       foreach (Competitor::find()->each(100) as $competitor) {
            $competitor->save();
        }
        echo "Competitor index updated.\n";
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {


        return true;
    }

}
