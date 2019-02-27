<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/27/2019
 * Time: 10:20 AM
 */

namespace backend\controllers;

use cnd\admin\models\activerecords\Log;
use common\models\Certification;
use Yii;
use cnd\core\components\SController;
use cnd\grid\DataLocator;

class CertificationController extends SController
{
    public function actionIndex()
    {
        /**
         * @var $dataLocator DataLocator
         */
        $dataLocator = DataLocator::create(Certification::className(), [
            'orderBy' => 'updated_at DESC, created_at DESC, id DESC',
            'pageSize' => 20,
        ]);
        Log::trace("Show Certifications List (page:" . $dataLocator->page . ", count: " . $dataLocator->pageSize . ")");
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('index', ['dataLocator' => $dataLocator]);
        }
        return $this->render('index', ['dataLocator' => $dataLocator]);
    }

    public function actionManage($id = null)
    {
        $model = Certification::findOne($id);
        if (!$model) {
            $model = new Certification();
        }
        if ($model === null) {
            throw new \yii\web\HttpException(404, 'The requested certification could not be found.');
        }
        $isNew = $model->isNewRecord;
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' saved successfully');
            } else {
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not saved');
            }
            if ($isNew) {
                Log::trace("Create new certification unit #" . $model->id);
            } else {
                Log::trace("Update certification unit data #" . $id);
            }
            return $this->redirect(['index']);
        }
        Log::trace("Open certification form");
        return $this->render('form', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = Certification::find()->where(['id' => $id])->one();
        if ($model !== null) {
            if ($model->delete()) {
                Log::trace("Business unit deleted #" . $id);
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' deleted successfully');
            } else {
                Log::trace("Certification not deleted #" . $id);
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not deleted');
            }
        } else {
            Log::trace("Certification not found to delete #" . $id);
            \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not found');
        }
        return $this->redirect(['index']);
    }

    public function actionFindCertifications($q, $page = 1){
        Yii::$app->response->format = 'json';
        $response = [];
        $total = Certification::find()->count();

        $query = Certification::find();
        $query->andWhere('name like "%' . $q . '%"');
        $query->limit(30);
        $query->offset(($page - 1) * 30);
        $list = $query->all();

        if (!empty($list) && is_array($list)) {
            foreach ($list as $model) {
                $response[] = [
                    'id' => $model->id,
                    'text' => $model->name,
                ];
            }
        }
        return ['items' => $response, 'total_count' => $total];
    }

    public function actionAddCertification(){
        Yii::$app->response->format = 'json';
        $name = Yii::$app->request->post('name');
        $model = new Certification();
        $model->name = $name;
        if ($model->save()) {
            return ['id' => $model->id];
        }
        return null;
    }
}
