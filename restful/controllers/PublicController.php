<?php
/**
 * Created by PhpStorm.
 * User: JawdatSobh
 * Date: 08/11/2018
 * Time: 14:42
 */

namespace restful\controllers;

use common\models\DataList;
use Yii;
use cnd\core\api\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

class PublicController extends Controller
{
    /**
     * @SWG\Get(
     *     path="/ping",
     *     summary="Ping",
     *     @SWG\Response(
     *          response = 200,
     *          description = "Ping Response"
     *     )
     * )
     */
    public function actionPing()
    {
        return [];
    }

    /**
     * @SWG\Get(
     *     path="/data-list",
     *     summary="Drop Down Data List",
     *     @SWG\Response(
     *          response = 200,
     *          description = "Data List Response"
     *     )
     * )
     */
    public function actionDataList()
    {
        $m = new DataList();
        $types = $m->type_list;
        $emptyList = [];
        if (!empty($types) && is_array($types)) {
            foreach ($types as $value => $name) {
                if (!in_array($value, [DataList::TYPE_PRODUCTION_LINE])) {
                    $key = lcfirst(Inflector::id2camel($name, '_'));
                    $emptyList[$key] = [];
                }
            }
        }
        $relations = DataList::listRelations();

        $query = DataList::find();
        $query->where(['parent_id' => null]);
        $query->orderBy(['name' => SORT_ASC]);
        $list = $query->all();
        $result = [];
        if(!empty($list) && is_array($list)){
            foreach($list as $model){
                $key = lcfirst(Inflector::id2camel($model->type_label, '_'));
                if(!isset($result[$key])){
                    $result[$key] = [];
                }
                $down = $model->down;
                $v = [
                    'value' => $model->name,
                ];
                if(count($down) > 0){
                    $v['childName'] = isset($relations[$model->type]) ? lcfirst(Inflector::id2camel($types[$relations[$model->type]], '_')) : null;
                    $v['childValues'] = array_values(ArrayHelper::map($down, 'name', 'name'));
                }
                $result[$key][] = $v;
            }
        }
        return array_merge($emptyList, $result);
    }
}
