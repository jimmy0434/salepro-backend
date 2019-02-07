<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%competitor_masterbatch_customer}}".
 *
 * @property int $id
 * @property int $competitor_id
 * @property int $competitor_masterbatch_id
 * @property string $name
 * @property string $country
 * @property string $share_percentage
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Competitor $competitor
 * @property CompetitorMasterbatchCustomer $competitorMasterbatch
 * @property CompetitorMasterbatchCustomer[] $competitorMasterbatchCustomers
 */
class CompetitorMasterbatchCustomer extends \cnd\core\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%competitor_masterbatch_customer}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(),[
            [['competitor_id', 'competitor_masterbatch_id'], 'integer'],
            [['name', 'country', 'share_percentage'], 'string', 'max' => 255],
            [['competitor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Competitor::className(), 'targetAttribute' => ['competitor_id' => 'id']],
            [['competitor_masterbatch_id'], 'exist', 'skipOnError' => true, 'targetClass' => CompetitorMasterbatch::className(), 'targetAttribute' => ['competitor_masterbatch_id' => 'id']],
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
            'competitor_masterbatch_id' => 'Competitor Masterbatch ID',
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
    public function getCompetitorMasterbatch()
    {
        return $this->hasOne(CompetitorMasterbatch::className(), ['id' => 'competitor_masterbatch_id']);
    }

    /**
     * {@inheritdoc}
     * @return CompetitorMasterbatchCustomerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompetitorMasterbatchCustomerQuery(get_called_class());
    }
}
