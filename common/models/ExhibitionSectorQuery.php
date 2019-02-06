<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ExhibitionSector]].
 *
 * @see ExhibitionSector
 */
class ExhibitionSectorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ExhibitionSector[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ExhibitionSector|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
