<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ProductSector]].
 *
 * @see ProductSector
 */
class ProductSectorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProductSector[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProductSector|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
