<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use cnd\admin\models\activerecords\Log;

/**
 * This is the model class for table "mpk_steep_analysis".
 *
 * @property int $id
 * @property string $uid
 * @property string $name
 * @property int $salesman_id
 * @property string $status
 * @property string $subsequent
 * @property string $impact
 * @property string $trend_status
 * @property string $risk_category
 * @property string $control_measure
 * @property int $created_at
 * @property int $updated_at
 * @property string $category
 * @property int $business_unit_id
 *
 * @property BusinessUnit $businessUnit
 */
class SteepAnalysis extends  \common\components\ActiveRecord
{

    const STATUS_ENABLED = 'enabled';
    const STATUS_DISABLED = 'disabled';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mpk_steep_analysis';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['salesman_id', 'created_at', 'updated_at', 'business_unit_id'], 'integer'],
            [['status'], 'string'],
            [['uid', 'name', 'subsequent', 'impact', 'trend_status', 'risk_category', 'control_measure', 'category','building_block','product_line','georgraphical_area','sector','industry'], 'string'],
            [['uid'], 'unique'],
            [['business_unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => BusinessUnit::className(), 'targetAttribute' => ['business_unit_id' => 'id']],
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
            'name' => 'Name',
            'salesman_id' => 'Salesman ID',
            'status' => 'Status',
            'subsequent' => 'Subsequent',
            'impact' => 'Impact',
            'trend_status' => 'Trend Status',
            'risk_category' => 'Risk Category',
            'control_measure' => 'Control Measure',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'category' => 'Category',
            'business_unit_id' => 'Business Unit ID',
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
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessUnit()
    {
        return $this->hasOne(BusinessUnit::className(), ['id' => 'business_unit_id']);
    }

    /**
     * {@inheritdoc}
     * @return SteepAnalysisQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SteepAnalysisQuery(get_called_class());
    }
    
    public function beforeSave($insert)
    {
        if ($this->isNewRecord || !$this->uid) {
            $this->uid = uniqid('steep_analysis-', true);
                 if($this->category=='Social')
        {
  

$list =DataList::updateRecord($this->name, '35','1');



        }
        else if($this->category=='Technological')
        {

$list =DataList::updateRecord($this->name, '35','2');

        }
        else if($this->category=='Economical')
        {

$list =DataList::updateRecord($this->name, '35','3');

        }
        else  if($this->category=='Ecological')
        {

$list =DataList::updateRecord($this->name, '35','4');

        }
        else  if($this->category=='Political')
        {

$list =DataList::updateRecord($this->name, '35','5');

        }
        }

        // comment this before run migration for search index update
        if (!Yii::$app->user->isGuest && !$this->salesman_id && Yii::$app->user->identity->type == User::TYPE_SALESMAN) {
            $this->salesman_id = Yii::$app->user->identity->id;
        }

        return parent::beforeSave($insert);
    }
 
    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->status = static::STATUS_DISABLED;
        }
        return parent::beforeValidate();
    }
    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $list = parent::toArray($fields, $expand, $recursive);
      
       

        $list['businessUnit'] = null;
        if ($this->businessUnit && $this->businessUnit->portfolio) {
            $list['businessUnit'] = $this->businessUnit->portfolio->uid;
        }

        return $list;
    }
    public function notifyAll()
    {
        $users = array_values(ArrayHelper::map(User::find()->where(['status' => User::STATUS_ACTIVE, 'type' => User::TYPE_SALESMAN])->all(), 'id', 'id'));

        Yii::$app->notification->send('steep-analysis-update', [
            'message' => 'steep analysis Update',
            'id' => $this->id,
            'uid' => $this->uid,
        ], $users);
    }
    public function notifyOne($userId)
    {
        $users = array_values(ArrayHelper::map(User::find()->where(['status' => User::STATUS_ACTIVE, 'type' => User::TYPE_SALESMAN])->andWhere(['=', 'id', $userId])->all(), 'id', 'id'));

        Yii::$app->notification->send('steep-analysis-update', [
            'message' => 'steep analysis Update',
            'id' => $this->id,
            'uid' => $this->uid,
        ], $users);
    }

}

    
          
      


  

