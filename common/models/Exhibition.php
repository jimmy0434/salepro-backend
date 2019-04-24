<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%exhibition}}".
 *
 * @property int $id
 * @property string $name
 * @property string $year
 * @property int $business_unit_id
 * @property string $city
 * @property string $venue
 * @property string $edition
 * @property string $frequency
 * @property string $url
 * @property string $description
 * @property int $created_at
 * @property int $updated_at
 *
 * @property BusinessUnit $businessUnit
 * @property ExhibitionProduct[] $exhibitionProducts
 * @property Product[] $products
 * @property ExhibitionSector[] $exhibitionSectors
 * @property Sector[] $sectors
 * @property ExhibitionCountry[] $exhibitionCountries
 * @property ExhibitionRegion[] $exhibitionRegions
 */
class Exhibition extends \common\components\ActiveRecord
{

    public $sectorsIds = [];
    public $countriesNames = [];
    public $regionsNames = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%exhibition}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['business_unit_id'], 'integer'],
            [['name', 'year'], 'string', 'max' => 255],
            [['business_unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => BusinessUnit::className(), 'targetAttribute' => ['business_unit_id' => 'id']],
            [['sectorsIds', 'countriesNames', 'regionsNames'], 'safe'],
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
            'year' => 'Year',
            'file_id' => 'File ID',
            'business_unit_id' => 'Manufacturing Plants',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'countriesNames' => 'Countries',
            'regionsNames' => 'Regions',
            'sectorsIds' => 'Sectors',
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
    public function getExhibitionProducts()
    {
        return $this->hasMany(ExhibitionProduct::className(), ['exhibition_id' => 'id']);
    }

    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])->via('exhibitionProducts');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExhibitionSectors()
    {
        return $this->hasMany(ExhibitionSector::className(), ['exhibition_id' => 'id']);
    }

    public function getSectors()
    {
        return $this->hasMany(Sector::className(), ['id' => 'sector_id'])->via('exhibitionSectors');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExhibitionCountries()
    {
        return $this->hasMany(ExhibitionCountry::className(), ['exhibition_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExhibitionRegions()
    {
        return $this->hasMany(ExhibitionRegion::className(), ['exhibition_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ExhibitionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ExhibitionQuery(get_called_class());
    }

    protected function assignItems($items, $targetModel, $relationId, $byId, $byValue, $extraParams = [])
    {
        $old = $targetModel::find()->where([$byId => $byValue])->all();
        if (!empty($old) && is_array($old)) {
            foreach ($old as $m) {
                $m->delete();
            }
        }
        if (!empty($items) && is_array($items)) {
            foreach ($items as $i => $itemId) {
                $m = new $targetModel();
                $m->$byId = $byValue;
                $m->$relationId = $itemId;
                if (!empty($extraParams) && is_array($extraParams)) {
                    foreach ($extraParams as $paramName => $values) {
                        if ($m->hasProperty($paramName) && isset($values[$i])) {
                            $m->$paramName = $values[$i];
                        }
                    }
                }
                $m->save();
            }
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->assignItems($this->sectorsIds, '\common\models\ExhibitionSector', 'sector_id', 'exhibition_id', $this->id);
        $this->assignItems($this->countriesNames, '\common\models\ExhibitionCountry', 'country', 'exhibition_id', $this->id);
        $this->assignItems($this->regionsNames, '\common\models\ExhibitionRegion', 'region', 'exhibition_id', $this->id);
        parent::afterSave($insert, $changedAttributes);
    }

    public function afterFind()
    {
        parent::afterFind();
        $countries = $this->exhibitionCountries;
        if (!empty($countries) && is_array($countries)) {
            foreach ($countries as $model) {
                $this->countriesNames[] = $model->country;
            }
        }
        $regions = $this->exhibitionRegions;
        if (!empty($regions) && is_array($regions)) {
            foreach ($regions as $model) {
                $this->regionsNames[] = $model->region;
            }
        }
    }

    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $list = parent::toArray($fields, $expand, $recursive);
        $list['countries'] = $this->countriesNames;
        $list['regions'] = $this->regionsNames;
        $list['sectors'] = array_filter(array_values(ArrayHelper::map($this->sectors, 'id', function ($model) {
            return $model->portfolio ? $model->portfolio->uid : null;
        })));
        $list['businessUnit'] = $this->businessUnit && $this->businessUnit->portfolio ? $this->businessUnit->portfolio->uid : null;
        unset($list['business_unit_id']);
        return $list;
    }
}
