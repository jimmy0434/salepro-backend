<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[DataList]].
 *
 * @see DataList
 */
class DataListQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return DataList[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return DataList|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
