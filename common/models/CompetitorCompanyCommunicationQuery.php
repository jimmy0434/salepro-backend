<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[CompetitorCompanyCommunication]].
 *
 * @see CompetitorCompanyCommunication
 */
class CompetitorCompanyCommunicationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CompetitorCompanyCommunication[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CompetitorCompanyCommunication|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
