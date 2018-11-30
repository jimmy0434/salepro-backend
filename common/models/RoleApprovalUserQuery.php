<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[RoleApprovalUser]].
 *
 * @see RoleApprovalUser
 */
class RoleApprovalUserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return RoleApprovalUser[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return RoleApprovalUser|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
