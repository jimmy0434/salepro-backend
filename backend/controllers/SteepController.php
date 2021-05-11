<?php

namespace backend\controllers;

use cnd\admin\models\activerecords\Log;
use common\models\Steep;
use Yii;
use cnd\core\components\SController;
use cnd\grid\DataLocator;

class SteepController extends SController
{
    public $target = null;
    public $targets = [];

    public function beforeAction($action)
    {
        $steep = new Steep();
        $this->target = Steep::TARGET_Social;
        $this->targets = $steep->target_listtranslate;
        if (Yii::$app->request->get('t') && in_array(Yii::$app->request->get('t'), $steep->target_values)) {
            $this->target = Yii::$app->request->get('t');
        }
        return parent::beforeAction($action);
    }
    public function actionIndex()
    {
         $dataLocator = DataLocator::create(Steep::className(), [
            'orderBy' => 'updated_at DESC, created_at DESC, id DESC',
            'params' => [
                't' => $this->target,
            ],
            'pageSize' => 20,
        ], function ($dl, $query) {
            /**
             * @var DataLocator $dl
             * @var SteepQuery $query
             */
            $query->andWhere(['target' => $this->target]);
        });
        Log::trace("Show Steep List of " . $this->targets[$this->target] . " (page:" . $dataLocator->page . ", count: " . $dataLocator->pageSize . ")");
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('index', ['dataLocator' => $dataLocator]);
        }
        return $this->render('index', ['dataLocator' => $dataLocator]);
    }

    public function actionManage($id = null)
    {
        $model = Steep::findOne($id);
        if (!$model && !$id) {
            $model = new Steep();
            $model->target = $this->target;
        }
        if (!$model) {
            throw new \yii\web\HttpException(404, 'The requested Steep could not be found.');
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
                Log::trace("Create new Steep data #" . $model->id);
                //return $this->redirect(['manage', 'id' => $model->id, 't' => $model->target]);
            }
            Log::trace("Update Steep data #" . $id);
            return $this->redirect(['index', 't' => $model->target]);
        }
        Log::trace("Open Steep data form");
        return $this->render('form', ['model' => $model, 'isNew' => $isNew]);
    }

    
    public function actionDelete($id){
        $model = Steep::find()->where(['id' => $id])->one();
        if ($model !== null) {
            if ($model->delete()) {
                Log::trace("Steep deleted #" . $id);
                $model->sendNotification();
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' deleted successfully');
            } else {
                Log::trace("Steep not deleted #" . $id);
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not deleted');
            }
        } else {
            Log::trace("Steep not found to delete #" . $id);
            \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not found');
        }
        return $this->redirect(['index']);
    }

}
