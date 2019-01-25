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
        if (Yii::$app->request->get('t') && in_array(Yii::$app->request->get('t'), $portfolio->target_values)) {
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

    public function actionManage($id = null)
    {
        $model = Portfolio::findOne($id);
        if (!$model && !$id) {
            $model = new Portfolio();
            $model->target = $this->target;
        }
        if (!$model) {
            throw new \yii\web\HttpException(404, 'The requested portfolio could not be found.');
        }
        $isNew = $model->isNewRecord;
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' saved successfully');
            } else {
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not saved');
            }
            if ($isNew) {
                Log::trace("Create new portfolio data #" . $model->id);
                //return $this->redirect(['manage', 'id' => $model->id, 't' => $model->target]);
            }
            Log::trace("Update portfolio data #" . $id);
            return $this->redirect(['index', 't' => $model->target]);
        }
        Log::trace("Open portfolio data form");
        return $this->render('form', ['model' => $model, 'isNew' => $isNew]);
    }
}