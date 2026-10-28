<?php


namespace backend\controllers;

use cnd\admin\models\activerecords\Log;
use common\models\Directory;
use Yii;
use cnd\core\components\SController;
use cnd\grid\DataLocator;

class DirectoryController extends SController
{
    public function actionIndex()
    {
        /**
         * @var $dataLocator DataLocator
         */
        $dataLocator = DataLocator::create(Directory::className(), [
            'orderBy' => 'updated_at DESC, created_at DESC, id DESC',
            'pageSize' => 20,
        ]);
        Log::trace("Show Directory List (page:" . $dataLocator->page . ", count: " . $dataLocator->pageSize . ")");
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('index', ['dataLocator' => $dataLocator]);
        }
        return $this->render('index', ['dataLocator' => $dataLocator]);
    }

    public function actionManage($id = null)
    {
        $model = Directory::findOne($id);
        if (!$model) {
            $model = new Directory();
        }
        if ($model === null) {
            throw new \yii\web\HttpException(404, 'The requested Directory could not be found.');
        }
        $isNew = $model->isNewRecord;
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                $model->sendNotification();
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' saved successfully');
            } else {
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not saved');
            }
            if ($isNew) {
                
                Log::trace("Create new Directory unit #" . $model->id);
            } else {
                Log::trace("Update Directory unit data #" . $id);
            }
            
            return $this->redirect(['index']);
        }
        Log::trace("Open Directory form");
        return $this->render('form', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = Directory::find()->where(['id' => $id])->one();
        if ($model !== null) {
            if ($model->delete()) {
                $model->sendNotification();
                Log::trace("Directory deleted #" . $id);
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' deleted successfully');
            } else {
                Log::trace("Directory not deleted #" . $id);
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not deleted');
            }
        } else {
            Log::trace("Directory not found to delete #" . $id);
            \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not found');
        }
        return $this->redirect(['index']);
    }

    public function actionFindDirectory($q, $page = 1){
        Yii::$app->response->format = 'json';
        $response = [];
        $total = Directory::find()->count();

        $query = Directory::find();
        $query->andWhere('Title like "%' . $q . '%"');
        $query->limit(30);
        $query->offset(($page - 1) * 30);
        $list = $query->all();

        if (!empty($list) && is_array($list)) {
            foreach ($list as $model) {
                $response[] = [
                    'id' => $model->id,
                    'text' => $model->title,
                ];
            }
        }
        return ['items' => $response, 'total_count' => $total];
    }

    public function actionAddNews(){
        Yii::$app->response->format = 'json';
        $title = Yii::$app->request->post('title');
       
        $model = new Directory();
        $model->title = $title;
       
        if ($model->save()) {
            return ['id' => $model->id];
         
        }
        return null;
    }
}
