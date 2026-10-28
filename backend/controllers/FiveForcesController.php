<?php

namespace backend\controllers;
use Yii;
use cnd\admin\models\activerecords\Log;
use cnd\core\components\SController;
use cnd\grid\DataLocator;
use common\models\FiveForces;

class FiveForcesController extends SController
{
    public function actionIndex()
    { 
        
        $dataLocator = DataLocator::create(FiveForces::className(), [
        'orderBy' => 'updated_at DESC, created_at DESC, id DESC',
        'pageSize' => 20,
    ], function ($dl, $query) {
        $m = new FiveForces();
        $attrs = $m->attributes;
      
        $attrs = array_keys($attrs);
        $query->select($attrs);
    });
    Log::trace("Show Five forces List (page:" . $dataLocator->page . ", count: " . $dataLocator->pageSize . ")");
    if (Yii::$app->request->isAjax) {
        return $this->renderAjax('index', ['dataLocator' => $dataLocator]);
    }
    return $this->render('index', ['dataLocator' => $dataLocator]);
    }
    public function actionView($id)
    {
        $model = FiveForces::findOne($id);
        return $this->render('view', ['model' => $model]);
    }
    public function actionSalesman()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = 'json';
            $response = ['changed' => false];
            $id = Yii::$app->request->post('id');
            $status = Yii::$app->request->post('status');
            $model = FiveForces::findOne($id);
            if ($model !== null) {
              $model->notifyOne($model->salesman_id); // old owner
                $model->salesman_id = $status;
                $model->save();
                $model->notifyOne($model->salesman_id);  // new owner
                $response['changed'] = true;
                Log::trace("Change Five Forces #" . $model->id . " salesman to " . $status);
            }

            return $response;
        }
        return $this->redirect(['index']);
    }

    public function actionDelete($id)
    {
        $model = FiveForces::find()->where(['id' => $id])->one();
        if ($model !== null) {
            if ($model->delete()) {
                Log::trace("FiveForces deleted #" . $id);
                Yii::$app->session->setFlash('success', ucfirst($this->id) . ' deleted successfully');
                $model->notifyAll();
            } else {
                Log::trace("FiveForces not deleted #" . $id);
                Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not deleted');
            }
        } else {
            Log::trace("FiveForces not found to delete #" . $id);
            Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not found');
        }
        return $this->redirect(['index']);
    }
}
