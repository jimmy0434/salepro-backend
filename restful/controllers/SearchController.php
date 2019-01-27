<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 1/27/2019
 * Time: 10:36 AM
 */

namespace restful\controllers;

use common\models\Search;
use common\models\SearchTag;
use common\models\Tag;
use Yii;
use cnd\core\api\SController;

class SearchController extends SController
{
    public function actionFind()
    {
        $keyword = Yii::$app->request->get('keyword');
        $page = Yii::$app->request->get('page', 1);
        $pageSize = Yii::$app->request->get('pageSize', 25);

        $query = Search::find();
        $query->from(['search' => Search::tableName()]);
        $query->joinWith([
            'searchTags' => function ($query) {
                $query->from(['searchTags' => SearchTag::tableName()]);
            },
            'tags' => function ($query) {
                $query->from(['tags' => Tag::tableName()]);
            }
        ]);
        $sql = [];
        $sql[] = 'tags.name like "%' . $keyword . '%"';
        $sql[] = 'search.title like "%' . $keyword . '%"';
        $sql[] = 'search.text like "%' . $keyword . '%"';
        $query->where(implode(' OR ', $sql));
        $query->limit($pageSize)->offset(($page - 1) * $pageSize);
        $results = $query->all();
        return ['results' => $results];
    }
}