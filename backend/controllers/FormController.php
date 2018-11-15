<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11/15/2018
 * Time: 2:30 PM
 */

namespace backend\controllers;

use common\models\Form;
use Yii;
use cnd\core\components\SController;

class FormController extends SController
{
    public function actionIndex(){
        $dataLocator = \cnd\grid\DataLocator::create(Form::className(), [
            'orderBy' => 'updated_at DESC, created_at DESC, id DESC',
        ]);
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('index', ['dataLocator' => $dataLocator]);
        }
        return $this->render('index', ['dataLocator' => $dataLocator]);
    }

    public function actionManageMetaData($id = null){
        $model = Form::findOne($id);
        if(!$model){
            $model = new Form();
        }
        if ($model === null) {
            throw new \yii\web\HttpException(404, 'The requested form could not be found.');
        }
        $isNew = $model->isNewRecord;
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' saved successfully');
            } else {
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not saved');
            }
            if($isNew){
                return $this->redirect(['manage-structure','id'=>$model->id]);
            }
            return $this->redirect(['index']);
        }
        return $this->render('form-meta-data', ['model' => $model]);
    }

    public function actionManageStructure($id){
        $model = Form::findOne($id);
        if ($model === null) {
            throw new \yii\web\HttpException(404, 'The requested form could not be found.');
        }
        if(Yii::$app->request->isPost && Yii::$app->request->isAjax){
            Yii::$app->response->format = "json";
            $response = [
                "done" => false,
            ];

            return $response;
        }
        return $this->render('form-structure',['model'=>$model]);
    }

    public function actionDelete($id){
        $model = Form::find()->where(['id' => $id])->one();
        if ($model !== null) {
            if ($model->delete()) {
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' deleted successfully');
            } else {
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not deleted');
            }
        } else {
            \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not found');
        }
        return $this->redirect(['index']);
    }
}