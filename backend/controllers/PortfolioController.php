<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 1/24/2019
 * Time: 4:57 PM
 */

namespace backend\controllers;

use cnd\admin\models\activerecords\Log;
use cnd\grid\DataLocator;
use common\models\Portfolio;
use common\models\PortfolioQuery;
use Yii;
use cnd\core\components\SController;

class PortfolioController extends SController
{
    public $target = null;
    public $targets = [];

    public function beforeAction($action)
    {
        $portfolio = new Portfolio();
        $this->target = Portfolio::TARGET_CORPORATE;
        $this->targets = $portfolio->target_list;
        if (Yii::$app->request->get('t') && array_key_exists(Yii::$app->request->get('t'), $portfolio->target_values)) {
            $this->target = Yii::$app->request->get('t');
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        /**
         * @var $dataLocator DataLocator
         */
        $dataLocator = DataLocator::create(Portfolio::className(), [
            'orderBy' => 'updated_at DESC, created_at DESC, id DESC',
        ], function ($dl, $query) {
            /**
             * @var DataLocator $dl
             * @var PortfolioQuery $query
             */
            $query->andWhere(['target' => $this->target]);
        });
        Log::trace("Show Portfolio List of " . $this->targets[$this->target] . " (page:" . $dataLocator->page . ", count: " . $dataLocator->pageSize . ")");
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('index', ['dataLocator' => $dataLocator]);
        }
        return $this->render('index', ['dataLocator' => $dataLocator]);
    }
}