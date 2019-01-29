<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 01/28/2019
 * Time: 02:20 PM
 */

namespace backend\controllers;

use cnd\admin\models\activerecords\Log;
use cnd\grid\DataLocator;
use common\models\Exhibition;
use Yii;
use cnd\core\components\SController;

class ExhibitionController extends SController
{

    public function actionIndex()
    {
        /**
         * @var $dataLocator DataLocator
         */
        $dataLocator = DataLocator::create(Exhibition::className(), [
            'orderBy' => 'updated_at DESC, created_at DESC, id DESC',
        ]);
        Log::trace("Show Exhibitions List (page:" . $dataLocator->page . ", count: " . $dataLocator->pageSize . ")");
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('index', ['dataLocator' => $dataLocator]);
        }
        return $this->render('index', ['dataLocator' => $dataLocator]);
    }

    public function actionManage($id = null)
    {
        $model = Exhibition::findOne($id);
        if (!$model) {
            $model = new Exhibition();
        }
        if ($model === null) {
            throw new \yii\web\HttpException(404, 'The requested exhibition could not be found.');
        }
        $isNew = $model->isNewRecord;
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' saved successfully');
            } else {
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not saved');
            }
            if ($isNew) {
                Log::trace("Create new exhibition #" . $model->id);
            }else {
                Log::trace("Update exhibition #" . $id);
            }
            return $this->redirect(['index']);
        }
        Log::trace("Open exhibition form");
        return $this->render('form', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = Exhibition::find()->where(['id' => $id])->one();
        if ($model !== null) {
            if ($model->delete()) {
                Log::trace("Exhibition deleted #" . $id);
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' deleted successfully');
            } else {
                Log::trace("Exhibition not deleted #" . $id);
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not deleted');
            }
        } else {
            Log::trace("Exhibition not found to delete #" . $id);
            \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not found');
        }
        return $this->redirect(['index']);
    }

}
