<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/7/2019
 * Time: 10:41 AM
 */

namespace restful\controllers;


use cnd\core\api\SController;
use common\models\DataList;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use common\models\StatisticNumber;

class DataController extends SController
{
    /**
     * @SWG\Get(
     *     path="/statistic-numbers",
     *     tags={"Data"},
     *     summary="Retrieves all Statistic Numbers",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Statistic Numbers response"
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" )
     * )
     */
    public function actionStatisticNumbers(){
        $models = StatisticNumber::find()->all();
        return $models;
    }

    /**
     * @SWG\Get(
     *     path="/data-list",
     *     tags={"Data"},
     *     summary="Drop Down Data List",
     *     @SWG\Response(
     *          response = 200,
     *          description = "Data List Response"
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" )
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
