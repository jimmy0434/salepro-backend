<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[RoleApproval]].
 *
 * @see RoleApproval
 */
class RoleApprovalQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return RoleApproval[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return RoleApproval|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
