<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11/15/2018
 * Time: 2:30 PM
 */

namespace backend\controllers;

use cnd\admin\models\activerecords\Log;
use cnd\grid\DataLocator;
use common\models\Form;
use common\models\FormApproval;
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
        /**
         * @var $dataLocator DataLocator
         */
        Url::remember();
        $dataLocator = DataLocator::create(Form::className(), [
            'orderBy' => 'updated_at DESC, created_at DESC, id DESC',
        ]);
        Log::trace("Show Forms List (page:" . $dataLocator->page . ", count: " . $dataLocator->pageSize . ")");
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
                Log::trace("Create new form meta data #" . $model->id);
                return $this->redirect(['manage-structure', 'id' => $model->id]);
            }
            Log::trace("Update form meta data #" . $id);
            return $this->goBack();
        }
        Log::trace("Open form meta data form");
        return $this->render('form-meta-data', ['model' => $model]);
    }

    public function actionManageStructure($id, $dialog = false)
    {
        if($dialog){
            $this->layout = '@backend/views/layout/dialog.php';
        }
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
                Log::trace("Form Structure Updated #" . $id);
            }
            $model->save();
            $response = [
                "done" => true,
                'structure' => $model->structure,
            ];

            return $response;
        }
        Log::trace("Open form builder #" . $id);
        return $this->render('form-structure', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = Form::find()->where(['id' => $id])->one();
        if ($model !== null) {
            if ($model->delete()) {
                Log::trace("Form deleted #" . $id);
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' deleted successfully');
            } else {
                Log::trace("Form not deleted #" . $id);
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not deleted');
            }
        } else {
            Log::trace("Form not found to delete #" . $id);
            \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' not found');
        }
        return $this->goBack();
    }

    public function actionPublishRequest($id)
    {
        $model = Form::findOne($id);
        if ($model && $model->status != Form::STATUS_ACTIVE) {
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
                                    if ($approval->type == RoleApproval::TYPE_PARALLEL) {
                                        foreach ($users as $assignedUser) {
                                            $request->assignUser($assignedUser, $model);
                                        }
                                    } else if ($approval->type == RoleApproval::TYPE_SERIES) {
                                        reset($users);
                                        $k = key($users);
                                        $assignedUser = $users[$k];
                                        $request->assignUser($assignedUser, $model);
                                    }
                                }
                                $transaction->commit();
                                Log::trace("Publish Request: Form #" . $id . " in review mode.");
                                \Yii::$app->session->setFlash('success', 'Form in review mode');
                            } else {
                                throw new Exception("FormApproval not saved");
                            }
                        } catch (\Throwable $t) {
                            $transaction->rollBack();
                            Log::trace("Publish Request: Exception; " . $t->getMessage() . ", Form #" . $id);
                            \Yii::$app->session->setFlash('error', "Error Occurred");
                        } catch (\Exception $e) {
                            $transaction->rollBack();
                            Log::trace("Publish Request: Exception; " . $e->getMessage() . ", Form #" . $id);
                            \Yii::$app->session->setFlash('error', "Error Occurred");
                        }
                    } else {
                        Log::trace("Publish Request: No approval defined, Form #" . $id);
                        \Yii::$app->session->setFlash('error', 'No approval defined');
                    }
                } else {
                    Log::trace("Publish Request: Request already in review, Form #" . $id);
                    \Yii::$app->session->setFlash('warning', 'Request already in review');
                }
            } else {
                Log::trace("Publish Request: You do not have role related to your account, Form #" . $id);
                \Yii::$app->session->setFlash('error', 'You do not have role related to your account');
            }
        } else {
            Log::trace("Publish Request: Form #" . $id . " not found or it is active");
            \Yii::$app->session->setFlash('error', 'Form not found or it is active');
        }
        return $this->goBack();
    }

    public function actionTest($id){
        Yii::$app->response->format = 'json';
        $model = Form::findOne($id);
        $tableName = $model->structure['name'];
        $sql = 'select distinct(user_id), id from '.$tableName;
        $res = Yii::$app->bi->createCommand($sql)->queryAll();
        return $res;
    }
}