<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[LogStoreChange]].
 *
 * @see LogStoreChange
 */
class LogStoreChangeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return LogStoreChange[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return LogStoreChange|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
