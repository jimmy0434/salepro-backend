<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[CompetitorManager]].
 *
 * @see CompetitorManager
 */
class CompetitorManagerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CompetitorManager[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CompetitorManager|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
