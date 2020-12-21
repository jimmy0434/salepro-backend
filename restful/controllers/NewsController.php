<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 1/26/2019
 * Time: 11:34 AM
 */

namespace restful\controllers;



use cnd\admin\models\activerecords\Log;
use cnd\admin\models\activerecords\Setting;
use Yii;
use cnd\core\api\SController;
use common\models\News;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

class NewsController extends SController
{
    

    public function actionList()
    {
        $news = $this->list();
    

        Log::trace('Download news Items Data');

        return [
            'news' => $news,
           
        ];
    }

   

    protected function list()
    {
        $page = Yii::$app->request->get('page', 1);
        $pageSize = Yii::$app->request->get('pageSize', 250);

        $query = News::find();
        $query->limit($pageSize)->offset(($page - 1) * $pageSize);
        $query->orderBy(['created_at' => SORT_DESC]);
    
  
        $query->from(['News' => News::tableName()]);
       
        return $query->all();
    }

  
    public function actionOne($id)
    {
        $query = news::find();
        $query->where(['id' => $id]);
        $model = $query->one();
        Log::trace("Download news Item Data", $model->title);
        return ['news' => $model];
    }

   


}
