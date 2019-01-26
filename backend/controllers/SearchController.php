<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 1/26/2019
 * Time: 10:27 AM
 */

namespace backend\controllers;

use common\models\Tag;
use Yii;
use cnd\core\components\SController;

class SearchController extends SController
{
    public function actionFindTags($q,$page = 1){
        Yii::$app->response->format = 'json';
        $response = [];
        $total = Tag::find()->count();

        $query = Tag::find();
        $query->andWhere('name like "%'.$q.'%"');
        $query->limit(30);
        $query->offset(($page - 1)*30);
        $list = $query->all();

        if(!empty($list) && is_array($list)){
            foreach($list as $model){
                $response[] = [
                    'id' => $model->id,
                    'text' => $model->name,
                ];
            }
        }
        return ['items'=>$response,'total_count'=>$total];
    }

    public function actionAddTag(){
        Yii::$app->response->format = 'json';
        $name = Yii::$app->request->post('name');
        $model = new Tag();
        $model->name = $name;
        $model->save();
        return ['id'=>$model->id];
    }
}