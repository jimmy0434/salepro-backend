<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%market_research}}".
 *
 * @property int $id
 * @property string $country
 * @property string $region
 * @property string $year
 * @property string $source
 * @property int $product_id
 * @property int $file_id
 * @property int $search_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Search $search
 * @property File $file
 * @property Product $product
 */
class MarketResearch extends \cnd\core\components\ActiveRecord
{

    public $tags = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%market_research}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['product_id', 'file_id', 'search_id'], 'integer'],
            [['country', 'region', 'year', 'source'], 'string', 'max' => 255],
            //[['search_id'], 'exist', 'skipOnError' => true, 'targetClass' => Search::className(), 'targetAttribute' => ['search_id' => 'id']],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['file_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['tags'], 'safe'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'country' => 'Country',
            'region' => 'Region',
            'year' => 'Year',
            'source' => 'Source',
            'product_id' => 'Product ID',
            'file_id' => 'File ID',
            'search_id' => 'Search ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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
    public function getFile()
    {
        return $this->hasOne(File::className(), ['id' => 'file_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * {@inheritdoc}
     * @return MarketResearchQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MarketResearchQuery(get_called_class());
    }

    public function afterSave($insert, $changedAttributes)
    {
        if($this->product && $this->product->portfolio) {
            $search = Search::updateRecord($this->tags, 'market-' . $this->id, $this->product->portfolio->name, $this->product->portfolio->description);
            if (!$this->search_id) {
                try {
                    Yii::$app->db->createCommand()->update(static::tableName(), ['search_id' => $search->id], ['id' => $this->id])->execute();
                } catch (\Throwable $t) {
                } catch (\Exception $e) {
                }
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }
}
