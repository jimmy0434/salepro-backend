<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Learning]].
 *
 * @see Learning
 */
class LearningQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Learning[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Learning|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
