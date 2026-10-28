<?php

namespace common\models;
use yii\helpers\ArrayHelper;
use cnd\admin\models\activerecords\Log;

use Yii;

/**
 * This is the model class for table "mpk_tarf1".
 *
 * @property int $id
 * @property string $uid
 * @property int $salesman_id
 * @property string $bu
 * @property string $email
 * @property string $type
 * @property string $subject
 * @property string $description
 * @property string $sample_name_1
 * @property string $sample_hs_code_1
 * @property string $sample_type_1
 * @property string $sample_specs_1
 * @property string $sample_name_2
 * @property string $sample_hs_code_2
 * @property string $sample_type_2
 * @property string $sample_specs_2
 * @property string $sample_name_3
 * @property string $sample_hs_code_3
 * @property string $sample_type_3
 * @property string $sample_specs_3
 * @property string $sample_name_4
 * @property string $sample_hs_code_4
 * @property string $sample_type_4
 * @property string $sample_specs_4
 * @property string $approved
 * @property int $created_at
 * @property int $updated_at
 */
class Tarf1 extends  \common\components\ActiveRecord
{
    const NO = 'no';
    const YES = 'yes';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mpk_tarf1';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['salesman_id', 'created_at', 'updated_at'], 'integer'],
            [['description', 'approved'], 'string'],
            [['uid', 'bu', 'email', 'type', 'subject', 'sample_name_1', 'sample_hs_code_1', 'sample_type_1', 'sample_specs_1', 'sample_name_2', 'sample_hs_code_2', 'sample_type_2', 'sample_specs_2', 'sample_name_3', 'sample_hs_code_3', 'sample_type_3', 'sample_specs_3', 'sample_name_4', 'sample_hs_code_4', 'sample_type_4', 'sample_specs_4'], 'string', 'max' => 255],
            [['uid'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'salesman_id' => 'Salesman ID',
            'bu' => 'Bu',
            'email' => 'Email',
            'type' => 'Type',
            'subject' => 'Subject',
            'description' => 'Description',
            'sample_name_1' => 'Sample Name 1',
            'sample_hs_code_1' => 'Sample Hs Code 1',
            'sample_type_1' => 'Sample Type 1',
            'sample_specs_1' => 'Sample Specs 1',
            'sample_name_2' => 'Sample Name 2',
            'sample_hs_code_2' => 'Sample Hs Code 2',
            'sample_type_2' => 'Sample Type 2',
            'sample_specs_2' => 'Sample Specs 2',
            'sample_name_3' => 'Sample Name 3',
            'sample_hs_code_3' => 'Sample Hs Code 3',
            'sample_type_3' => 'Sample Type 3',
            'sample_specs_3' => 'Sample Specs 3',
            'sample_name_4' => 'Sample Name 4',
            'sample_hs_code_4' => 'Sample Hs Code 4',
            'sample_type_4' => 'Sample Type 4',
            'sample_specs_4' => 'Sample Specs 4',
            'approved' => 'Approved',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalesman()
    {
        return $this->hasOne(Salesman::className(), ['id' => 'salesman_id']);
    }

    /**
     * {@inheritdoc}
     * @return Tarf1Query the active query used by this AR class.
     */
    public static function find()
    {
        return new Tarf1Query(get_called_class());
    }
    public function beforeSave($insert)
    {
        if ($this->isNewRecord || !$this->uid) {
            $this->uid = uniqid('tarf_1-', true);
        }
           // comment this before run migration for search index update
           if (!Yii::$app->user->isGuest && !$this->salesman_id && Yii::$app->user->identity->type == User::TYPE_SALESMAN) {
            $this->salesman_id = Yii::$app->user->identity->id;
            $this->email = Yii::$app->user->identity->email;
        }

        return parent::beforeSave($insert);
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->approved = static::NO;
        }
        return parent::beforeValidate();
    }

        public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $list = parent::toArray($fields, $expand, $recursive);
      
       


        return $list;
    }
}
