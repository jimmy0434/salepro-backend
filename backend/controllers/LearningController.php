<?php


namespace backend\controllers;


use common\models\LearningQuery;
use Yii;
use cnd\admin\models\activerecords\Log;
use cnd\core\components\SController;
use cnd\grid\DataLocator;
use common\models\Learning;

use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

class LearningController extends SController
{
    public $target = null;
    public $targets = [];

 



    public function beforeAction($action)
    {
        $Learning = new Learning();
        $this->target = Learning::TARGET_View1;
        $this->targets = $Learning->target_listtranslate;
        if (Yii::$app->request->get('t') && in_array(Yii::$app->request->get('t'), $Learning->target_values)) {
            $this->target = Yii::$app->request->get('t');
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $dataLocator = DataLocator::create(Learning::className(), [
            'orderBy' => 'updated_at DESC, created_at DESC, id DESC',
            'params' => [
                't' => $this->target,
            ],
            'pageSize' => 20,
        ], function ($dl, $query) {
            /**
             * @var DataLocator $dl
             * @var LearningQuery $query
             */
            $query->andWhere(['target' => $this->target]);
        });
        Log::trace("Show Learning List of " . $this->targets[$this->target] . " (page:" . $dataLocator->page . ", count: " . $dataLocator->pageSize . ")");
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('index', ['dataLocator' => $dataLocator]);
        }
        return $this->render('index', ['dataLocator' => $dataLocator]);
    }

    public function actionManage($id = null)
    {   
        $model = Learning::findOne($id);
        if (!$model && !$id) {
            $model = new Learning();
            $model->target = $this->target;
        }
        if (!$model) {
            throw new \yii\web\HttpException(404, 'The requested Learning could not be found.');
        }
        $isNew = $model->isNewRecord;
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' saved successfully');
//$model->sendNotification();
            } else {
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not saved');
            }
            if ($isNew) {
                Log::trace("Create new Learning data #" . $model->id);
                //return $this->redirect(['manage', 'id' => $model->id, 't' => $model->target]);
            }
            Log::trace("Update Learning data #" . $id);
            return $this->redirect(['index', 't' => $model->target]);
        }
        Log::trace("Open Learning data form");
        return $this->render('form', ['model' => $model, 'isNew' => $isNew]);
    }

    
    public function actionDelete($id){
        $model = Learning::find()->where(['id' => $id])->one();
        if ($model !== null) {
            if ($model->delete()) {
                Log::trace("Learning deleted #" . $id);
              //  $model->sendNotification();
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' deleted successfully');
            } else {
                Log::trace("Learning not deleted #" . $id);
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not deleted');
            }
        } else {
            Log::trace("Learning not found to delete #" . $id);
            \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not found');
        }
        return $this->redirect(['index']);
    }
   
}
