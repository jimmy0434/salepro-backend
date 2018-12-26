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
 * @property int $user_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Form $form
 * @property RoleApproval $roleApproval
 * @property FormApprovalUser[] $formApprovalUsers
 * @property User $user
 */
class FormApproval extends ActiveRecord
{
    const STATUS_PENDING = 10;
    const STATUS_REJECTED = 20;
    const STATUS_APPROVED = 30;

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
        return array_merge(parent::rules(), [
            [['role_approval_id', 'form_id', 'type', 'status'], 'integer'],
            [['form_id'], 'exist', 'skipOnError' => true, 'targetClass' => Form::className(), 'targetAttribute' => ['form_id' => 'id']],
            [['role_approval_id'], 'exist', 'skipOnError' => true, 'targetClass' => RoleApproval::className(), 'targetAttribute' => ['role_approval_id' => 'id']],
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
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return FormApprovalQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FormApprovalQuery(get_called_class());
    }

    /**
     * @param $currentUserApprove FormApprovalUser
     */
    public function nextApprove($currentUserApprove)
    {
        if ($this->type == RoleApproval::TYPE_PARALLEL) {
            $users = $this->formApprovalUsers;
            if (!empty($users) && is_array($users)) {
                $pending = [];
                $rejected = [];
                foreach ($users as $requestedUser) {
                    if ($requestedUser->status == static::STATUS_PENDING) {
                        $pending[] = $requestedUser;
                    } else if ($requestedUser->status == static::STATUS_REJECTED) {
                        $rejected[] = $requestedUser;
                    }
                }
                if (count($pending) == 0) {
                    if (count($rejected) == 0) {
                        $this->status = static::STATUS_APPROVED;
                    } else {
                        $this->status = static::STATUS_REJECTED;
                    }
                    $msg = "your requested publishing form `" . $this->form->title . "` was rejected";
                    if ($this->save() && $this->status == static::STATUS_APPROVED) {
                        $this->form->status = Form::STATUS_ACTIVE;
                        $this->form->save();
                        $msg = "your requested publishing form `" . $this->form->title . "` was approved";
                        $this->notifySalesmen();
                    }
                    Yii::$app->notification->send('form-approval-response', [
                        'message' => $msg,
                        'id' => $this->id,
                    ], [$this->user_id], false, false);
                }
            }
        } else if ($this->type == RoleApproval::TYPE_SERIES) {
            $msg = null;
            if ($currentUserApprove->status == static::STATUS_APPROVED) {
                if ($this->roleApproval) {
                    $users = $this->roleApproval->roleApprovalUsers;
                    foreach ($users as $i => $requestedUser) {
                        if ($requestedUser->user_id == $currentUserApprove->user_id) {
                            if (isset($users[$i + 1])) {
                                $this->assignUser($users[$i + 1], $this->form);
                                break;
                            } else {
                                $this->status = static::STATUS_APPROVED;
                                if ($this->save()) {
                                    $this->form->status = Form::STATUS_ACTIVE;
                                    $this->form->save();
                                    $msg = "your requested publishing form `" . $this->form->title . "` was approved";
                                    $this->notifySalesmen();
                                }
                            }
                        }
                    }
                }
            } else if ($currentUserApprove->status == static::STATUS_REJECTED) {
                $this->status = static::STATUS_REJECTED;
                $this->save();
                $msg = "your requested publishing form `" . $this->form->title . "` was rejected";
            }
            if ($msg) {
                Yii::$app->notification->send('form-approval-response', [
                    'message' => $msg,
                    'id' => $this->id,
                ], [$this->user_id], false, false);
            }
        }
    }

    /**
     * @param $assignedUser FormApprovalUser
     * @param $form Form
     */
    public function assignUser($assignedUser, $form)
    {
        if (!Yii::$app->user->isGuest) {
            $requestUser = new FormApprovalUser();
            $requestUser->form_approval_id = $this->id;
            $requestUser->user_id = $assignedUser->user_id;
            $requestUser->status = static::STATUS_PENDING;
            if ($requestUser->save()) {
                Yii::$app->notification->send('form-approval', [
                    'message' => Yii::$app->user->identity->name . ' request the form `' . $form->title . '` for approve.',
                    'id' => $requestUser->id,
                ], [$requestUser->user_id], false, false);
            } else {
                throw new Exception("FormApprovalUser not saved");
            }
        }
    }

    public function notifySalesmen()
    {
        if($this->form) {
            if(isset($this->form->structure['name'])) {
                $tableName = $this->form->structure['name'];
                $sql = 'select distinct(user_id) from ' . $tableName;
                try {
                    $users = Yii::$app->bi->createCommand($sql)->queryColumn();
                    if(!empty($users) && is_array($users)){
                        Yii::$app->notification->send('form-update', [
                            'message' => 'The Form `' . $this->form->title . '`` was updated',
                            'id' => $this->form->id,
                        ], $users);
                    }
                }catch(\Throwable $t){}catch(\Exception $e){}
            }
        }
    }
}
