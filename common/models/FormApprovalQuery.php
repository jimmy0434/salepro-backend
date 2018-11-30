<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[FormApproval]].
 *
 * @see FormApproval
 */
class FormApprovalQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return FormApproval[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return FormApproval|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
