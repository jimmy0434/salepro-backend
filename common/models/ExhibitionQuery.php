<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Exhibition]].
 *
 * @see Exhibition
 */
class ExhibitionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Exhibition[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Exhibition|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
