<?php

namespace common\models;

use cnd\core\components\ActiveRecord;
use Yii;

/**
 * This is the model class for table "{{%form_approval}}".
 *
 * @property int $id
 * @property int $role_approval_id
 * @property int $form_id
 * @property int $type
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Form $form
 * @property RoleApproval $roleApproval
 * @property FormApprovalUser[] $formApprovalUsers
 */
class FormApproval extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%form_approval}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(),[
            [['role_approval_id', 'form_id', 'type', 'status'], 'integer'],
            [['form_id'], 'exist', 'skipOnError' => true, 'targetClass' => Form::className(), 'targetAttribute' => ['form_id' => 'id']],
            [['role_approval_id'], 'exist', 'skipOnError' => true, 'targetClass' => RoleApproval::className(), 'targetAttribute' => ['role_approval_id' => 'id']],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_approval_id' => 'Role Approval ID',
            'form_id' => 'Form ID',
            'type' => 'Type',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForm()
    {
        return $this->hasOne(Form::className(), ['id' => 'form_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoleApproval()
    {
        return $this->hasOne(RoleApproval::className(), ['id' => 'role_approval_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormApprovalUsers()
    {
        return $this->hasMany(FormApprovalUser::className(), ['form_approval_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return FormApprovalQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FormApprovalQuery(get_called_class());
    }
}
