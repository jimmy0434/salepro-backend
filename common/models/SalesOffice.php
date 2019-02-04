<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%sales_office}}".
 *
 * @property int $id
 * @property string $name
 * @property string $content
 * @property int $created_at
 * @property int $updated_at
 *
 * @property PortfolioSalesOffice[] $portfolioSalesOffices
 */
class SalesOffice extends \cnd\core\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sales_office}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['content'], 'string'],
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
            'content' => 'Content',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortfolioSalesOffices()
    {
        return $this->hasMany(PortfolioSalesOffice::className(), ['sales_office_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return SalesOfficeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SalesOfficeQuery(get_called_class());
    }
}
