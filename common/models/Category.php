<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 12/18/2018
 * Time: 12:05 PM
 */

namespace common\models;


use yii\helpers\Json;

class Category extends \cnd\cms\models\activerecords\Category
{
    public static function treeList()
    {
        $refs = array();
        $list = array();
        $result = static::find()->where(['original_id' => null, 'status' => static::STATUS_ACTIVE])->orderBy(['parent_id' => SORT_ASC])->all();
        if (!empty($result) && is_array($result)) {
            foreach ($result as $row) {
                $icon = \Yii::createObject([
                    'class' => 'cnd\filemanager\components\FileOutput',
                    'data' =>  $row->icon,
                ]);
                $ref = &$refs[$row->id];
                $ref['id'] = $row->id;
                $ref['parent_id'] = $row->parent_id;
                $ref['name'] = $row->name;
                $ref['status'] = $row->status;
                $ref['icon'] = $icon->url.'?t='.$row->updated_at;
                if (!$row->parent_id) {
                    $list[$row->id] = &$ref;
                } else {
                    $refs[$row->parent_id]['children'][$row->id] = &$ref;
                }
            }
        }
        return $list;
    }
}