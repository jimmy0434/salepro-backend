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


class Category extends \cnd\cms\models\activerecords\Category
{
    public static function treeList(){
        $refs = array();
        $list = array();
        $result = static::find()->where(['original_id'=>null])->orderBy(['parent_id'=>SORT_ASC])->all();
        if(!empty($result) && is_array($result)){
            foreach ($result as $row) {
                $ref = & $refs[$row->id];
                $ref['id'] = $row->id;
                $ref['parent_id'] = $row->parent_id;
                $ref['name']      = $row->name;
                $ref['status']      = $row->status;
                $ref['icon']      = $row->icon;
                if (!$row->parent_id) {
                    $list[$row->id] = & $ref;
                }
                else {
                    $refs[$row->parent_id]['children'][$row->id] = & $ref;
                }
            }
        }
        return $list;
    }
}