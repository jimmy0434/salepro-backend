<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[CompetitorNews]].
 *
 * @see CompetitorNews
 */
class CompetitorNewsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CompetitorNews[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CompetitorNews|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
