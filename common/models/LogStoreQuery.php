<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[LogStore]].
 *
 * @see LogStore
 */
class LogStoreQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return LogStore[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return LogStore|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
