<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[CompetitorSocial]].
 *
 * @see CompetitorSocial
 */
class CompetitorSocialQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CompetitorSocial[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CompetitorSocial|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
