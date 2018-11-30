<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11/30/2018
 * Time: 12:44 PM
 */

namespace backend\controllers;

use common\models\RoleApproval;
use common\models\RoleApprovalUser;
use common\models\User;
use Yii;
use cnd\core\components\SController;
use yii\helpers\ArrayHelper;

class ApprovalController extends SController
{
    public function actionRole($id){
        $model = RoleApproval::findOne($id);
        if(!$model){
            $model = new RoleApproval();
            $model->id = $id;
        }
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                $users = $model->roleApprovalUsers;
                if(!empty($users) && is_array($users)){
                    foreach($users as $user){
                        $user->delete();
                    }
                }
                if(!empty($model->users) && is_array($model->users)){
                    foreach($model->users as $userId){
                        $user = new RoleApprovalUser();
                        $user->role_approval_id = $model->id;
                        $user->user_id = $userId;
                        $user->save();
                    }
                }
                \Yii::$app->session->setFlash('success', ucfirst($this->id) . ' role saved successfully');
            } else {
                \Yii::$app->session->setFlash('error', ucfirst($this->id) . ' role not saved');
            }
            return $this->redirect(['/admin/role/manage','id'=>$model->id]);
        }
        $users = $model->autoCompleteUsers;
        if(empty($model->users)){
            $model->users = array_keys(ArrayHelper::map($users,'id', null));
        }
        return $this->render('role', ['model' => $model, 'users'=>$users]);
    }

    public function actionFindUser($q,$page = 1){
        Yii::$app->response->format = 'json';
        $response = [];
        $queryCount = User::find();
        $queryCount->where(['in','type',[User::TYPE_ROOT,User::TYPE_ADMIN]]);
        $total = $queryCount->count() + 1;

        $query = User::find();
        $query->where(['in','type',[User::TYPE_ROOT,User::TYPE_ADMIN]]);
        $query->andWhere('name like "%'.$q.'%"');
        $query->limit(30);
        $query->offset(($page - 1)*30);

        $list = $query->all();
        if(!empty($list) && is_array($list)){
            foreach($list as $user){
                $response[] = [
                    'id' => $user->id,
                    'text' => $user->profile->userName,
                    'full_name' => $user->profile->userName,
                    'url' => $user->profile->userImage,
                ];
            }
        }
        return ['items'=>$response,'total_count'=>$total];
    }
}