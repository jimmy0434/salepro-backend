<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[FormApprovalUser]].
 *
 * @see FormApprovalUser
 */
class FormApprovalUserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return FormApprovalUser[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return FormApprovalUser|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
