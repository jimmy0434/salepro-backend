<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[NewsSector]].
 *
 * @see NewsSector
 */
class NewsSectorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return NewsSector[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return NewsSector|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
