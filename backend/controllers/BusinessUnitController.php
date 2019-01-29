<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 1/29/2019
 * Time: 9:37 AM
 */

namespace backend\controllers;

use Yii;
use cnd\admin\models\activerecords\Log;
use cnd\core\components\SController;
use cnd\grid\DataLocator;
use common\models\BusinessUnit;

class BusinessUnitController extends SController
{
    public function actionIndex(){
        /**
         * @var $dataLocator DataLocator
         */
        $dataLocator = DataLocator::create(BusinessUnit::className(), [
            'orderBy' => 'updated_at DESC, created_at DESC, id DESC',
        ]);
        Log::trace("Show Business Units List (page:" . $dataLocator->page . ", count: " . $dataLocator->pageSize . ")");
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('index', ['dataLocator' => $dataLocator]);
        }
        return $this->render('index', ['dataLocator' => $dataLocator]);
    }

    public function actionManage($id = null){
        $model = BusinessUnit::findOne($id);
        if (!$model) {
            $model = new BusinessUnit();
        }
        if ($model === null) {
            throw new \yii\web\HttpException(404, 'The requested business unit could not be found.');
        }
        $isNew = $model->isNewRecord;
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' saved successfully');
            } else {
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not saved');
            }
            if ($isNew) {
                Log::trace("Create new business unit #" . $model->id);
            }else {
                Log::trace("Update business unit data #" . $id);
            }
            return $this->redirect(['index']);
        }
        Log::trace("Open business unit form");
        return $this->render('form', ['model' => $model]);
    }

    public function actionDelete($id){
        $model = BusinessUnit::find()->where(['id' => $id])->one();
        if ($model !== null) {
            if ($model->delete()) {
                Log::trace("Business unit deleted #" . $id);
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' deleted successfully');
            } else {
                Log::trace("Business unit not deleted #" . $id);
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not deleted');
            }
        } else {
            Log::trace("Business unit not found to delete #" . $id);
            \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not found');
        }
        return $this->redirect(['index']);
    }
}
