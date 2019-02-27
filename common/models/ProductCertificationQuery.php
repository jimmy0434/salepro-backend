<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ProductCertification]].
 *
 * @see ProductCertification
 */
class ProductCertificationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProductCertification[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProductCertification|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
