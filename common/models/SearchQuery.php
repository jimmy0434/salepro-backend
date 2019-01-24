<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Search]].
 *
 * @see Search
 */
class SearchQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Search[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Search|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
