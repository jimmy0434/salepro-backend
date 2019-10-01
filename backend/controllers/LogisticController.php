<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/25/2019
 * Time: 3:08 PM
 */

namespace backend\controllers;

use common\models\LogisticCategory;
use common\models\LogisticQuery;
use Yii;
use cnd\admin\models\activerecords\Log;
use cnd\core\components\SController;
use cnd\grid\DataLocator;
use common\models\Logistic;
use yii\helpers\ArrayHelper;

class LogisticController extends SController
{
    public $category = null;
    public $categories = [];

    public function beforeAction($action)
    {
        $this->categories = ArrayHelper::map(LogisticCategory::find()->orderBy(['position' => SORT_ASC, 'name' => SORT_ASC])->all(), 'id', 'name');
        if (Yii::$app->request->get('c') && array_key_exists(Yii::$app->request->get('c'), $this->categories)) {
            $this->category = Yii::$app->request->get('c');
        } else if (!empty($this->categories) && is_array($this->categories)) {
            reset($this->categories);
            $this->category = key($this->categories);
        } else {
            Yii::$app->session->setFlash('warning', 'Should define a category to create logistic');
            $this->redirect(['/logistic-category/index']);
            return null;
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        /**
         * @var $dataLocator DataLocator
         */
        $dataLocator = DataLocator::create(Logistic::className(), [
            'orderBy' => 'name ASC',
            'pageSize' => 20,
            'params' => [
                'c' => $this->category,
            ],
        ], function ($dl, $query) {
            assert($dl instanceof DataLocator);
            assert($query instanceof LogisticQuery);

            $query->andWhere(['category_id' => $this->category]);
        });
        Log::trace("Show logistics List (page:" . $dataLocator->page . ", count: " . $dataLocator->pageSize . ")");
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('index', ['dataLocator' => $dataLocator]);
        }
        return $this->render('index', ['dataLocator' => $dataLocator]);
    }

    public function actionManage($id = null)
    {
        $model = Logistic::findOne($id);
        if (!$model) {
            $model = new Logistic();
            $model->category_id = $this->category;
        }
        if ($model === null) {
            throw new \yii\web\HttpException(404, 'The requested logistic could not be found.');
        }
        $isNew = $model->isNewRecord;
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' saved successfully');
                $model->sendNotification();
                if ($isNew) {
                    Log::trace("Create new logistic #" . $model->id);
                } else {
                    Log::trace("Update logistic #" . $id);
                }
            } else {
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not saved');
            }
            return $this->redirect(['index', 'c' => $this->category]);
        }
        Log::trace("Open logistic form");
        return $this->render('form', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = Logistic::find()->where(['id' => $id])->one();
        if ($model !== null) {
            if ($model->delete()) {
                Log::trace("logistic deleted #" . $id);
                $model->sendNotification();
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' deleted successfully');
            } else {
                Log::trace("logistic not deleted #" . $id);
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not deleted');
            }
        } else {
            Log::trace("logistic not found to delete #" . $id);
            \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not found');
        }
        return $this->redirect(['index', 'c' => $this->category]);
    }
}
