<?php

namespace backend\controllers;
use Yii;
use cnd\admin\models\activerecords\Log;
use cnd\core\components\SController;
use cnd\grid\DataLocator;
use common\models\SteepAnalysis;

class SteepAnalysisController extends SController
{
    public function actionIndex()
    { 
        
        $dataLocator = DataLocator::create(SteepAnalysis::className(), [
        'orderBy' => 'updated_at DESC, created_at DESC, id DESC',
        'pageSize' => 20,
    ], function ($dl, $query) {
        $m = new SteepAnalysis();
        $attrs = $m->attributes;
      
        $attrs = array_keys($attrs);
        $query->select($attrs);
    });
    Log::trace("Show Steep Analysis List (page:" . $dataLocator->page . ", count: " . $dataLocator->pageSize . ")");
    if (Yii::$app->request->isAjax) {
        return $this->renderAjax('index', ['dataLocator' => $dataLocator]);
    }
    return $this->render('index', ['dataLocator' => $dataLocator]);
    }
    public function actionView($id)
    {
        $model = SteepAnalysis::findOne($id);
        return $this->render('view', ['model' => $model]);
    }

    public function actionStatus()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = 'json';
            $response = ['changed' => false];
            $id = Yii::$app->request->post('id');
            $status = Yii::$app->request->post('status');
            $model = SteepAnalysis::findOne($id);
            
            if ($model !== null) {
                $model->status = $status;
                $model->save();
              //  $model->notifyAll();
                $response['changed'] = true;
                Log::trace("Change Competitor #" . $model->id . " status, become " . $model->status_label);
                
                
            }
            return $response;
        }
        return $this->redirect(['index']);
    }
    public function actionDelete($id)
    {
        $model = SteepAnalysis::find()->where(['id' => $id])->one();
        if ($model !== null) {
            if ($model->delete()) {
                Log::trace("SteepAnalysis deleted #" . $id);
                Yii::$app->session->setFlash('success', ucfirst($this->id) . ' deleted successfully');
               // $model->notifyAll();
            } else {
                Log::trace("SteepAnalysis not deleted #" . $id);
                Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not deleted');
            }
        } else {
            Log::trace("SteepAnalysis not found to delete #" . $id);
            Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not found');
        }
        return $this->redirect(['index']);
    }
}
