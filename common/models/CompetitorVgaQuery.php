<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[CompetitorVga]].
 *
 * @see CompetitorVga
 */
class CompetitorVgaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CompetitorVga[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CompetitorVga|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
