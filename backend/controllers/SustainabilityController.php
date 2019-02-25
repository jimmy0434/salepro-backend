<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/4/2019
 * Time: 2:56 PM
 */

namespace backend\controllers;

use common\models\SustainabilityQuery;
use Yii;
use cnd\admin\models\activerecords\Log;
use cnd\core\components\SController;
use cnd\grid\DataLocator;
use common\models\Sustainability;

class SustainabilityController extends SController
{

    public $types = [];
    public $type = null;

    public function beforeAction($action)
    {
        $model = new Sustainability();
        $this->types = $model->type_list;
        $this->type = Sustainability::TYPE_DOWNLOAD_FILE;
        if(Yii::$app->request->get('t') && array_key_exists(Yii::$app->request->get('t'), $this->types)){
            $this->type = Yii::$app->request->get('t');
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        /**
         * @var $dataLocator DataLocator
         */
        $dataLocator = DataLocator::create(Sustainability::className(), [
            'orderBy' => 'position ASC, updated_at DESC, created_at DESC, id DESC',
            'pageSize' => 20,
        ], function($dl, $query){
            assert($dl instanceof DataLocator);
            assert($query instanceof SustainabilityQuery);
            $query->andWhere(['type'=>$this->type]);
        });
        Log::trace("Show Sustainability List (page:" . $dataLocator->page . ", count: " . $dataLocator->pageSize . ")");
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('index', ['dataLocator' => $dataLocator]);
        }
        return $this->render('index', ['dataLocator' => $dataLocator]);
    }

    public function actionManage($id = null)
    {
        $model = Sustainability::findOne($id);
        if (!$model) {
            $model = new Sustainability();
            $model->type = $this->type;
        }
        if ($model === null) {
            throw new \yii\web\HttpException(404, 'The requested Sustainability could not be found.');
        }
        $isNew = $model->isNewRecord;
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' saved successfully');
            } else {
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not saved');
            }
            if ($isNew) {
                Log::trace("Create new Sustainability #" . $model->id);
            }else {
                Log::trace("Update Sustainability #" . $id);
            }
            return $this->redirect(['index','t'=>$this->type]);
        }
        Log::trace("Open Sustainability form");
        return $this->render('form', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = Sustainability::find()->where(['id' => $id])->one();
        if ($model !== null) {
            if ($model->delete()) {
                Log::trace("Sustainability deleted #" . $id);
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' deleted successfully');
            } else {
                Log::trace("Sustainability not deleted #" . $id);
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not deleted');
            }
        } else {
            Log::trace("Sustainability not found to delete #" . $id);
            \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not found');
        }
        return $this->redirect(['index','t'=>$this->type]);
    }
}
