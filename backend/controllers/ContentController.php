<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 12/20/2018
 * Time: 8:41 AM
 */

namespace backend\controllers;

use cnd\cms\models\activerecords\Category;
use cnd\cms\models\activerecords\Content;
use Yii;
use cnd\core\components\SController;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Response;

class ContentController extends SController
{
    public function actionIndex()
    {
        return $this->render("index");
    }

    public function actionSaveCategory()
    {
        $request = Yii::$app->request;
        $response = Yii::$app->response;
        if ($request->isPost && $request->isAjax) {
            $response->format = Response::FORMAT_JSON;
            $response = [];

            $id = $request->post('id');
            $name = $request->post('name');
            $parent = $request->post('parent');

            $model = Category::findOne($id);
            if (!$model) {
                // create new category
                $model = new Category();
                $model->parent_id = $parent;
                $model->status = Category::STATUS_ACTIVE;
                $model->config = Json::decode('{"template":"none","comments":"0","tags":"0","category":"0","related":"0","reaction":"0","share":"0"}');
                $model->setting = Json::decode('{"markdown":"0"}');
                $model->path = Yii::$app->cms->getId('cms.category.classifications') . ',' . $parent;
                if ($model->save()) {
                    $modelLang = new Category();
                    $modelLang->original_id = $model->id;
                    $modelLang->language = 'en';
                    $modelLang->name = $name;
                    $modelLang->save();
                    $id = $model->id;
                    $model = Category::findOne($id);
                }
            } else {
                // update existing category
                $modelLang = $model->getLanguageRecord('en')->one();
                if ($modelLang) {
                    $modelLang->name = $name;
                    $modelLang->save();
                }
            }
            $response['model'] = $model;
            return $response;
        }
        return $this->redirect(['index']);
    }

    public function actionUploadCategoryIcon()
    {
        $request = Yii::$app->request;
        $response = Yii::$app->response;
        if ($request->isPost && $request->isAjax) {
            $response->format = Response::FORMAT_JSON;
            $response = [];

            $id = $request->post('id');
            $data = $request->post('data');
            $extension = $request->post('extension');

            $model = Category::findOne($id);
            if ($model) {
                list($type, $data) = explode(';', $data);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);
                $path = Yii::getAlias("@static/public/media/categories");
                if (!is_dir($path)) {
                    mkdir($path, 0777);
                }
                $path .= "/" . date("Y-m");
                if (!is_dir($path)) {
                    mkdir($path, 0777);
                }
                $filename = "category-" . $id . "-" . time() . "." . $extension;
                $path .= "/" . $filename;
                if (file_put_contents($path, $data)) {
                    $url = str_replace('/cnd-admin', '', Url::base(true)) . '/cnd-static/public/media/categories/' . date('Y-m') . '/' . $filename;
                    $icon = Json::encode([
                        'id' => $filename,
                        'title' => $filename,
                        'thumbnail' => $url,
                        'extension' => $extension,
                        'icon' => $url,
                        'url' => $url,
                        'provider' => 'local',
                        'type' => "image/" . $extension,
                        'size' => Yii::$app->helper->sizeFormat(filesize($path)),
                    ]);
                    $model->icon = [$icon];
                    $model->save();
                    $response['done'] = true;
                } else {
                    $response['done'] = false;
                }
            } else {
                $response['done'] = false;
            }
            return $response;
        }
        return $this->redirect(['index']);
    }

    public function actionList()
    {
        $request = Yii::$app->request;
        $response = Yii::$app->response;
        if ($request->isGet && $request->isAjax) {
            $response->format = Response::FORMAT_JSON;
            $response = [];
            $directoryId = $request->get("directoryId");
            $classificationId = $request->get("classificationId");
            $page = $request->get("page", 1);
            $pageSize = $request->get("pageSize", 30);

            $query = Content::find();
            $query->where(['content.category_id' => $directoryId])->andWhere('FIND_IN_SET("' . $classificationId . '",content.categories)>0');
            $query->andWhere(['content.original_id' => null, 'content.status' => [Content::STATUS_PUBLISH, Content::STATUS_HOT]]);
            $query->from(['content' => Content::tableName()]);
            $query->joinWith([
                'languageRecord'
            ], 'LEFT JOIN');
            if($page == 1) {
                $countQ = clone $query;
                $response['count'] = $countQ->count();
            }
            $query->orderBy('content.position ASC, content.updated_at DESC');
            $query->limit($pageSize)->offset(($page - 1) * $pageSize);
            $response['list'] = $query->all();
            $response['query'] = Yii::$app->helper->sql($query);
            return $response;
        }
        return $this->redirect(['index']);
    }
}