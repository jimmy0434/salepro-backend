<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[SteepAnalysis]].
 *
 * @see SteepAnalysis
 */
class SteepAnalysisQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SteepAnalysis[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SteepAnalysis|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
