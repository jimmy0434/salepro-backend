<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[AppUsage]].
 *
 * @see AppUsage
 */
class AppUsageQuery extends \yii\db\ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return AppUsage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AppUsage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
