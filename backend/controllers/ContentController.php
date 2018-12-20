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
use Yii;
use cnd\core\components\SController;
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
                $model->config = '{"template":"none","comments":"0","tags":"0","category":"0","related":"0","reaction":"0","share":"0"}';
                $model->setting = '{"markdown":"0"}';
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
}