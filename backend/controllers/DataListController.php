<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/6/2019
 * Time: 4:02 PM
 */

namespace backend\controllers;

use Yii;
use cnd\admin\models\activerecords\Log;
use cnd\core\components\SController;
use cnd\grid\DataLocator;
use common\models\DataList;

class DataListController extends SController
{
    public $type;
    public $types = [];
    public $up = null;

    public function beforeAction($action)
    {
        $m = new DataList();
        $this->type = DataList::TYPE_COUNTRY;
        $this->types = $m->type_list;
        if (Yii::$app->request->get('t') && array_key_exists(Yii::$app->request->get('t'), $m->type_list)) {
            $this->type = Yii::$app->request->get('t');
        }
        if (Yii::$app->request->get('u')) {
            $this->up = Yii::$app->request->get('u');
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        /**
         * @var $dataLocator DataLocator
         */
        $dataLocator = DataLocator::create(DataList::className(), [
            'orderBy' => 'name ASC',
            'params' => [
                't' => $this->type,
                'u' => $this->up,
            ],
        ], function ($dl, $query) {
            $query->andWhere(['type' => $this->type, 'parent_id' => $this->up]);
        });
        Log::trace("Show data List (page:" . $dataLocator->page . ", count: " . $dataLocator->pageSize . ")");
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('index', ['dataLocator' => $dataLocator]);
        }
        return $this->render('index', ['dataLocator' => $dataLocator]);
    }

    public function actionManage($id = null)
    {
        $model = DataList::findOne($id);
        if (!$model) {
            $model = new DataList();
            $model->type = $this->type;
            $model->parent_id = $this->up;
        }
        if ($model === null) {
            throw new \yii\web\HttpException(404, 'The requested data list could not be found.');
        }
        $isNew = $model->isNewRecord;
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' saved successfully');
            } else {
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not saved');
            }
            if ($isNew) {
                Log::trace("Create new data list #" . $model->id);
            } else {
                Log::trace("Update data list #" . $id);
            }
            return $this->redirect(['index', 't' => $this->type, 'u' => $this->up]);
        }
        Log::trace("Open data list form");
        return $this->render('form', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = DataList::find()->where(['id' => $id])->one();
        if ($model !== null) {
            if ($model->delete()) {
                Log::trace("data list deleted #" . $id);
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' deleted successfully');
            } else {
                Log::trace("data list not deleted #" . $id);
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not deleted');
            }
        } else {
            Log::trace("data list not found to delete #" . $id);
            \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not found');
        }
        return $this->redirect(['index', 't' => $this->type, 'u' => $this->up]);
    }
}
