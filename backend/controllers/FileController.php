<?php
/**
 * Created by PhpStorm.
 * User: JawdatSobh
 * Date: 08/11/2018
 * Time: 16:43
 */

namespace backend\controllers;

use cnd\admin\models\activerecords\Log;
use cnd\cms\models\activerecords\Content;
use cnd\grid\DataLocator;
use common\models\File;
use common\models\FilePartition;
use common\models\User;
use Yii;
use cnd\core\components\SController;
use yii\helpers\ArrayHelper;

class FileController extends SController
{
    public function actionIndex()
    {
        /**
         * @var $dataLocator DataLocator
         */
        $dataLocator = DataLocator::create(File::className(), [
            'orderBy' => 'updated_at DESC, created_at DESC, id DESC',
        ]);
        Log::trace("Show Files List (page:" . $dataLocator->page . ", count: " . $dataLocator->pageSize . ")");
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('index', ['dataLocator' => $dataLocator]);
        }
        return $this->render('index', ['dataLocator' => $dataLocator]);
    }

    public function actionManageMetaData($id = null)
    {
        $model = File::findOne($id);
        if (!$model) {
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
            if ($isNew) {
                Log::trace("Create new file meta data #" . $model->id);
                return $this->redirect(['manage-upload', 'id' => $model->id]);
            }
            Log::trace("Update file meta data #" . $id);
            return $this->goBack();
        }
        Log::trace("Open file meta data form");
        return $this->render('form-meta-data', ['model' => $model]);
    }

    public function actionManageUpload($id)
    {
        $model = File::findOne($id);
        if ($model === null) {
            throw new \yii\web\HttpException(404, 'The requested file could not be found.');
        }
        if (Yii::$app->request->isPost && Yii::$app->request->isAjax) {
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
            $encryptedData = explode('base64,', $chunk);
            $encryptedData = Yii::$app->getSecurity()->encryptByPassword(base64_decode($encryptedData[1]), $secretKey);

            // remove old file version
            if (!$order) {
                $oldItems = FilePartition::find()->where(['file_id' => $model->id])->andWhere(['!=', 'version', $version])->all();
                if (!empty($oldItems) && is_array($oldItems)) {
                    foreach ($oldItems as $oldItem) {
                        $oldItem->delete();
                    }
                    Log::trace("Remove old version of file #" . $model->id . " [" . $model->title . "]");
                }
            }

            // create new partition
            $partition = new FilePartition();
            $partition->file_id = $model->id;
            $partition->version = $version;
            $partition->order = $order;
            $partition->extension = $extension;
            $partition->data = $encryptedData;
            if ($partition->save()) {
                $response["done"] = true;
                if ($order == $count - 1) {
                    $model->version = $version;
                    $model->extension = $extension;
                    $model->status = File::STATUS_ACTIVE;
                    $model->save(false);
                    $users = array_values(ArrayHelper::map(User::find()->where(['type' => User::TYPE_SALESMAN, 'status' => User::STATUS_ACTIVE])->all(), 'id', 'id'));
                    if (!empty($users) && is_array($users)) {
                        Yii::$app->notification->send('file-update', [
                            'message' => 'The File `' . $model->title . '`` was updated',
                            'id' => $model->id,
                        ], $users);
                    }
                }
                Log::trace("Upload new chunk number " . $order . " of version " . $version . " of file #" . $id);
            }
            return $response;
        }
        Log::trace("Open file upload form #" . $id);
        return $this->render('form-upload', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = File::find()->where(['id' => $id])->one();
        if ($model !== null) {
            if ($model->delete()) {
                Log::trace("File deleted #" . $id);
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' deleted successfully');
            } else {
                Log::trace("File not deleted #" . $id);
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not deleted');
            }
        } else {
            Log::trace("File not found to delete #" . $id);
            \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not found');
        }
        return $this->goBack();
    }

    public function actionDownload($id)
    {
        $model = File::find()->where(['id' => $id])->one();
        if ($model !== null) {
            $partitions = FilePartition::find()->where(['file_id' => $model->id, 'version' => $model->version])->orderby(['order' => SORT_ASC])->all();
            $data = '';
            $extension = null;
            if (!empty($partitions) && is_array($partitions)) {
                foreach ($partitions as $partition) {
                    $extension = $partition->extension;
                    $secretKey = Yii::$app->secretKey($partition->file_id, $partition->order);
                    $data .= Yii::$app->getSecurity()->decryptByPassword($partition->data, $secretKey);
                }
            }
            if ($data) {
                Log::trace("Download File #" . $id);
                header("Content-type:application/pdf");
                // It will be called downloaded.pdf
                header("Content-Disposition:attachment;filename=" . $this->createSlug($model->title) . '-' . $model->version . "." . $extension);
                echo $data;
                exit(0);
            }
        }
        \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not found');
        return $this->goBack();
    }

    public function createSlug($str, $delimiter = '-')
    {

        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
        return $slug;

    }

    public function actionPopupManagement()
    {
        $id = Yii::$app->request->get('id');
        $title = Yii::$app->request->get('title');
        $this->layout = '@backend/views/layout/dialog.php';
        if (!$id) {
            $model = new File();
            $model->title = $title;
            $model->status = File::STATUS_DRAFT;
            $model->save();
            $id = $model->id;
        }
        return $this->actionManageUpload($id);
    }
}
