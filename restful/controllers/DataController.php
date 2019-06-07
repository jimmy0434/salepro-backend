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


use Yii;
use cnd\admin\models\activerecords\Log;
use cnd\admin\models\activerecords\Setting;
use cnd\core\api\SController;
use common\models\DataList;
use common\models\File;
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
    public function actionStatisticNumbers()
    {
        Log::trace('Download Statistic Numbers');
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
        if (!empty($list) && is_array($list)) {
            foreach ($list as $model) {
                $label = $model->type_label;
                /*if($model->type == DataList::TYPE_LINE_BRAND){
                    $label = $model->type_list[DataList::TYPE_PRODUCTION_LINE];
                }else if($model->type == DataList::TYPE_PRODUCTION_LINE){
                    $label = $model->type_list[DataList::TYPE_LINE_BRAND];
                }*/
                $key = lcfirst(Inflector::id2camel($label, '_'));
                if (!isset($result[$key])) {
                    $result[$key] = [];
                }
                $down = $model->down;
                $v = [
                    'value' => $model->name,
                ];
                if (count($down) > 0) {
                    $v['childName'] = isset($relations[$model->type]) ? lcfirst(Inflector::id2camel($types[$relations[$model->type]], '_')) : null;
                    $v['childValues'] = array_values(ArrayHelper::map($down, 'name', 'name'));
                }
                $result[$key][] = $v;
            }
        }
        Log::trace('Download Data List');
        return array_merge($emptyList, $result);
    }

    /**
     * @SWG\Get(
     *     path="/marketing-directory",
     *     tags={"Data"},
     *     summary="Marketing Directory File",
     *     @SWG\Response(
     *          response = 200,
     *          description = "Marketing Directory Response"
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" )
     * )
     */
    public function actionMarketingDirectory()
    {
        $id = Setting::get('marketing.directory.file.id', null);
        $file = File::findOne($id);
        Log::trace('Download Marketing Directory Meta File');
        return ['file' => $file];
    }

    /**
     * @SWG\Get(
     *     path="/chatbot",
     *     tags={"Data"},
     *     summary="External chatbot link",
     *     @SWG\Response(
     *          response = 200,
     *          description = "Chatbot Link Response"
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" )
     * )
     */
    public function actionChatbotLink()
    {
        $link = Setting::get('chatbot.link', null);
        Log::trace('Download Chatbot Link');
        return ['link' => $link];
    }

    /**
     * @SWG\Post(
     *     path="/logs",
     *     tags={"Data"},
     *     summary="Add log message",
     *     @SWG\Response(
     *          response = 200,
     *          description = "Log Response"
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" ),
     *     @SWG\Parameter(name="message", required=true, in="formData", type="string", description="Log Message")
     * )
     */
    public function actionAddLog()
    {
        $message = Yii::$app->request->post('message');
        if ($message) {
            Log::trace($message);
            return ['done' => true];
        }
        $this->error('`message` parameter is required');
        return null;
    }
}
