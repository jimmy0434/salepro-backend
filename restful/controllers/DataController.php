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


use cnd\notification\models\NotificationUser;
use Yii;
use cnd\admin\models\activerecords\Log;
use cnd\admin\models\activerecords\Setting;
use cnd\core\api\SController;
use common\models\DataList;
use common\models\File;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use common\models\StatisticNumber;
use common\models\User;
use common\models\News;

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
                if (!in_array($value, [DataList::TYPE_LINE_BRAND, DataList::TYPE_SUPPLIER])) {
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
     * @SWG\Get(
     *     path="/dashboard",
     *     tags={"Data"},
     *     summary="External dashboard link",
     *     @SWG\Response(
     *          response = 200,
     *          description = "Dashboard Link Response"
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" )
     * )
     */
    public function actionDashboardLink2()
    {
       
     
  
    $link = Setting::get('dashboard.link', null);
    Log::trace('Download Dashboard Link');
    return ['link' => $link];
   

   
    }
    public function actionNewsLink()
    {
       
     
  
    $News =  News::find()->all();
    Log::trace('Download News');
    return ['News' => $News];
   

   
    }
    public function actionDashboardLink()
    {
      
        $user = Yii::$app->user->identity;
        $email = User::find()->select(['email'])->where(['id' => $user->id])->one();
       
       $email=$user->email;
    
       $email= substr($email, strpos($email, "@") + 1);
   
  
   if  ($email=='napcogroup.com'||$email=='napconational.com'){
    $link = Setting::get('dashboard.link2', null);
    Log::trace('Download Dashboard Link');
    return ['link' => $link];
   }
 //  if ($email=='indevcogroup.com')
  else {
    $link = Setting::get('dashboard.link', null);
    Log::trace('Download Dashboard Link');
    return ['link' => $link]; 
   }
   
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
            //Log::trace($message);
            Log::appLog($message);
            return ['done' => true];
        }
        $this->error('`message` parameter is required');
        return null;
    }

    public function actionWaitingNotifications()
    {
        $query = NotificationUser::find();
        $query->orderBy(['date' => SORT_DESC]);
        $query->andWhere(['user_id' => Yii::$app->user->identity->id, 'status' => NotificationUser::STATUS_SENT]);
        $list = $query->all();
        $response = [
            'count' => count($list),
            'notReadCount' => 0,
            'items' => [],
        ];
        if (!empty($list) && is_array($list)) {
            foreach ($list AS $l) {
                if ($l->status === NotificationUser::STATUS_SENT) {
                    $response['notReadCount']++;
                }
                $response['items'][] = $l;
            }
        }
        return $response;
    }
}
