<?php
/**
 * Created by PhpStorm.
 * User: JawdatSobh
 * Date: 08/11/2018
 * Time: 16:43
 */

namespace backend\controllers;

use common\models\File;
use common\models\FilePartition;
use Yii;
use cnd\core\components\SController;

class FileController extends SController
{
    public function actionIndex(){
        $dataLocator = \cnd\grid\DataLocator::create(File::className(), [
            'orderBy' => 'updated_at DESC, created_at DESC, id DESC',
        ]);
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('index', ['dataLocator' => $dataLocator]);
        }
        return $this->render('index', ['dataLocator' => $dataLocator]);
    }

    public function actionManageMetaData($id = null){
        $model = File::findOne($id);
        if(!$model){
            $model = new File();
        }
        if ($model === null) {
            throw new \yii\web\HttpException(404, 'The requested file could not be found.');
        }
        $isNew = $model->isNewRecord;
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' saved successfully');
            } else {
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not saved');
            }
            if($isNew){
                return $this->redirect(['manage-upload','id'=>$model->id]);
            }
            return $this->redirect(['index']);
        }
        return $this->render('form-meta-data', ['model' => $model]);
    }

    public function actionManageUpload($id){
        $model = File::findOne($id);
        if ($model === null) {
            throw new \yii\web\HttpException(404, 'The requested file could not be found.');
        }
        if(Yii::$app->request->isPost && Yii::$app->request->isAjax){
            Yii::$app->response->format = "json";
            $response = [
                "done" => false,
            ];
            $version = Yii::$app->request->post('version');
            $order = Yii::$app->request->post('order');
            $count = Yii::$app->request->post('count');
            $extension = Yii::$app->request->post('extension');
            $chunk = Yii::$app->request->post('chunk');
            $secretKey = Yii::$app->secretKey($id, $order);
            $chunk = mb_convert_encoding($chunk, 'UTF-8', 'UTF-8');
            $encryptedData = explode('base64,',$chunk);
            $encryptedData = Yii::$app->getSecurity()->encryptByPassword(base64_decode($encryptedData[1]), $secretKey);
            $partition = new FilePartition();
            $partition->file_id = $model->id;
            $partition->version = $version;
            $partition->order = $order;
            $partition->extension = $extension;
            $partition->data = $encryptedData;
            if($partition->save()){
                $response["done"] = true;
                if($order == $count - 1) {
                    $model->version = $version;
                    $model->extension = $extension;
                    $model->save(false);
                }
            }
            return $response;
        }
        return $this->render('form-upload',['model'=>$model]);
    }

    public function actionDelete($id){
        $model = File::find()->where(['id' => $id])->one();
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

    public function actionDownload($id){
        $model = File::find()->where(['id' => $id])->one();
        if ($model !== null) {
            $partitions = FilePartition::find()->where(['file_id' => $model->id,'version'=>$model->version])->orderby(['order' => SORT_ASC])->all();
            $data = '';
            $extension = null;
            if (!empty($partitions) && is_array($partitions)) {
                foreach ($partitions as $partition) {
                    $extension = $partition->extension;
                    $secretKey = Yii::$app->secretKey($partition->file_id, $partition->order);
                    $data .= Yii::$app->getSecurity()->decryptByPassword($partition->data, $secretKey);
                }
            }
            if($data) {
                header("Content-type:application/pdf");
                // It will be called downloaded.pdf
                header("Content-Disposition:attachment;filename=" . $this->createSlug($model->title). '-' . $model->version . "." . $extension);
                echo $data;
                exit(0);
            }
        }
        \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not found');
        return $this->redirect(['index']);
    }

    public function createSlug($str, $delimiter = '-'){

        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
        return $slug;

    }
}