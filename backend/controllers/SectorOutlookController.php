<?php

namespace backend\controllers;
use Yii;
use cnd\admin\models\activerecords\Log;
use cnd\core\components\SController;
use cnd\grid\DataLocator;
use common\models\SectorOutlook;

class SectorOutlookController extends SController
{
    public function actionIndex()
    { 
        $dataLocator = DataLocator::create(SectorOutlook::className(), [
            'orderBy' => 'updated_at DESC, created_at DESC, id DESC',
            'pageSize' => 20,
        ], function ($dl, $query) {
            $m = new SectorOutlook();
            $attrs = $m->attributes;
            unset($attrs['file']);
            $attrs = array_keys($attrs);
            $query->select($attrs);
        });
        Log::trace("Show Sector Outlook List (page:" . $dataLocator->page . ", count: " . $dataLocator->pageSize . ")");
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('index', ['dataLocator' => $dataLocator]);
        }
        return $this->render('index', ['dataLocator' => $dataLocator]);

    }
    public function actionSalesman()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = 'json';
            $response = ['changed' => false];
            $id = Yii::$app->request->post('id');
            $status = Yii::$app->request->post('status');
            $model = SectorOutlook::findOne($id);
            if ($model !== null) {
                $model->notifyOne($model->salesman_id); // old owner
                $model->salesman_id = $status;
                $model->save();
                $model->notifyOne($model->salesman_id);  // new owner
                $response['changed'] = true;
                Log::trace("Change steep analysis #" . $model->id . " salesman to " . $status);
            }

            return $response;
        }
        return $this->redirect(['index']);
    }
    public function actionView($id)
    {
        $model = SectorOutlook::findOne($id);
        return $this->render('view', ['model' => $model]);
    }

  
    public function actionDelete($id)
    {
        $model = SectorOutlook::find()->where(['id' => $id])->one();
        if ($model !== null) {
            if ($model->delete()) {
                Log::trace("SectorOutlook deleted #" . $id);
                Yii::$app->session->setFlash('success', ucfirst($this->id) . ' deleted successfully');
               // $model->notifyAll();
            } else {
                Log::trace("SectorOutlook not deleted #" . $id);
                Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not deleted');
            }
        } else {
            Log::trace("SectorOutlook not found to delete #" . $id);
            Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not found');
        }
        return $this->redirect(['index']);
    }

    public function actionManage($id = null)
    {
        $model = SectorOutlook::findOne($id);
      
        if ($model === null) {
            throw new \yii\web\HttpException(404, 'The requested SectorOutlook could not be found.');
        }
   
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
              //  $model->sendNotification();
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' saved successfully');
            } else {
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not saved');
            }
          
            
            return $this->redirect(['index']);
        }
        Log::trace("Open SectorOutlook form");
        return $this->render('form', ['model' => $model]);
    }

}