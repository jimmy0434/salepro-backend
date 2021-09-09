<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "mpk_data_list".
 *
 * @property int $id
 * @property string $name
 * @property int $parent_id
 * @property int $type
 * @property int $created_at
 * @property int $updated_at
 *
 * @property DataList $up
 * @property DataList $down
 */
class DataList extends \common\components\ActiveRecord
{

    const TYPE_COUNTRY = 1;
    const TYPE_REGION = 2;
    const TYPE_PRODUCT_TYPE_FLEXIBLE_PACKAGING = 3;
    const TYPE_PRODUCT_TYPE_RIGID_PACKAGING_PRODUCTS = 24;
    const TYPE_PRODUCT_TYPE_MB_COMPOUNDING_PRODUCTS = 25;
    const TYPE_PRODUCT_TYPE_VGA= 39;
    const TYPE_COMPANY_PROFILE = 4;
    const TYPE_POSITION = 5;
    const TYPE_YEAR = 6;
    const TYPE_ANNUAL_SALES_REVENUE = 7;
    const TYPE_NUMBER_OF_EMPLOYEES = 8;
    const TYPE_PRODUCTION_LINE = 9;
    const TYPE_LINE_BRAND = 10;
    const TYPE_QUANTITY_UNIT = 11;
    const TYPE_SOCIAL_MEDIA = 12;
    const TYPE_CERTIFICATIONS = 13;
    const TYPE_MARKETING_STRATEGY = 14;
    const TYPE_COMPANY_COMMUNICATION = 15;
    const TYPE_SUPPLIER = 16;
    const TYPE_INCOTERMS = 17;
    const TYPE_PAYMENT_FACILITY = 18;
    const TYPE_CURRENCY = 19;
    const TYPE_TERMS_OF_BUSINESS = 20;
    const TYPE_RAW_MATERIAL = 21;
    const TYPE_PRICE_UNIT = 22;
    const TYPE_INK_TYPE = 23;
    const TYPE_QUALITY = 26;
    const TYPE_BRAND_EQUITY = 27;
    const TYPE_PROBLEM_SOLVING_RESPONSE = 28;
    const TYPE_MARKET_DOMINANCE = 29;
    const TYPE_COMPETITOR_SECTOR = 30;
 const TYPE_SINGLE_TEXT=31;
    const TYPE_TIMELY_DELIVERY =32; 
    const TYPE_LEAD_TIME =33; 
    const TYPE_CUSTOMER_RELATIONSHIP =34;     
   const TYPE_MARKET_TRENDS =35;   
    const TYPE_MARKET_TRENDS_Status =36; 
    const TYPE_MARKET_TRENDS_Risk_Category =37; 
    const TYPE_MARKET_TRENDS_CATEGORY =38;    
    const TYPE_FIVE_FORCES_NUMBER_OF_SUPPLIERS =72;
    const TYPE_FIVE_FORCES_SUPPLIERS_LOCATION =40;
    const TYPE_FIVE_FORCES_AVERAGE_SIZE_OF_MAIN_SUPPLIERS =41;
    const TYPE_FIVE_FORCES_UNIQUENESS_OF_SERVICE =42;
    const TYPE_FIVE_FORCES_YOUR_ABILITY_TO_SUBSITUTE =43;
    const TYPE_FIVE_FORCES_AVERAGE_DESC =44;
    const TYPE_FIVE_FORCES_NUMBER_OF_BUYERS =45;
    const TYPE_FIVE_FORCES_CONCENTRATION_OF_BUYERS =46;
    const TYPE_FIVE_FORCES_BUYERS_SIZE_OF_ORDERS =47;
    const TYPE_FIVE_FORCES_AVERAGE_ASC =48;
    const TYPE_FIVE_FORCES_INDUSTRY_SECTOR_GROWTH =49;
    const TYPE_FIVE_FORCES_SUBSITUTE_PRICE_VS_INDUSTRY =50;
    const TYPE_FIVE_FORCES_SUBSITUTE_PRODUCT_QUALITY_VS_INDUSTRY =51;
    const TYPE_FIVE_FORCES_NUMBER_OF_COMPETITORS =52;
    const TYPE_FIVE_FORCES_TREAT_BRAND_NAME =53;
    const TYPE_FIVE_FORCES_ACCESS_TO_DISTRIBUTION_CHANNELS =54;
    const TYPE_SECTOR_OUTLOOK_SECTOR =55;
    const TYPE_SECTOR_OUTLOOK_INDUSTRY =56;
    const TYPE_PRODUCT_LINE =57;
   


    public static function listRelations()
    {
        return [
             static::TYPE_PRODUCTION_LINE => static::TYPE_LINE_BRAND,
             static::TYPE_RAW_MATERIAL => static::TYPE_SUPPLIER,
             static::TYPE_MARKET_TRENDS_CATEGORY => static::TYPE_MARKET_TRENDS,
             static::TYPE_SECTOR_OUTLOOK_SECTOR => static::TYPE_SECTOR_OUTLOOK_INDUSTRY,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%data_list}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['parent_id', 'type'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'parent_id' => 'Parent ID',
            'type' => 'Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getUp()
    {
        return $this->hasOne(static::className(), ['id' => 'parent_id']);
    }

    public function getDown()
    {
        return $this->hasMany(static::className(), ['parent_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return DataListQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DataListQuery(get_called_class());
    }

    public static function dropDownList($type)
    {
        return ArrayHelper::map(static::find()->orderBy(['name' => SORT_ASC])->where(['type' => $type])->all(), 'name', 'name');
    }
    public static function updateRecord($name,$type,$parent)
    {

if($parent=='1')
{
    $parents=896;
    $model = static::find()->where(['name' => $name])->Andwhere(['parent_id' => $parents])->one();
    if (!$model) {
        $model = new static();
        $model->name = $name;
        $model->parent_id = $parents;
    }
    $model->name = $name;
    $model->type = $type;
    $model->parent_id = $parents;
    $model->save();

}

else if($parent=='2')
{
    $parents=897;
    $model = static::find()->where(['name' => $name])->Andwhere(['parent_id' => $parents])->one();
    if (!$model) {
        $model = new static();
        $model->name = $name;
        $model->parent_id = $parents;
    }
    $model->name = $name;
    $model->type = $type;
    $model->parent_id = $parents;
    $model->save();

}
else if($parent=='3')
{
    $parents=898;
    $model = static::find()->where(['name' => $name])->Andwhere(['parent_id' => $parents])->one();
    if (!$model) {
        $model = new static();
        $model->name = $name;
        $model->parent_id = $parents;
    }
    $model->name = $name;
    $model->type = $type;
    $model->parent_id = $parents;
    $model->save();

}
else if($parent=='4')
{
    $parents=899;
    $model = static::find()->where(['name' => $name])->Andwhere(['parent_id' => $parents])->one();
    if (!$model) {
        $model = new static();
        $model->name = $name;
        $model->parent_id = $parents;
    }
    $model->name = $name;
    $model->type = $type;
    $model->parent_id = $parents;
    $model->save();

}
else if($parent=='5')
{
    $parents=900;
    $model = static::find()->where(['name' => $name])->Andwhere(['parent_id' => $parents])->one();
    if (!$model) {
        $model = new static();
        $model->name = $name;
        $model->parent_id = $parents;
    }
    $model->name = $name;
    $model->type = $type;
    $model->parent_id = $parents;
    $model->save();

}


       

      

        return $model;
    }

}
