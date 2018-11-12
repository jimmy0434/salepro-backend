<?php
/**
 * Created by PhpStorm.
 * User: JawdatSobh
 * Date: 12/11/2018
 * Time: 14:32
 */

namespace restful\controllers;

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

        return ['articles' => $q->all(), 'count' => $q->count()];
    }
}