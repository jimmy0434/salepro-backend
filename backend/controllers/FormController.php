<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11/15/2018
 * Time: 2:30 PM
 */

namespace backend\controllers;

use common\models\Form;
use common\models\FormApproval;
use common\models\FormApprovalUser;
use common\models\RoleApproval;
use Yii;
use cnd\core\components\SController;
use yii\db\Exception;
use yii\helpers\Json;
use yii\helpers\Url;

class FormController extends SController
{
    public function actionIndex()
    {
        Url::remember();
        $dataLocator = \cnd\grid\DataLocator::create(Form::className(), [
            'orderBy' => 'updated_at DESC, created_at DESC, id DESC',
        ]);
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('index', ['dataLocator' => $dataLocator]);
        }
        return $this->render('index', ['dataLocator' => $dataLocator]);
    }

    public function actionManageMetaData($id = null)
    {
        $model = Form::findOne($id);
        if (!$model) {
            $model = new Form();
            $model->status = Form::STATUS_INACTIVE;
            $model->setScenario('create');
        }
        if ($model === null) {
            throw new \yii\web\HttpException(404, 'The requested form could not be found.');
        }
        $isNew = $model->isNewRecord;
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' saved successfully');
            } else {
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not saved');
            }
            if ($isNew) {
                return $this->redirect(['manage-structure', 'id' => $model->id]);
            }
            return $this->redirect(['index']);
        }
        return $this->render('form-meta-data', ['model' => $model]);
    }

    public function actionManageStructure($id)
    {
        Url::remember();
        $model = Form::findOne($id);
        if ($model === null) {
            throw new \yii\web\HttpException(404, 'The requested form could not be found.');
        }
        if (Yii::$app->request->isPost && Yii::$app->request->isAjax) {
            Yii::$app->response->format = "json";
            $form = Yii::$app->request->post("form");
            $model->structure = $form;
            if (!$model->version) {
                $model->version = 0;
            }
            if ($model->getOldAttribute('structure') != Json::encode($model->structure)) {
                $model->version++;
                $model->status = Form::STATUS_PENDING;
                $model->synchronizeTables();
            }
            $model->save();
            $response = [
                "done" => true,
                'structure' => $model->structure,
            ];

            return $response;
        }
        return $this->render('form-structure', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = Form::find()->where(['id' => $id])->one();
        if ($model !== null) {
            if ($model->delete()) {
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' deleted successfully');
            } else {
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not deleted');
            }
        } else {
            \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not found');
        }
        return $this->redirect(['index']);
    }

    public function actionPublishRequest($id){
        $model = Form::findOne($id);
        if($model && $model->status != Form::STATUS_ACTIVE) {
            $roleId = Yii::$app->user->identity->role_id;
            if (!$roleId) {
                $roleId = 1;
            }
            if ($roleId > 0) {
                $exist = FormApproval::find()->where(['role_approval_id' => $roleId, 'form_id' => $id, 'status' => FormApproval::STATUS_PENDING])->one();
                if (!$exist) {
                    $approval = RoleApproval::findOne($roleId);
                    if ($approval) {
                        $transaction = Yii::$app->db->beginTransaction();
                        try {
                            $request = new FormApproval();
                            $request->role_approval_id = $approval->id;
                            $request->form_id = $id;
                            $request->user_id = Yii::$app->user->identity->id;
                            $request->type = $approval->type;
                            $request->status = FormApproval::STATUS_PENDING;
                            if ($request->save()) {
                                $users = $approval->roleApprovalUsers;
                                if (!empty($users) && is_array($users)) {
                                    if($approval->type == RoleApproval::TYPE_PARALLEL) {
                                        foreach ($users as $assignedUser) {
                                            $request->assignUser($assignedUser, $model);
                                        }
                                    }else if($approval->type == RoleApproval::TYPE_SERIES){
                                        reset($users);
                                        $k = key($users);
                                        $assignedUser = $users[$k];
                                        $request->assignUser($assignedUser, $model);
                                    }
                                }
                                $transaction->commit();
                                \Yii::$app->session->setFlash('success', 'Form in review mode');
                            } else {
                                throw new Exception("FormApproval not saved");
                            }
                        } catch (\Throwable $t) {
                            $transaction->rollBack();
                            \Yii::$app->session->setFlash('error', "Error Occurred");
                        } catch (\Exception $e) {
                            $transaction->rollBack();
                            \Yii::$app->session->setFlash('error', "Error Occurred");
                        }
                    } else {
                        \Yii::$app->session->setFlash('error', 'No approval defined');
                    }
                } else {
                    \Yii::$app->session->setFlash('warning', 'Request already in review');
                }
            } else {
                \Yii::$app->session->setFlash('error', 'You do not have role related to your account');
            }
        }else{
            \Yii::$app->session->setFlash('error', 'Form not found or it is active');
        }
        return $this->goBack();
    }
}