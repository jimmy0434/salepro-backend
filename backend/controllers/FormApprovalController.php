<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 12/3/2018
 * Time: 10:34 AM
 */

namespace backend\controllers;

use cnd\grid\DataLocator;
use common\models\FormApprovalQuery;
use common\models\FormApprovalUser;
use common\models\FormApprovalUserQuery;
use Yii;
use cnd\core\components\SController;
use common\models\FormApproval;

class FormApprovalController extends SController
{
    public function actionIndex()
    {
        $dataLocator = DataLocator::create(FormApprovalUser::className(), [
            'orderBy' => 'updated_at DESC, created_at DESC, id DESC',
        ], function ($dl, $query) {
            /**
             * @var $dl DataLocator
             * @var $query FormApprovalQuery
             */
            $query->from(['formApprovalUser' => FormApprovalUser::tableName()]);
            $query->andWhere(['formApprovalUser.status' => FormApproval::STATUS_PENDING]);
            $query->andWhere(['formApprovalUser.user_id' => Yii::$app->user->identity->id]);
            $query->joinWith([
                'formApproval' => function ($query) {
                    /**
                     * @var $query FormApprovalUserQuery
                     */
                    $query->from(['formApproval' => FormApproval::tableName()]);
                }
            ], true, 'INNER JOIN');
        });
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('index', ['dataLocator' => $dataLocator]);
        }
        return $this->render('index', ['dataLocator' => $dataLocator]);
    }

    public function actionView($id)
    {
        $model = FormApprovalUser::findOne($id);
        if ($model && $model->formApproval && $model->formApproval->form) {
            if (Yii::$app->request->isPost) {
                $message = Yii::$app->request->post('message');
                $action = strtolower(Yii::$app->request->post('action'));
                $model->status = $action == 'reject' ? FormApproval::STATUS_REJECTED : FormApproval::STATUS_APPROVED;
                $model->message = $message;
                if ($model->save()) {
                    $model->formApproval->nextApprove($model);
                }
                return $this->redirect(['index']);
            }
            return $this->render('view', ['model' => $model]);
        }
        return $this->redirect(['index']);
    }

    public function actionResponse($id)
    {
        $model = FormApproval::findOne($id);
        if ($model && $model->form && $model->user) {
            return $this->render('response', ['model' => $model]);
        }
        return $this->redirect(['index']);
    }
}