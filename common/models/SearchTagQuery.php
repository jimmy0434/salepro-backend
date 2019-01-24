<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[SearchTag]].
 *
 * @see SearchTag
 */
class SearchTagQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SearchTag[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SearchTag|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
