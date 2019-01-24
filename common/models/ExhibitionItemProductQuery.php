<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ExhibitionItemProduct]].
 *
 * @see ExhibitionItemProduct
 */
class ExhibitionItemProductQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ExhibitionItemProduct[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ExhibitionItemProduct|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
