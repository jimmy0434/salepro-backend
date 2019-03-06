<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%competitor_flexible_customer}}".
 *
 * @property int $id
 * @property int $competitor_id
 * @property int $competitor_flexible_id
 * @property string $name
 * @property string $country
 * @property string $share_percentage
 * @property int $created_at
 * @property int $updated_at
 *
 * @property CompetitorFlexibleCustomer $competitorFlexible
 * @property CompetitorFlexibleCustomer[] $competitorFlexibleCustomers
 * @property Competitor $competitor
 */
class CompetitorFlexibleCustomer extends \cnd\core\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%competitor_flexible_customer}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['competitor_id', 'competitor_flexible_id'], 'integer'],
            //[['name', 'country', 'share_percentage'], 'string', 'max' => 255],
            [['competitor_flexible_id'], 'exist', 'skipOnError' => true, 'targetClass' => CompetitorFlexible::className(), 'targetAttribute' => ['competitor_flexible_id' => 'id']],
            [['competitor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Competitor::className(), 'targetAttribute' => ['competitor_id' => 'id']],
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
            'competitor_flexible_id' => 'Competitor Flexible ID',
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
    public function getCompetitorFlexible()
    {
        return $this->hasOne(CompetitorFlexible::className(), ['id' => 'competitor_flexible_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetitor()
    {
        return $this->hasOne(Competitor::className(), ['id' => 'competitor_id']);
    }

    /**
     * {@inheritdoc}
     * @return CompetitorFlexibleCustomerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompetitorFlexibleCustomerQuery(get_called_class());
    }
}
