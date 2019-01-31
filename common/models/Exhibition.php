<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%exhibition}}".
 *
 * @property int $id
 * @property string $name
 * @property string $country
 * @property string $region
 * @property string $year
 * @property int $file_id
 * @property int $business_unit_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property BusinessUnit $businessUnit
 * @property File $file
 * @property ExhibitionItem[] $exhibitionItems
 * @property ExhibitionItemProduct[] $exhibitionItemProducts
 * @property Product[] $products
 */
class Exhibition extends \cnd\core\components\ActiveRecord
{

    public $productsIds = [];

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
            [['file_id', 'business_unit_id'], 'integer'],
            [['name', 'country', 'region', 'year'], 'string', 'max' => 255],
            [['business_unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => BusinessUnit::className(), 'targetAttribute' => ['business_unit_id' => 'id']],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['file_id' => 'id']],
            [['productsIds'], 'safe'],
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
            'country' => 'Country',
            'region' => 'Region',
            'year' => 'Year',
            'file_id' => 'File ID',
            'business_unit_id' => 'Business Unit',
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
    public function getFile()
    {
        return $this->hasOne(File::className(), ['id' => 'file_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExhibitionItems()
    {
        return $this->hasMany(ExhibitionItem::className(), ['exhibition_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExhibitionItemProducts()
    {
        return $this->hasMany(ExhibitionItemProduct::className(), ['exhibition_id' => 'id']);
    }

    public function getProducts(){
        return $this->hasMany(Product::className(), ['id' => 'product_id'])->via('exhibitionItemProducts');
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
        $this->assignItems($this->productsIds, '\common\models\ExhibitionItemProduct', 'product_id', 'exhibition_id', $this->id);
        parent::afterSave($insert, $changedAttributes);
    }
}
