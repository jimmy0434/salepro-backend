<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ProductDetailItem]].
 *
 * @see ProductDetailItem
 */
class ProductDetailItemQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProductDetailItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProductDetailItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
