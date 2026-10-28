<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use cnd\admin\models\activerecords\Log;

/**
 * This is the model class for table "mpk_five_forces".
 *
 * @property int $id
 * @property string $uid
 * @property int $salesman_id
 * @property int $business_unit_id
 * @property string $name
 * @property string $number_of_suppliers
 * @property string $suppliers_location
 * @property string $avg_size_supplier
 * @property string $uniqueness_of_service
 * @property string $your_ability_to_Subsitute
 * @property string $switching_costs
 * @property string $number_of_buyers
 * @property string $concentration_of_buyers
 * @property string $buyers_size_of_orders
 * @property string $buyers_switching_costs
 * @property string $buyers_ability_to_integrate
 * @property string $buyers_price_sensitivity
 * @property string $buyers_cost_structure
 * @property string $number_of_competitors
 * @property string $diversity_of__competitors
 * @property string $product_differenciation_substitutes
 * @property string $economics_of_scale
 * @property string $customer_loyality
 * @property string $customer_switching_cost
 * @property string $industry_sector_growth
 * @property string $availability_of_subsitutes
 * @property string $subsitute_price_vs_industry_product
 * @property string $subsitute_product_quality_vs_indistry_product
 * @property string $threat_switching_costs
 * @property string $specialist_knowledge
 * @property string $product_differenciation
 * @property string $brand_name
 * @property string $initial_capital_investment
 * @property string $consumer_switching_costs
 * @property string $access_to_distribution_channels
 * @property string $technology_protections
 * @property string $governmental_and_legal_barries
 * @property string $retaliation
 * @property int $created_at
 * @property int $updated_at
 * @property string $product_line
 */
class FiveForces extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mpk_five_forces';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['salesman_id', 'business_unit_id', 'created_at', 'updated_at'], 'integer'],
            [['uid', 'name', 'number_of_suppliers', 'suppliers_location', 'avg_size_supplier','geographical_area', 'uniqueness_of_service', 'your_ability_to_Subsitute', 'switching_costs', 'number_of_buyers', 'concentration_of_buyers', 'buyers_size_of_orders', 'buyers_switching_costs', 'buyers_ability_to_integrate', 'buyers_price_sensitivity', 'buyers_cost_structure', 'number_of_competitors', 'diversity_of__competitors', 'product_differenciation_substitutes', 'economics_of_scale', 'customer_loyality', 'customer_switching_cost', 'industry_sector_growth', 'availability_of_subsitutes', 'subsitute_price_vs_industry_product', 'subsitute_product_quality_vs_indistry_product', 'threat_switching_costs', 'specialist_knowledge', 'product_differenciation', 'brand_name', 'initial_capital_investment', 'consumer_switching_costs', 'access_to_distribution_channels', 'technology_protections', 'governmental_and_legal_barries', 'retaliation', 'product_line'], 'string', 'max' => 255],
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
            'business_unit_id' => 'Business Unit ID',
            'name' => 'Name',
            'number_of_suppliers' => 'Number Of Suppliers',
            'suppliers_location' => 'Suppliers Location',
            'avg_size_supplier' => 'Avg Size Supplier',
            'uniqueness_of_service' => 'Uniqueness Of Service',
            'your_ability_to_Subsitute' => 'Your Ability To Subsitute',
            'switching_costs' => 'Switching Costs',
            'number_of_buyers' => 'Number Of Buyers',
            'concentration_of_buyers' => 'Concentration Of Buyers',
            'buyers_size_of_orders' => 'Buyers Size Of Orders',
            'buyers_switching_costs' => 'Buyers Switching Costs',
            'buyers_ability_to_integrate' => 'Buyers Ability To Integrate',
            'buyers_price_sensitivity' => 'Buyers Price Sensitivity',
            'buyers_cost_structure' => 'Buyers Cost Structure',
            'number_of_competitors' => 'Number Of Competitors',
            'diversity_of__competitors' => 'Diversity Of Competitors',
            'product_differenciation_substitutes' => 'Product Differenciation Substitutes',
            'economics_of_scale' => 'Economics Of Scale',
            'customer_loyality' => 'Customer Loyality',
            'customer_switching_cost' => 'Customer Switching Cost',
            'industry_sector_growth' => 'Industry Sector Growth',
            'availability_of_subsitutes' => 'Availability Of Subsitutes',
            'subsitute_price_vs_industry_product' => 'Subsitute Price Vs Industry Product',
            'subsitute_product_quality_vs_indistry_product' => 'Subsitute Product Quality Vs Indistry Product',
            'threat_switching_costs' => 'Threat Switching Costs',
            'specialist_knowledge' => 'Specialist Knowledge',
            'product_differenciation' => 'Product Differenciation',
            'brand_name' => 'Brand Name',
            'initial_capital_investment' => 'Initial Capital Investment',
            'consumer_switching_costs' => 'Consumer Switching Costs',
            'access_to_distribution_channels' => 'Access To Distribution Channels',
            'technology_protections' => 'Technology Protections',
            'governmental_and_legal_barries' => 'Governmental And Legal Barries',
            'retaliation' => 'Retaliation',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'product_line' => 'Product Line',
        ];
    }

    /**
     * {@inheritdoc}
     * @return FiveForcesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FiveForcesQuery(get_called_class());
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

    public function beforeSave($insert)
    {
        if ($this->isNewRecord || !$this->uid) {
            $this->uid = uniqid('five_forces-', true);
        }

        // comment this before run migration for search index update
        if (!Yii::$app->user->isGuest && !$this->salesman_id && Yii::$app->user->identity->type == User::TYPE_SALESMAN) {
            $this->salesman_id = Yii::$app->user->identity->id;
        }

        return parent::beforeSave($insert);
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

        Yii::$app->notification->send('five-forces-update', [
            'message' => 'five forces Update',
            'id' => $this->id,
            'uid' => $this->uid,
        ], $users);
    }
    public function notifyOne($userId)
    {
        $users = array_values(ArrayHelper::map(User::find()->where(['status' => User::STATUS_ACTIVE, 'type' => User::TYPE_SALESMAN])->andWhere(['=', 'id', $userId])->all(), 'id', 'id'));

        Yii::$app->notification->send('five-forces-update', [
            'message' => 'five forces Update',
            'id' => $this->id,
            'uid' => $this->uid,
        ], $users);
    }
}
