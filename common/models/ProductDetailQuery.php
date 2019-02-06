<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ProductDetail]].
 *
 * @see ProductDetail
 */
class ProductDetailQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProductDetail[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProductDetail|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
