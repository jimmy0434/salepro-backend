<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/6/2019
 * Time: 12:24 PM
 */

namespace backend\controllers;

use Yii;
use cnd\admin\models\activerecords\Log;
use cnd\core\components\SController;
use cnd\grid\DataLocator;
use common\models\Competitor;

class CompetitionController extends SController
{
    public function actionIndex()
    {
        /**
         * @var $dataLocator DataLocator
         */
        $dataLocator = DataLocator::create(Competitor::className(), [
            'orderBy' => 'updated_at DESC, created_at DESC, id DESC',
        ]);
        Log::trace("Show Competitions List (page:" . $dataLocator->page . ", count: " . $dataLocator->pageSize . ")");
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('index', ['dataLocator' => $dataLocator]);
        }
        return $this->render('index', ['dataLocator' => $dataLocator]);
    }

    public function actionView($id)
    {
        $model = Competitor::findOne($id);
        return $this->render('view', ['model' => $model]);
    }
}
