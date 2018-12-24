<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11/15/2018
 * Time: 1:25 PM
 */

namespace restful\controllers;

use cnd\admin\models\activerecords\Log;
use common\models\Category;
use common\models\File;
use common\models\Form;
use Yii;
use cnd\core\api\SController;
use Swagger\Annotations as SWG;

/**
 * Class ArticleController
 */
class ArticleController extends SController
{
    /**
     * @SWG\Get(
     *     path="/contents",
     *     tags={"Cms"},
     *     summary="Retrieves the collection of Secure Cms Contents resources.",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Contents collection response",
     *         @SWG\Schema(ref = "#/definitions/Content")
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" ),
     *     @SWG\Parameter(name="page", required=false, in="query", type="integer", description="Page start from 1", default=1),
     *     @SWG\Parameter(name="pageSize", required=false, in="query", type="integer", description="Page Size default 25", default=25),
     *     @SWG\Parameter(name="category1", required=false, in="query", type="integer", description="Directory Category"),
     *     @SWG\Parameter(name="category2", required=false, in="query", type="integer", description="Classification Category"),
     *     @SWG\Parameter(name="keyword", required=false, in="query", type="string", description="Filter By Keyword")
     * )
     */
    public function actionList()
    {
        $response = [];

        $category1 = Yii::$app->request->get('category1');
        $category2 = Yii::$app->request->get('category2');
        $keyword = Yii::$app->request->get('keyword');
        $page = Yii::$app->request->get('page', 1);
        $pageSize = Yii::$app->request->get('pageSize', 25);

        $q = Yii::$app->cms->content->language(Yii::$app->language);
        if ($category1) {
            $q->condition([$q->table . '.category_id' => $category1]);
        }
        if ($category2) {
            $q->condition('FIND_IN_SET("' . $category2 . '",' . $q->table . '.categories)>0');
        }
        if ($keyword != null) {
            $q->search($keyword);
        }
        $q->publishedAndHotest();
        $q->sort(['position' => SORT_DESC, 'id' => SORT_DESC]);

        if($page == 1) {
            $countQ = clone $q->query;
            $response['total'] =  intval($countQ->count());
        }

        $q->page($page, $pageSize);
        $articles = $q->all();
        $list = [];
        if (!empty($articles) && is_array($articles)) {
            foreach ($articles as $article) {
                $data = $article->toArray();
                if ($article->section) {
                    $section = explode('-', $article->section);
                    if ($section[0] == 'file') {
                        if (isset($section[1]) && $section[1]) {
                            $data['file'] = File::findOne($section[1]);
                        }
                    } else if ($section[0] == 'form') {
                        if (isset($section[1]) && $section[1]) {
                            $data['form'] = Form::findOne($section[1]);
                        }
                    }
                }
                $list[] = $data;
            }
        }
        $response['articles'] = $list;
        $response['count'] = intval($q->count());
        Log::trace("Request Secure Contents [Directory Category:" . ($category1 ? $category1 : "--") . ",Classification Category:" . ($category2 ? $category2 : "--") . ",Keyword:" . ($keyword ? $keyword : "--") . ",Page:" . $page . ",Page Size:" . $pageSize . ",Result Count:" . intval($q->count()) . "]");
        return $response;
    }

    /**
     * @SWG\Get(
     *     path="/categories",
     *     tags={"Cms"},
     *     summary="Retrieves categories tree.",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Categories Tree Response",
     *         @SWG\Schema(ref = "#/definitions/Category")
     *     ),
     *     security = {{"Bearer": {}}},
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" )
     * )
     */
    public function actionCategories()
    {
        $categories = Category::treeList();
        $this->categoriesArrayIndex($categories);
        return ['categories' => $categories];
    }

    private function categoriesArrayIndex(&$categories)
    {
        if (!empty($categories) && is_array($categories)) {
            $categories = array_values($categories);
            foreach ($categories as &$category) {
                if (isset($category['children'])) {
                    $this->categoriesArrayIndex($category['children']);
                }
            }
        }
    }

}