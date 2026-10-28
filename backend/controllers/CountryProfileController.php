<?php


namespace backend\controllers;

use Yii;
use cnd\admin\models\activerecords\Log;
use cnd\core\components\SController;
use cnd\grid\DataLocator;
use common\models\CountryProfile;

class CountryProfileController extends SController
{
    public function actionIndex(){
        /**
         * @var $dataLocator DataLocator
         */
        $dataLocator = DataLocator::create(CountryProfile::className(), [
            'orderBy' => 'updated_at DESC, created_at DESC, id DESC',
            'pageSize' => 20,
        ]);
        Log::trace("Show CountryProfile List (page:" . $dataLocator->page . ", count: " . $dataLocator->pageSize . ")");
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('index', ['dataLocator' => $dataLocator]);
        }
        return $this->render('index', ['dataLocator' => $dataLocator]);
    }

    public function actionManage($id = null){
        $model = CountryProfile::findOne($id);
        if (!$model) {
            $model = new CountryProfile();
        }
        if ($model === null) {
            throw new \yii\web\HttpException(404, 'The requested CountryProfile could not be found.');
        }
        $isNew = $model->isNewRecord;
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                if ($isNew) {
                    Log::trace("Create new CountryProfile #" . $model->id);
                }else {
                    Log::trace("Update CountryProfile data #" . $id);
                }
                $model->sendNotification();
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' saved successfully');
            } else {
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not saved');
            }
            return $this->redirect(['index']);
        }
        Log::trace("Open business unit form");
        return $this->render('form', ['model' => $model]);
    }

    public function actionDelete($id){
        $model = CountryProfile::find()->where(['id' => $id])->one();
        if ($model !== null) {
            if ($model->delete()) {
                Log::trace("CountryProfile deleted #" . $id);
               $model->sendNotification();
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' deleted successfully');
            } else {
                Log::trace("CountryProfile not deleted #" . $id);
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not deleted');
            }
        } else {
            Log::trace("CountryProfile not found to delete #" . $id);
            \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not found');
        }
        return $this->redirect(['index']);
    }
}
