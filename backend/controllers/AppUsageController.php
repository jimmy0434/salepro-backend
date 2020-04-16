<?php

namespace backend\controllers;

use cnd\admin\models\activerecords\Log;
use common\models\AppUsage;
use Yii;
use cnd\core\components\SController;
use cnd\grid\DataLocator;

class AppUsageController extends SController
{
    public function actionIndex()
    {
        /**
         * @var $dataLocator DataLocator
         */
        $dataLocator = DataLocator::create(AppUsage::className(), [
            'orderBy' => 'updated_at DESC, created_at DESC, id ASC',
            'pageSize' => 20,
        ], function ($dl, $query) {
            $query->andWhere(['app' => 'SalePro App', 'level' => 'App']);
        }
        );

        Log::trace("Show app usage log (page:" . $dataLocator->page . ", count: " . $dataLocator->pageSize . ")");
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('index', ['dataLocator' => $dataLocator]);
        }
        return $this->render('index', ['dataLocator' => $dataLocator]);
    }
}
