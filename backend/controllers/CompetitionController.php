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
            'pageSize' => 20,
        ], function ($dl, $query) {
            $m = new Competitor();
            $attrs = $m->attributes;
            unset($attrs['logo'], $attrs['file']);
            $attrs = array_keys($attrs);
            $query->select($attrs);
        });
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

    public function actionStatus()
    {
        
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = 'json';
            $response = ['changed' => false];
         $id = Yii::$app->request->post('id');
            $status = Yii::$app->request->post('status');
            
            $model = Competitor::findOne($id);
            if ($model !== null) {
                $model->status = $status;
                $model->save();
                $model->notifyAll();
                $response['changed'] = true;
                Log::trace("Change Competitor #" . $model->id . " status, become " . $model->status_label);
            }
            return $response;
        }
        return $this->redirect(['index']);
    }

    public function actionSalesman()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = 'json';
            $response = ['changed' => false];
            $id = Yii::$app->request->post('id');
            $status = Yii::$app->request->post('status');
            $model = Competitor::findOne($id);
            if ($model !== null) {
                $model->notifyOne($model->salesman_id); // old owner
                $model->salesman_id = $status;
                $model->save();
                $model->notifyOne($model->salesman_id);  // new owner
                $response['changed'] = true;
                Log::trace("Change Competitor #" . $model->id . " salesman to " . $status);
            }

            return $response;
        }
        return $this->redirect(['index']);
    }

    public function actionDelete($id)
    {
        $model = Competitor::find()->where(['id' => $id])->one();
        if ($model !== null) {
            if ($model->delete()) {
                Log::trace("Competitor deleted #" . $id);
                Yii::$app->session->setFlash('success', ucfirst($this->id) . ' deleted successfully');
                $model->notifyAll();
            } else {
                Log::trace("Competitor not deleted #" . $id);
                Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not deleted');
            }
        } else {
            Log::trace("Competitor not found to delete #" . $id);
            Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not found');
        }
        return $this->redirect(['index']);
    }
}
