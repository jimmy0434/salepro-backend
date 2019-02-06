<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/4/2019
 * Time: 3:19 PM
 */

namespace backend\controllers;

use Yii;
use cnd\admin\models\activerecords\Log;
use cnd\core\components\SController;
use cnd\grid\DataLocator;
use common\models\SalesOffice;

class SalesOfficeController extends SController
{
    public function actionIndex()
    {
        /**
         * @var $dataLocator DataLocator
         */
        $dataLocator = DataLocator::create(SalesOffice::className(), [
            'orderBy' => 'updated_at DESC, created_at DESC, id DESC',
        ]);
        Log::trace("Show SalesOffice List (page:" . $dataLocator->page . ", count: " . $dataLocator->pageSize . ")");
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('index', ['dataLocator' => $dataLocator]);
        }
        return $this->render('index', ['dataLocator' => $dataLocator]);
    }

    public function actionManage($id = null)
    {
        $model = SalesOffice::findOne($id);
        if (!$model) {
            $model = new SalesOffice();
        }
        if ($model === null) {
            throw new \yii\web\HttpException(404, 'The requested SalesOffice could not be found.');
        }
        $isNew = $model->isNewRecord;
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' saved successfully');
            } else {
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not saved');
            }
            if ($isNew) {
                Log::trace("Create new SalesOffice #" . $model->id);
            } else {
                Log::trace("Update SalesOffice #" . $id);
            }
            return $this->redirect(['index']);
        }
        Log::trace("Open SalesOffice form");
        return $this->render('form', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = SalesOffice::find()->where(['id' => $id])->one();
        if ($model !== null) {
            if ($model->delete()) {
                Log::trace("SalesOffice deleted #" . $id);
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' deleted successfully');
            } else {
                Log::trace("SalesOffice not deleted #" . $id);
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not deleted');
            }
        } else {
            Log::trace("SalesOffice not found to delete #" . $id);
            \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not found');
        }
        return $this->redirect(['index']);
    }

    public function actionFindOffices($q,$page = 1){
        Yii::$app->response->format = 'json';
        $response = [];
        $total = SalesOffice::find()->count();

        $query = SalesOffice::find();
        $query->andWhere('name like "%'.$q.'%" or content like "%'.$q.'%"');
        $query->limit(30);
        $query->offset(($page - 1)*30);
        $list = $query->all();

        if(!empty($list) && is_array($list)){
            foreach($list as $model){
                $response[] = [
                    'id' => $model->id,
                    'text' => $model->title,
                ];
            }
        }
        return ['items'=>$response,'total_count'=>$total];
    }

    public function actionAddOffice(){
        Yii::$app->response->format = 'json';
        $name = Yii::$app->request->post('name');
        $model = new SalesOffice();
        $model->name = $name;
        $model->save();
        return ['id'=>$model->id];
    }
}
