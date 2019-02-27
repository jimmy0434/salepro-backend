<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[BusinessUnitCertification]].
 *
 * @see BusinessUnitCertification
 */
class BusinessUnitCertificationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return BusinessUnitCertification[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return BusinessUnitCertification|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
