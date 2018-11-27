<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11/15/2018
 * Time: 1:25 PM
 */

namespace restful\controllers;

use common\models\File;
use common\models\Form;
use Yii;
use cnd\core\api\SController;

class ArticleController extends SController
{

    public function actionList(){
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
        $q->sort(['position' => SORT_DESC, 'id' => SORT_DESC]);

        $articles = $q->all();
        $list = [];
        if(!empty($articles) && is_array($articles)){
            foreach($articles as $article){
                $data = $article->toArray();
                if($article->section) {
                    $section = explode('-', $article->section);
                    if($section[0] == 'file') {
                        if (isset($section[1]) && $section[1]) {
                            $data['file'] = File::findOne($section[1]);
                        }
                    }else if($section[0] == 'form') {
                        if (isset($section[1]) && $section[1]) {
                            $data['form'] = Form::findOne($section[1]);
                        }
                    }
                }
                $list[] = $data;
            }
        }

        return ['articles' => $list, 'count' => intval($q->count())];
    }

}