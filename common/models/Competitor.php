<?php

namespace common\models;
use yii\helpers\ArrayHelper;
use cnd\admin\models\activerecords\Log;
use Yii;
use yii\helpers\Inflector;

/**
 * This is the model class for table "mpk_competitor".
 *
 * @property int $id
 * @property string $uid
 * @property int $salesman_id
 * @property string $name
 * @property int $business_unit_id
 * @property string $company_profile
 * @property string $headquarter_location
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
 * @property int $created_at
 * @property int $updated_at
 * @property string $logo_ext
 * @property string $file_ext
 * @property string $status
 * @property string $manufacturing_locations
 * @property string $sales_offices_locations
 * @property string $merger_company_name
 * @property string $merger_country
 * @property string $acquisition_company_name
 * @property string $acquisition_country
 * @property string $hq_coordinates
 *
 * @property BusinessUnit $businessUnit
 * @property Salesman $salesman
 * @property Search $search
 * @property CompetitorBusinessunit[] $competitorBusinessunits
 * @property CompetitorCertification[] $competitorCertifications
 * @property CompetitorCompanyCommunication[] $competitorCompanyCommunications
 * @property CompetitorFlexible[] $competitorFlexibles
 * @property CompetitorFlexibleCustomer[] $competitorFlexibleCustomers
 * @property CompetitorCorrugated[] $competitorCorrugateds
 * @property CompetitorCorrugatedCustomer[] $competitorCorrugatedCustomers
 * @property CompetitorManager[] $competitorManagers
 * @property CompetitorMarketPresence[] $competitorMarketPresences
 * @property CompetitorMarketingStrategy[] $competitorMarketingStrategies
 * @property CompetitorMasterbatch[] $competitorMasterbatches
 * @property CompetitorMasterbatchCustomer[] $competitorMasterbatchCustomers
 * @property CompetitorMotherOtherLocation[] $competitorMotherOtherLocations
 * @property CompetitorNews[] $competitorNews
 * @property CompetitorOtherLocation[] $competitorOtherLocations
 * @property CompetitorPackaging[] $competitorPackagings
 * @property CompetitorPackagingCustomer[] $competitorPackagingCustomers
 * @property CompetitorProductionLine[] $competitorProductionLines
 * @property CompetitorSocial[] $competitorSocials
 * @property CompetitorSupplier[] $competitorSuppliers
 * @property CompetitorVga[] $competitorVgas
 * @property PortfolioCompetitor[] $portfolioCompetitors
 */
class Competitor extends \common\components\ActiveRecord
{
    const STATUS_ENABLED = 'enabled';
    const STATUS_DISABLED = 'disabled';
    const MERGED_ENABLED = 'enabled';
    const MERGED_DISABLED = 'disabled';
    public $businessUnitIds = [];
    public $salesManIds = [];
    public $isedit ='false';
    //public static $disableLogo = false;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mpk_competitor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
          [['salesman_id', 'search_id'], 'integer'],
            [['logo', 'file'], 'string'],
            [['name','business_unit_names', 'company_profile', 'headquarter_location', 'sector', 'manufacturing_locations', 'manufacturing_locations', 'website', 'market_presence', 'established_year', 'annual_sales_revenue', 'employees_number', 'certification', 'certification_others', 'marketing_strategy', 'company_communication', 'quality', 'brand_equity', 'problem_solving_response', 'market_dominance' , 'mother_name', 'mother_company_profile', 'mother_headquarter_location', 'mother_other_locations', 'mother_website'], 'string'],
            [['uid'], 'unique'],
            [['business_unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => BusinessUnit::className(), 'targetAttribute' => ['business_unit_id' => 'id']],
            [['businessUnitIds'], 'safe'],
            [['salesManIds'], 'safe'],
        ]);
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
            'name' => 'Name',
            'business_unit_id' => 'Business Unit ID',
            'company_profile' => 'Company Profile',
            'headquarter_location' => 'Headquarter Location',
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
            'logo_ext' => 'Logo Ext',
            'file_ext' => 'File Ext',
            'status' => 'Status',
            'merged' => 'Merged',
            'manufacturing_locations' => 'Manufacturing Locations',
            'sales_offices_locations' => 'Sales Offices Locations',
            'merger_company_name' => 'Merger Company Name',
            'merger_country' => 'Merger Country',
            'acquisition_company_name' => 'Acquisition Company Name',
            'acquisition_country' => 'Acquisition Country',
            'hq_coordinates' => 'Hq Coordinates',
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
    public function getCompetitorCorrugated()
    {
        return $this->hasMany(CompetitorCorrugated::className(), ['competitor_id' => 'id']);
    }
   /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetitorVga()
    {
        return $this->hasMany(CompetitorVga::className(), ['competitor_id' => 'id']);
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
    public function getCompetitorCorrugatedCustomer()
    {
        return $this->hasMany(CompetitorCorrugatedCustomer::className(), ['competitor_id' => 'id']);
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
    public function getCompetitorSalesMan()
    {
        return $this->hasMany(CompetitorSalesMan::className(), ['competitor_id' => 'id']);
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
    public function getCompetitorBu()
    {
        return $this->hasMany(CompetitorBusinessUnit::className(), ['competitor_id' => 'id']);
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
    protected function assignItems($items, $targetModel, $relationId, $byId, $byValue, $extraParams = [], $relatedModel = null)
    {
       
        $oldIds = [];
   
        $old = $targetModel::find()->where([$byId => $byValue])->all();
        if (!empty($old) && is_array($old)) {
            foreach ($old as $m) {
                $oldIds[] = $m->$relationId;
                $m->delete();
              
            }
        }
       
               if (!empty($items) && is_array($items)) {
               
            foreach ($items as $i => $itemId) {
               
                                $m = new $targetModel();
                $m->$byId = $byValue;
                $m->$relationId = $itemId;
              
            
                
                $m->save();
             
            }
        }
       
    }
   
    public function beforeSave($insert)
    {
        if ($this->isNewRecord || !$this->uid) {
            $this->uid = uniqid('competitor-', true);
        }
    
   
        // Set salesman_id if user is logged in and is a salesman
        if (!Yii::$app->user->isGuest && !$this->salesman_id && Yii::$app->user->identity->type == User::TYPE_SALESMAN) {
            $this->salesman_id = Yii::$app->user->identity->id;
        }
if($this->isedit=='false')
{
    if ($this->businessUnitIds==null||$this->businessUnitIds=="") {
       
        $this->updateBupost(CompetitorBusinessunit::className(), 'business_unit_id');
        
       
    } else {
        
        $this->updateFieldsToTables(CompetitorBusinessunit::className(), $this->businessUnitIds);
       $this->updateBu(CompetitorBusinessunit::className(), $this->businessUnitIds);
     
    }
}


       
    
        return parent::beforeSave($insert);
    }
    

    private function GetSearchText()
    {
        $text = [];
        $range = $this->competitorCorrugated;
        if (!empty($range) && is_array($range)) {
            foreach ($range as $model) {
                $text[] = $model->product_type;
                $text[] = $model->sector;
            }
        }
        $range = $this->competitorFlexible;
        if (!empty($range) && is_array($range)) {
            foreach ($range as $model) {
                $text[] = $model->product_type;
                $text[] = $model->sector;
            }
        }

        $range = $this->competitorMasterbatch;
        if (!empty($range) && is_array($range)) {
            foreach ($range as $model) {
                $text[] = $model->product_type;
                $text[] = $model->sector;
            }
        }

        $range = $this->competitorPackaging;
        if (!empty($range) && is_array($range)) {
            foreach ($range as $model) {
                $text[] = $model->product_type;
                $text[] = $model->sector;
            }
        }
        $range = $this->competitorVga;
        if (!empty($range) && is_array($range)) {
            foreach ($range as $model) {
                $text[] = $model->product_type;
               // $text[] = $model->sector;
            }
        }

        if ($this->businessUnit && $this->businessUnit->portfolio) {
            $text[]  = $this->businessUnit->portfolio->name;
        }

        $range = $this->competitorProductionLine;
        if (!empty($range) && is_array($range)) {
            foreach ($range as $model) {
                $text[] = $model->production_line;
            }
        }

        $result = implode(' ', $text).' '
            .$this->company_profile.' '
            .$this->headquarter_location.' '
            .$this->manufacturing_locations.' '
            .$this->sales_offices_locations.' '
            .$this->website.' '
            .$this->market_presence.' '
            .$this->established_year.' '
            .$this->annual_sales_revenue.' '
            .$this->employees_number.' '
            .$this->certification.' '
            .$this->certification_others.' '
            .$this->marketing_strategy.' '
            .$this->company_communication.' '
            .$this->quality.' '
            .$this->brand_equity.' '
            .$this->problem_solving_response.' '
            .$this->market_dominance.' '
            .$this->comments.' '
            .$this->mother_name.' '
            .$this->mother_company_profile.' '
            .$this->mother_headquarter_location.' '
            .$this->mother_other_locations;

        return($result);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($this->status == static::STATUS_ENABLED) {
            $search = Search::updateRecord([], $this->uid, $this->name, $this->GetSearchText());
            if (!$this->search_id) {
                try {
                    Yii::$app->db->createCommand()->update(static::tableName(), ['search_id' => $search->id], ['id' => $this->id])->execute();
                } catch (\Throwable $t) {
                } catch (\Exception $e) {
                }
            }
        }

        if ($this->status == static::STATUS_DISABLED) { 
        $search = Search::find()->where(['id' =>$this->search_id])->all();
      
           
            foreach ($search as $search) {
                $search->delete();
            }
        }

       

       $this->updateCompetitorTablesFields();


      
        //$this->sendNotificationEmail($insert); // <- comment this before run migration for search index update
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $list = parent::toArray($fields, $expand, $recursive);
        unset($list['file'], $list['search_id'], $list['business_unit_id']);
      //  $list['business_unit_id'] = $this->getCompetitorBu()->all();
        $list['competitorNews'] = $this->getCompetitorNews()->all();
        $list['competitorManager'] = $this->getCompetitorManager()->all();
        $list['competitorSupplier'] = $this->getCompetitorSupplier()->all();
        $list['competitorSocial'] = $this->getCompetitorSocial()->all();
        $list['competitorProductionLine'] = $this->getCompetitorProductionLine()->all();
        $list['competitorFlexible'] = $this->getCompetitorFlexible()->all();
        $list['competitorCorrugated'] = $this->getCompetitorCorrugated()->all();
        $list['competitorMasterbatch'] = $this->getCompetitorMasterbatch()->all();
        $list['competitorPackaging'] = $this->getCompetitorPackaging()->all();
        $list['competitorVga'] = $this->getCompetitorVga()->all();
      
        $sectors = [];
        $productTypes = [];

        if (!empty($list['competitorFlexible']) && is_array($list['competitorFlexible'])) {
            foreach ($list['competitorFlexible'] as $model) {
                $productTypes[] = $model->product_type;
                $sectors[] = $model->sector;// && $model->sector->portfolio ? $model->sector->portfolio->uid : null;
            }
        }
        
        if (!empty($list['competitorCorrugated']) && is_array($list['competitorCorrugated'])) {
            foreach ($list['competitorCorrugated'] as $model) {
             $productTypes[] = $model->product_type;
             $sectors[] = $model->sector;// && $model->sector->portfolio ? $model->sector->portfolio->uid : null;
            }
        }

        if (!empty($list['competitorMasterbatch']) && is_array($list['competitorMasterbatch'])) {
            foreach ($list['competitorMasterbatch'] as $model) {
                $productTypes[] = $model->product_type;
                $sectors[] = $model->sector; // && $model->sector->portfolio ? $model->sector->portfolio->uid : null;
            }
        }

        if (!empty($list['competitorPackaging']) && is_array($list['competitorPackaging'])) {
            foreach ($list['competitorPackaging'] as $model) {
                $productTypes[] = $model->product_type;
                $sectors[] = $model->sector; // && $model->sector->portfolio ? $model->sector->portfolio->uid : null;
            }
        }
        if (!empty($list['competitorVga']) && is_array($list['competitorVga'])) {
            foreach ($list['competitorVga'] as $model) {
                $productTypes[] = $model->product_type;
               // && $model->sector->portfolio ? $model->sector->portfolio->uid : null;
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
    public function afterDelete()
    {
     
        $search = Search::find()->where(['id' =>$this->search_id])->all();
      
           
            foreach ($search as $search) {
                $search->delete();
            }
        
    }
    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->status = static::STATUS_DISABLED;
        }
        return parent::beforeValidate();
    }

    public function sendNotification()
    {
        $users = array_values(ArrayHelper::map(User::find()->where(['status' => User::STATUS_ACTIVE, 'type' => User::TYPE_SALESMAN])->andWhere(['!=', 'id', $this->salesman_id])->all(), 'id', 'id'));

        Yii::$app->notification->send('competitor-update', [
            'message' => 'Competitor Update',
            'id' => $this->id,
            'uid' => $this->uid,
        ], $users);
    }

    public function notifyAll()
    {
        $users = array_values(ArrayHelper::map(User::find()->where(['status' => User::STATUS_ACTIVE, 'type' => User::TYPE_SALESMAN])->all(), 'id', 'id'));

        Yii::$app->notification->send('competitor-update', [
            'message' => 'Competitor Update',
            'id' => $this->id,
            'uid' => $this->uid,
        ], $users);
    }
    public function notifyOne($userId)
    {
        $users = array_values(ArrayHelper::map(User::find()->where(['status' => User::STATUS_ACTIVE, 'type' => User::TYPE_SALESMAN])->andWhere(['=', 'id', $userId])->all(), 'id', 'id'));

        Yii::$app->notification->send('competitor-update', [
            'message' => 'Competitor Update',
            'id' => $this->id,
            'uid' => $this->uid,
        ], $users);
    }

    
public function updateBu($modelClass, $fieldName, $extraParams = [])
{


   
    if(!empty($fieldName)){
      
       $value = implode(",",$fieldName);

      
        if ($value) {
            $values = explode(',', $value);
            $l = [];
   
            if (!empty($values) && is_array($values)) {
                foreach ($values as $v) {
                    $v = trim($v);
                    if ($v != '') {
                     
                    
                        $bu = ArrayHelper::map(
                            BusinessUnit::find()
                                ->select('mpk_portfolio.name')
                                ->leftJoin('mpk_portfolio','`mpk_portfolio`.`id`= `mpk_business_unit`.`portfolio_id`')
            
                                ->where(['mpk_business_unit.id' => $v])
                                ->asArray() // <- this
                                ->all(), 
                            'id', 
                            'name'
                        );
                        $test = implode(",",$bu);
                    
                        $l[] = $test;
 
        
            }
            sort($l);         
            $test2 = implode(",",$l);
          $this->business_unit_names= $test2;


        }
            
        }
     }
    }
}   

public function updateCompetitorTablesFields()
    {
       
        //$this->assignTableToField(CompetitorOtherLocation::className(), 'other_locations');
      //  $this->updateFieldsToTable(CompetitorBusinessunit::className(), 'business_unit_id');
      if (($this->businessUnitIds === null || $this->businessUnitIds === "") && $this->isedit === 'false') {
  
        $this->updateFieldsToTables(CompetitorBusinessunit::className(), [$this->business_unit_id]);
      }

      $this->updateFieldsToTable(competitorSalesman::className(), 'salesman_id');
       //$this->updateFieldsToTables(CompetitorBusinessunit::className(), $this->businessUnitIds);
       $this->updateSalesManToTables(competitorSalesman::className(), $this->salesManIds);
        $this->updateFieldsToTable(CompetitorMotherOtherLocation::className(), 'mother_other_locations');
        $this->updateFieldsToTable(CompetitorMarketPresence::className(), 'market_presence');
        $this->updateFieldsToTable(CompetitorMarketingStrategy::className(), 'marketing_strategy');
      $this->updateFieldsToTable(CompetitorCertification::className(), 'certification', ['other' => 0]);
     $this->updateFieldsToTable(CompetitorCertification::className(), 'certification_others', ['other' => 1]);
     $this->updateFieldsToTable(CompetitorCompanyCommunication::className(), 'company_communication');
    }


    private function updateBupost($modelClass, $fieldName, $extraParams = [])
    {

       
       $value = $this->$fieldName;

       
        if ($value) {
            $values = explode(',', $value);
            $l = [];
        
            $bu = ArrayHelper::map(
                BusinessUnit::find()
                    ->select('mpk_portfolio.name')
                    ->leftJoin('mpk_portfolio','`mpk_portfolio`.`id`= `mpk_business_unit`.`portfolio_id`')

                    ->where(['mpk_business_unit.id' => $values])
                    ->asArray() // <- this
                    ->all(), 
                'id', 
                'name'
            );
            $test = implode(",",$bu);
        
            $l[] = $test;
                    sort($l);         
                $test2 = implode(",",$l);
              $this->business_unit_names= $test2;
        }
        


    }
    private function updateFieldsToTable($modelClass, $fieldName, $extraParams = [])
    {
       
     
        $conditions = $extraParams;
        $conditions['competitor_id'] = $this->id;
        $olds = $modelClass::find()->where($conditions)->all();
        if (!empty($olds) && is_array($olds)) {
            foreach ($olds as $old) {
                $old->delete();
            }
        }
       $value = $this->$fieldName;

       
        if ($value) {
            $values = explode(',', $value);
            $l = [];
            if (!empty($values) && is_array($values)) {
                foreach ($values as $v) {
                    $v = trim($v);
                    if ($v != '') {
                        $m = new $modelClass();
                        $m->competitor_id = $this->id;
                        $m->value = $v;
                        $l[] = $v;
                        if (!empty($extraParams) && is_array($extraParams)) {
                            foreach ($extraParams as $n => $vv) {
                                if ($m->hasProperty($n)) {
                                    $m->$n = $vv;
                                }
                            }
                        }
                        $m->save();
                        $this->$fieldName = implode(',',$l);

                    }
                }
            }
        }
    }
    private function updateSalesManToTables($modelClass, $fieldName, $extraParams = [])
    {
       
     if(!empty($fieldName)){
        $conditions = $extraParams;
        $conditions['competitor_id'] = $this->id;
        $olds = $modelClass::find()->where($conditions)->all();
        if (!empty($olds) && is_array($olds)) {
            foreach ($olds as $old) {
                $old->delete();
            }
        }
       $value = implode(",",$fieldName);

       
        if ($value) {
            $values = explode(',', $value);
            $l = [];
          
            if (!empty($values) && is_array($values)) {
                foreach ($values as $v) {
                    $v = trim($v);
                    if ($v != '') {
                        $m = new $modelClass();
                        $m->competitor_id = $this->id;
                        $m->value = $v;
                        $l[] = $v;
                        if (!empty($extraParams) && is_array($extraParams)) {
                            foreach ($extraParams as $n => $vv) {
                                if ($m->hasProperty($n)) {
                                    $m->$n = $vv;
                                }
                            }
                        }
                        $m->save();
                    
                        //  $this->business_unit_names = implode(',',$l);
                      
                    }
                  
                }
             
            }
            
        }
     }
       
    }
    private function updateFieldsToTables($modelClass, $fieldName, $extraParams = [])
    {
       
     if(!empty($fieldName)){
        $conditions = $extraParams;
        $conditions['competitor_id'] = $this->id;
        $olds = $modelClass::find()->where($conditions)->all();
        if (!empty($olds) && is_array($olds)) {
            foreach ($olds as $old) {
                $old->delete();
            }
        }
       $value = implode(",",$fieldName);

       
        if ($value) {
            $values = explode(',', $value);
            $l = [];
          
            if (!empty($values) && is_array($values)) {
                foreach ($values as $v) {
                    $v = trim($v);
                    if ($v != '') {
                        $m = new $modelClass();
                        $m->competitor_id = $this->id;
                        $m->value = $v;
                        $l[] = $v;
                        if (!empty($extraParams) && is_array($extraParams)) {
                            foreach ($extraParams as $n => $vv) {
                                if ($m->hasProperty($n)) {
                                    $m->$n = $vv;
                                }
                            }
                        }
                        $m->save();
                    
                           $this->business_unit_names = implode(',',$l);
                      
                    }
                  
                }
             
            }
            
        }
     }
       
    }
    public function afterFind()
    {
        parent::afterFind();
    $this->assignTableToField(CompetitorBusinessunit::className(), 'business_unit_id');
        $this->assignTableToField(CompetitorMotherOtherLocation::className(), 'mother_other_locations');
        $this->assignTableToField(CompetitorMarketPresence::className(), 'market_presence');
        $this->assignTableToField(CompetitorMarketingStrategy::className(), 'marketing_strategy');
        $this->assignTableToField(CompetitorCertification::className(), 'certification', ['other' => 0]);
        $this->assignTableToField(CompetitorCertification::className(), 'certification_others', ['other' => 1]);
        $this->assignTableToField(CompetitorCompanyCommunication::className(), 'company_communication');
    }

    private function assignTableToField($modelClass, $fieldName, $conditions = []){
        $conditions['competitor_id'] = $this->id;
        $value = trim(implode(',',ArrayHelper::map($modelClass::find()->where($conditions)->all(),'id','value')));
        if($value != ''){
            $this->$fieldName = $value;
        }
    }

   
    public function getItem()
    {
        $item = 'competitorBu';
      
      
            return $this->$item;
       
       // return null;
    }
}

