<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11/15/2018
 * Time: 1:25 PM
 */

namespace restful\controllers;

use cnd\admin\models\activerecords\Log;
use cnd\cms\models\activerecords\Category;
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
     *     @SWG\Parameter( name="Authorization", in="header", required=true, type="string", default="Bearer TOKEN", description="Authorization" )
     * )
     */
    public function actionList()
    {
        $category = Yii::$app->request->get('category');
        $keyword = Yii::$app->request->get('keyword');
        $page = Yii::$app->request->get('page', 1);
        $pageSize = Yii::$app->request->get('pageSize', 25);

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
        Log::trace("Request Secure Contents [Category:" . ($category ? $category : "--") . ",Keyword:" . ($keyword ? $keyword : "--") . ",Page:" . $page . ",Page Size:" . $pageSize . ",Result Count:" . intval($q->count()) . "]");
        return ['articles' => $list, 'count' => intval($q->count())];
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