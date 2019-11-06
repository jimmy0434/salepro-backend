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
use common\models\BusinessUnit;
use common\models\Portfolio;
use common\models\PortfolioQuery;
use common\models\User;
use Yii;
use cnd\core\components\SController;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

class PortfolioController extends SController
{
    public $target = null;
    public $targets = [];

    public function beforeAction($action)
    {
        $portfolio = new Portfolio();
        $this->target = Portfolio::TARGET_MOTHER_CORPORATE;
        $this->targets = $portfolio->target_listtranslate;
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
            'params' => [
                't' => $this->target,
            ],
            'pageSize' => 20,
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
                $model->sendNotification();
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

    public function actionDelete($id)
    {
        $model = Portfolio::find()->where(['id' => $id])->one();
        if ($model !== null) {
            if ($model->delete()) {
                Log::trace("Portfolio deleted #" . $id);
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' deleted successfully');
            } else {
                Log::trace("Portfolio not deleted #" . $id);
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not deleted');
            }
        } else {
            Log::trace("Portfolio not found to delete #" . $id);
            \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not found');
        }
        return $this->redirect(['index', 't' => $model->target]);
    }

    protected function findList($target, $q, $page = 1)
    {
        Yii::$app->response->format = 'json';
        $response = [];
        $total = Portfolio::find()->where(['target' => $target])->count();

        $query = Portfolio::find()->where(['target' => $target]);
        $query->andWhere('name like "%' . $q . '%"');
        $query->limit(30);
        $query->offset(($page - 1) * 30);
        $list = $query->all();

        if (!empty($list) && is_array($list)) {
            foreach ($list as $model) {
                $item = lcfirst(Inflector::id2camel($model->target_label, '_'));
                if ($model->hasProperty($item)) {
                    $response[] = [
                        'id' => $model->$item->id,
                        'text' => $model->name,
                    ];
                }
            }
        }
        return ['items' => $response, 'total_count' => $total];
    }

    protected function addItem($target)
    {
        Yii::$app->response->format = 'json';
        $name = Yii::$app->request->post('name');
        $model = new Portfolio();
        $model->name = $name;
        $model->target = $target;
        if ($model->save()) {
            $item = lcfirst(Inflector::id2camel($model->target_label, '_'));
            if ($model->hasProperty($item)) {
                return ['id' => $model->$item->id];
            }
        }
        return null;
    }

    public function actionFindSectors($q, $page = 1)
    {
        return $this->findList(Portfolio::TARGET_SECTOR, $q, $page);
    }

    public function actionFindBrands($q, $page = 1)
    {
        return $this->findList(Portfolio::TARGET_BRAND, $q, $page);
    }

    public function actionFindProducts($q, $page = 1)
    {
        return $this->findList(Portfolio::TARGET_PRODUCT, $q, $page);
    }

    public function actionFindBusinessUnit($q, $page = 1)
    {
        return $this->findList(Portfolio::TARGET_BUSINESS_UNIT, $q, $page);
    }

    public function actionAddSector()
    {
        return $this->addItem(Portfolio::TARGET_SECTOR);
    }

    public function actionAddBrand()
    {
        return $this->addItem(Portfolio::TARGET_BRAND);
    }

    public function actionAddProduct()
    {
        return $this->addItem(Portfolio::TARGET_PRODUCT);
    }

    public function actionAddBusinessUnit()
    {
        return $this->addItem(Portfolio::TARGET_BUSINESS_UNIT);
    }

    public function actionStatus()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = 'json';
            $response = ['changed' => false];
            $id = Yii::$app->request->post('id');
            $status = Yii::$app->request->post('status');
            $model = Portfolio::findOne($id);
            if ($model !== null) {
				$table = Portfolio::getTableSchema()->name;
				$sql = <<< SQL
	UPDATE `{$table}` SET `status` = "{$status}" WHERE `id` = {$id}			
SQL;
				Yii::$app->db->createCommand($sql)->execute();
				$response['changed'] = true;
				Log::trace("Change Portfolio #" . $model->id . " status, become " . $model->status_label);
            }
            return $response;
        }
        return $this->redirect(['index', 't' => $this->target]);
    }
}
