<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%form_approval_user}}".
 *
 * @property int $id
 * @property int $form_approval_id
 * @property int $user_id
 * @property int $status
 * @property string $message
 * @property int $created_at
 * @property int $updated_at
 *
 * @property FormApproval $formApproval
 * @property User $user
 */
class FormApprovalUser extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%form_approval_user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(),[
            [['form_approval_id', 'user_id', 'status'], 'integer'],
            [['form_approval_id'], 'exist', 'skipOnError' => true, 'targetClass' => FormApproval::className(), 'targetAttribute' => ['form_approval_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'form_approval_id' => 'Form Approval ID',
            'user_id' => 'User ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormApproval()
    {
        return $this->hasOne(FormApproval::className(), ['id' => 'form_approval_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return FormApprovalUserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FormApprovalUserQuery(get_called_class());
    }
}
