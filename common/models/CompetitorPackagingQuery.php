<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[CompetitorPackaging]].
 *
 * @see CompetitorPackaging
 */
class CompetitorPackagingQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CompetitorPackaging[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CompetitorPackaging|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
