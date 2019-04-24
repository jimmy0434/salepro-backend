<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%product_certification}}".
 *
 * @property int $id
 * @property int $product_id
 * @property int $certification_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Product $product
 * @property Certification $certification
 */
class ProductCertification extends \common\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%product_certification}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(),[
            [['product_id', 'certification_id'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['certification_id'], 'exist', 'skipOnError' => true, 'targetClass' => Certification::className(), 'targetAttribute' => ['certification_id' => 'id']],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'certification_id' => 'Certification ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCertification()
    {
        return $this->hasOne(Certification::className(), ['id' => 'certification_id']);
    }

    /**
     * {@inheritdoc}
     * @return ProductCertificationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductCertificationQuery(get_called_class());
    }
}
