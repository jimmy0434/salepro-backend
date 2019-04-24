<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 4/24/2019
 * Time: 9:23 AM
 */

namespace backend\controllers;

use Yii;
use cnd\admin\models\activerecords\Log;
use cnd\core\components\SController;
use cnd\grid\DataLocator;
use common\models\Group;

class GroupController extends SController
{
    public function actionIndex()
    {
        /**
         * @var $dataLocator DataLocator
         */
        $dataLocator = DataLocator::create(Group::className(), [
            'orderBy' => 'name ASC, updated_at DESC, created_at DESC, id DESC',
            'pageSize' => 20,
        ]);
        Log::trace("Show Groups List (page:" . $dataLocator->page . ", count: " . $dataLocator->pageSize . ")");
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('index', ['dataLocator' => $dataLocator]);
        }
        return $this->render('index', ['dataLocator' => $dataLocator]);
    }

    public function actionManage($id = null)
    {
        $model = Group::findOne($id);
        if (!$model) {
            $model = new Group();
        }
        if ($model === null) {
            throw new \yii\web\HttpException(404, 'The requested Group could not be found.');
        }
        $isNew = $model->isNewRecord;
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', ucfirst($this->id) . ' saved successfully');
            } else {
                Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not saved');
            }
            if ($isNew) {
                Log::trace("Create new Group #" . $model->id);
            } else {
                Log::trace("Update Group #" . $id);
            }
            return $this->redirect(['index']);
        }
        Log::trace("Open Group form");
        return $this->render('form', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = Group::find()->where(['id' => $id])->one();
        if ($model !== null) {
            if ($model->delete()) {
                Log::trace("Group deleted #" . $id);
                Yii::$app->session->setFlash('success', ucfirst($this->id) . ' deleted successfully');
            } else {
                Log::trace("Group not deleted #" . $id);
                Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not deleted');
            }
        } else {
            Log::trace("Group not found to delete #" . $id);
            Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not found');
        }
        return $this->redirect(['index']);
    }
}
