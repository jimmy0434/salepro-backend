<?php


namespace backend\controllers;

use cnd\admin\models\activerecords\Log;
use cnd\grid\DataLocator;
use common\models\Pactgalery;
use Yii;
use cnd\core\components\SController;

class PactgaleryController extends SController
{

    public function actionIndex()
    {
        /**
         * @var $dataLocator DataLocator
         */
        $dataLocator = DataLocator::create(Pactgalery::className(), [
            'orderBy' => 'updated_at DESC, created_at DESC, id DESC',
            'pageSize' => 20,
        ]);
        Log::trace("Show Pact Galery List (page:" . $dataLocator->page . ", count: " . $dataLocator->pageSize . ")");
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('index', ['dataLocator' => $dataLocator]);
        }
        return $this->render('index', ['dataLocator' => $dataLocator]);
    }

    public function actionManage($id = null)
    {
        $model = Pactgalery::findOne($id);
        if (!$model) {
            $model = new Pactgalery();
        }
        if ($model === null) {
            throw new \yii\web\HttpException(404, 'The requested pact galery could not be found.');
        }
        $isNew = $model->isNewRecord;
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                if ($isNew) {
                    Log::trace("Create new pact galery #" . $model->id);
                }else {
                    Log::trace("Update pact galery #" . $id);
                }
                $model->sendNotification();
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' saved successfully');
            } else {
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not saved');
            }
            return $this->redirect(['index']);
        }
        Log::trace("Open pact galery form");
        return $this->render('form', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = Pactgalery::find()->where(['id' => $id])->one();
        if ($model !== null) {
            if ($model->delete()) {
                Log::trace("Pact Galery deleted #" . $id);
                $model->sendNotification();
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' deleted successfully');
            } else {
                Log::trace("Pact Galery not deleted #" . $id);
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not deleted');
            }
        } else {
            Log::trace("Pact Galery not found to delete #" . $id);
            \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not found');
        }
        return $this->redirect(['index']);
    }

}
