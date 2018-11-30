<?php

namespace common\models;

use cnd\admin\models\activerecords\Role;
use cnd\core\components\ActiveRecord;
use Yii;

/**
 * This is the model class for table "{{%role_approval}}".
 *
 * @property int $id
 * @property int $type
 * @property int $created_at
 * @property int $updated_at
 *
 * @property FormApproval[] $formApprovals
 * @property Role $role
 * @property RoleApprovalUser[] $roleApprovalUsers
 * @property array $autoCompleteUsers
 */
class RoleApproval extends ActiveRecord
{

    const TYPE_SERIES = 1;
    const TYPE_PARALLEL = 2;

    public $users = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%role_approval}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(),[
            [['id', 'type'], 'integer'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['id' => 'id']],
            [['users'],'safe'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormApprovals()
    {
        return $this->hasMany(FormApproval::className(), ['role_approval_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoleApprovalUsers()
    {
        return $this->hasMany(RoleApprovalUser::className(), ['role_approval_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return RoleApprovalQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RoleApprovalQuery(get_called_class());
    }

    public function getAutoCompleteUsers(){
        $list = [];
        $models = $this->roleApprovalUsers;
        if(!empty($models) && is_array($models)){
            foreach($models as $model){
                $list[] = [
                    'id' => $model->user_id == null?-1:$model->user_id,
                    'text' => $model->user->profile->userName,
                    'full_name' => $model->user->profile->userName,
                    'url' => $model->user->profile->userImage,
                ];
            }
        }
        return $list;
    }
}
