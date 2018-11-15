<?php
/**
 * Created by PhpStorm.
 * User: JawdatSobh
 * Date: 12/11/2018
 * Time: 14:32
 */

namespace restful\controllers;

use common\models\File;
use common\models\FilePartition;
use Yii;
use cnd\core\api\SController;
use yii\db\Expression;

class FileController extends SController
{
    public function actionContents(){
        $category = Yii::$app->request->get('category');
        $keyword = Yii::$app->request->get('keyword');
        $page = Yii::$app->request->get('page',1);
        $pageSize = Yii::$app->request->get('pageSize',25);

        $q = Yii::$app->cms->content->language(Yii::$app->language)->page($page, $pageSize);
        if ($category != null) {
            $q->category($category);
        }
        if ($keyword != null) {
            $q->search($keyword);
        }
        $q->publishedAndHotest();
        $q->condition(new Expression('section like "file-%"'));
        $q->sort(['position' => SORT_DESC, 'id' => SORT_DESC]);

        $articles = $q->all();
        $list = [];
        if(!empty($articles) && is_array($articles)){
            foreach($articles as $article){
                $data = $article->toArray();
                $section = explode('-',$article->section);
                if(isset($section[1]) && $section[1]) {
                    $data['file'] = File::findOne($section[1]);
                }
                $list[] = $data;
            }
        }

        return ['articles' => $list, 'count' => $q->count()];
    }

    public function actionDownload(){
        $fileId = Yii::$app->request->post('id');
        $version = Yii::$app->request->post('version');
        $order = Yii::$app->request->post('order', 0);
        $partition = FilePartition::find()->where(['file_id'=>$fileId,'version'=>$version,'order'=>$order])->one();
        $partition->data = base64_encode($partition->data);
        return ['partition' => $partition];
    }
}