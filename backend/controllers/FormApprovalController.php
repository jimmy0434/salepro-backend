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

use cnd\admin\models\activerecords\Log;
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
        Log::trace("Show Forms Approval Requests List (page:" . $dataLocator->page . ", count: " . $dataLocator->pageSize . ")");
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
                    Log::trace("Form #".$model->formApproval->form->id." has been ".$model->formApproval->status_label);
                    $model->formApproval->nextApprove($model);
                }
                return $this->redirect(['index']);
            }
            Log::trace("View form approval details #".$model->formApproval->id." / #".$id." of form #".$model->formApproval->form->id);
            return $this->render('view', ['model' => $model]);
        }
        Log::trace("form approval details #".$id.", record not found [Form Approval User or Form Approval or Form]");
        return $this->redirect(['index']);
    }

    public function actionResponse($id)
    {
        $model = FormApproval::findOne($id);
        if ($model && $model->form && $model->user) {
            Log::trace("View form approval response #".$id." of form #".$model->form->id." of user #".$model->user->id);
            return $this->render('response', ['model' => $model]);
        }
        Log::trace("form approval response #".$id.", record not found [Form Approval or Form or User]");
        return $this->redirect(['index']);
    }
}