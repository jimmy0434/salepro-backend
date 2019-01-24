<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ExhibitionItem]].
 *
 * @see ExhibitionItem
 */
class ExhibitionItemQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ExhibitionItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ExhibitionItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
