<?php

namespace common\models;

use cnd\core\components\ActiveRecord;
use Yii;

/**
 * This is the model class for table "{{%role_approval_user}}".
 *
 * @property int $id
 * @property int $role_approval_id
 * @property int $user_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $user
 * @property RoleApproval $roleApproval
 */
class RoleApprovalUser extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%role_approval_user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(),[
            [['role_approval_id', 'user_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoleApproval()
    {
        return $this->hasOne(RoleApproval::className(), ['id' => 'role_approval_id']);
    }

    /**
     * {@inheritdoc}
     * @return RoleApprovalUserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RoleApprovalUserQuery(get_called_class());
    }
}
