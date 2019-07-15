<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[CompetitorCertification]].
 *
 * @see CompetitorCertification
 */
class CompetitorCertificationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CompetitorCertification[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CompetitorCertification|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
