<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%competitor_packaging_customer}}".
 *
 * @property int $id
 * @property int $competitor_id
 * @property int $competitor_packaging_id
 * @property string $name
 * @property string $country
 * @property string $share_percentage
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Competitor $competitor
 * @property CompetitorPackagingCustomer $competitorPackaging
 * @property CompetitorPackagingCustomer[] $competitorPackagingCustomers
 */
class CompetitorPackagingCustomer extends \cnd\core\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%competitor_packaging_customer}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['competitor_id', 'competitor_packaging_id'], 'integer'],
            [['name', 'country', 'share_percentage'], 'string', 'max' => 255],
            [['competitor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Competitor::className(), 'targetAttribute' => ['competitor_id' => 'id']],
            [['competitor_packaging_id'], 'exist', 'skipOnError' => true, 'targetClass' => CompetitorPackagingCustomer::className(), 'targetAttribute' => ['competitor_packaging_id' => 'id']],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'competitor_id' => 'Competitor ID',
            'competitor_packaging_id' => 'Competitor Packaging ID',
            'name' => 'Name',
            'country' => 'Country',
            'share_percentage' => 'Share Percentage',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetitor()
    {
        return $this->hasOne(Competitor::className(), ['id' => 'competitor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetitorPackaging()
    {
        return $this->hasOne(CompetitorPackagingCustomer::className(), ['id' => 'competitor_packaging_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetitorPackagingCustomers()
    {
        return $this->hasMany(CompetitorPackagingCustomer::className(), ['competitor_packaging_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return CompetitorPackagingCustomerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompetitorPackagingCustomerQuery(get_called_class());
    }
}
