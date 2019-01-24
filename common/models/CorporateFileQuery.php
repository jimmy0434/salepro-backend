<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[CorporateFile]].
 *
 * @see CorporateFile
 */
class CorporateFileQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CorporateFile[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CorporateFile|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
