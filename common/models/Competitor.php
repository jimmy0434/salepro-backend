<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%competitor}}".
 *
 * @property int $id
 * @property string $uid
 * @property int $salesman_id
 * @property string $name
 * @property int $business_unit_id
 * @property string $company_profile
 * @property string $headquarter_location
 * @property string $other_locations
 * @property string $website
 * @property resource $logo
 * @property string $market_presence
 * @property string $established_year
 * @property string $annual_sales_revenue
 * @property string $employees_number
 * @property string $certification
 * @property string $certification_others
 * @property string $marketing_strategy
 * @property string $company_communication
 * @property string $quality
 * @property string $brand_equity
 * @property string $problem_solving_response
 * @property string $market_dominance
 * @property string $comments
 * @property resource $file
 * @property string $mother_name
 * @property string $mother_company_profile
 * @property string $mother_headquarter_location
 * @property string $mother_other_locations
 * @property string $mother_website
 * @property int $search_id
 * @property string $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property array $status_list
 * @property array $status_values
 * @property string $status_label
 *
 * @property BusinessUnit $businessUnit
 * @property Search $search
 * @property CompetitorFlexible[] $competitorFlexible
 * @property CompetitorFlexibleCustomer[] $competitorFlexibleCustomer
 * @property CompetitorManager[] $competitorManager
 * @property CompetitorMasterbatch[] $competitorMasterbatch
 * @property CompetitorMasterbatchCustomer[] $competitorMasterbatchCustomer
 * @property CompetitorNews[] $competitorNews
 * @property CompetitorPackaging[] $competitorPackaging
 * @property CompetitorPackagingCustomer[] $competitorPackagingCustomer
 * @property CompetitorProductionLine[] $competitorProductionLine
 * @property CompetitorSocial[] $competitorSocial
 * @property CompetitorSupplier[] $competitorSupplier
 * @property PortfolioCompetitor[] $portfolioCompetitors
 * @property Salesman[] $salesman
 */
class Competitor extends \common\components\ActiveRecord
{

    const STATUS_ENABLED = 'enabled';
    const STATUS_DISABLED = 'disabled';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%competitor}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['salesman_id', 'business_unit_id', 'search_id'], 'integer'],
            [['logo', 'file'], 'string'],
            [['name', 'company_profile', 'headquarter_location', 'other_locations', 'website', 'market_presence', 'established_year', 'annual_sales_revenue', 'employees_number', 'certification', 'certification_others', 'marketing_strategy', 'company_communication', 'quality', 'brand_equity', 'problem_solving_response', 'market_dominance', 'comments', 'mother_name', 'mother_company_profile', 'mother_headquarter_location', 'mother_other_locations', 'mother_website'], 'string', 'max' => 255],
            [['uid'], 'unique'],
            [['business_unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => BusinessUnit::className(), 'targetAttribute' => ['business_unit_id' => 'id']],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'salesman_id' => 'Salesman ID',
            'name' => 'Name',
            'business_unit_id' => 'Business Unit ID',
            'company_profile' => 'Company Profile',
            'headquarter_location' => 'Headquarter Location',
            'other_locations' => 'Other Locations',
            'website' => 'Website',
            'logo' => 'Logo',
            'market_presence' => 'Market Presence',
            'established_year' => 'Established Year',
            'annual_sales_revenue' => 'Annual Sales Revenue',
            'employees_number' => 'Employees Number',
            'certification' => 'Certification',
            'certification_others' => 'Certification Others',
            'marketing_strategy' => 'Marketing Strategy',
            'company_communication' => 'Company Communication',
            'quality' => 'Quality',
            'brand_equity' => 'Brand Equity',
            'problem_solving_response' => 'Problem Solving Response',
            'market_dominance' => 'Market Dominance',
            'comments' => 'Comments',
            'file' => 'File',
            'mother_name' => 'Mother Name',
            'mother_company_profile' => 'Mother Company Profile',
            'mother_headquarter_location' => 'Mother Headquarter Location',
            'mother_other_locations' => 'Mother Other Locations',
            'mother_website' => 'Mother Website',
            'search_id' => 'Search ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessUnit()
    {
        return $this->hasOne(BusinessUnit::className(), ['id' => 'business_unit_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSearch()
    {
        return $this->hasOne(Search::className(), ['id' => 'search_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetitorFlexible()
    {
        return $this->hasMany(CompetitorFlexible::className(), ['competitor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetitorFlexibleCustomer()
    {
        return $this->hasMany(CompetitorFlexibleCustomer::className(), ['competitor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetitorManager()
    {
        return $this->hasMany(CompetitorManager::className(), ['competitor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetitorMasterbatch()
    {
        return $this->hasMany(CompetitorMasterbatch::className(), ['competitor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetitorMasterbatchCustomer()
    {
        return $this->hasMany(CompetitorMasterbatchCustomer::className(), ['competitor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetitorNews()
    {
        return $this->hasMany(CompetitorNews::className(), ['competitor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetitorPackaging()
    {
        return $this->hasMany(CompetitorPackaging::className(), ['competitor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetitorPackagingCustomer()
    {
        return $this->hasMany(CompetitorPackagingCustomer::className(), ['competitor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetitorProductionLine()
    {
        return $this->hasMany(CompetitorProductionLine::className(), ['competitor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetitorSocial()
    {
        return $this->hasMany(CompetitorSocial::className(), ['competitor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetitorSupplier()
    {
        return $this->hasMany(CompetitorSupplier::className(), ['competitor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortfolioCompetitors()
    {
        return $this->hasMany(PortfolioCompetitor::className(), ['competitor_id' => 'id']);
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
     * @return CompetitorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompetitorQuery(get_called_class());
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord || !$this->uid) {
            $this->uid = uniqid('competitor-', true);
        }
        if (!Yii::$app->user->isGuest && !$this->salesman_id && Yii::$app->user->identity->type == User::TYPE_SALESMAN) {
            $this->salesman_id = Yii::$app->user->identity->id;
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($this->status == static::STATUS_ENABLED) {
            $search = Search::updateRecord([], $this->uid, $this->name, '');
            if (!$this->search_id) {
                try {
                    Yii::$app->db->createCommand()->update(static::tableName(), ['search_id' => $search->id], ['id' => $this->id])->execute();
                } catch (\Throwable $t) {
                } catch (\Exception $e) {
                }
            }
        }
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $list = parent::toArray($fields, $expand, $recursive);
        unset($list['file'], $list['search_id'], $list['business_unit_id']);

        $list['competitorNews'] = $this->getCompetitorNews()->all();
        $list['competitorManager'] = $this->getCompetitorManager()->all();
        $list['competitorSupplier'] = $this->getCompetitorSupplier()->all();
        $list['competitorSocial'] = $this->getCompetitorSocial()->all();
        $list['competitorProductionLine'] = $this->getCompetitorProductionLine()->all();
        $list['competitorFlexible'] = $this->getCompetitorFlexible()->all();
        $list['competitorMasterbatch'] = $this->getCompetitorMasterbatch()->all();
        $list['competitorPackaging'] = $this->getCompetitorPackaging()->all();

        $sectors = [];
        $productTypes = [];

        if (!empty($list['competitorFlexible']) && is_array($list['competitorFlexible'])) {
            foreach ($list['competitorFlexible'] as $model) {
                $productTypes[] = $model->product_type;
                $sectors[] = $model->sector && $model->sector->portfolio ? $model->sector->portfolio->uid : null;
            }
        }

        if (!empty($list['competitorMasterbatch']) && is_array($list['competitorMasterbatch'])) {
            foreach ($list['competitorMasterbatch'] as $model) {
                $productTypes[] = $model->product_type;
                $sectors[] = $model->sector && $model->sector->portfolio ? $model->sector->portfolio->uid : null;
            }
        }

        if (!empty($list['competitorPackaging']) && is_array($list['competitorPackaging'])) {
            foreach ($list['competitorPackaging'] as $model) {
                $productTypes[] = $model->product_type;
                $sectors[] = $model->sector && $model->sector->portfolio ? $model->sector->portfolio->uid : null;
            }
        }

        $list['productTypes'] = array_unique(array_filter($productTypes, function ($value) {
            return $value;
        }));
        $list['sectors'] = array_unique(array_filter($sectors, function ($value) {
            return $value;
        }));

        $list['businessUnit'] = null;
        if ($this->businessUnit && $this->businessUnit->portfolio) {
            $list['businessUnit'] = $this->businessUnit->portfolio->uid;
        }

        return $list;
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->status = static::STATUS_DISABLED;
        }
        return parent::beforeValidate();
    }
}
