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
use common\models\File;
use common\models\Form;
use Yii;
use yii\db\Exception;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Response;

class ContentController extends \cnd\cms\modules\admin\controllers\ContentController
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
            $query->andWhere(['content.original_id' => null]);
            $query->from(['content' => Content::tableName()]);
            $query->joinWith([
                'languageRecord'
            ], 'LEFT JOIN');
            if ($page == 1) {
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

    public function actionUploadContentCover()
    {
        $request = Yii::$app->request;
        $response = Yii::$app->response;
        if ($request->isPost && $request->isAjax) {
            $response->format = Response::FORMAT_JSON;
            $response = [];

            $id = $request->post('id');
            $data = $request->post('data');
            $extension = $request->post('extension');

            $model = Content::findOne($id);
            if ($model) {
                list($type, $data) = explode(';', $data);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);
                $path = Yii::getAlias("@static/public/media/contents");
                if (!is_dir($path)) {
                    mkdir($path, 0777);
                }
                $path .= "/" . date("Y-m");
                if (!is_dir($path)) {
                    mkdir($path, 0777);
                }
                $filename = "content-" . $id . "-" . time() . "." . $extension;
                $path .= "/" . $filename;
                if (file_put_contents($path, $data)) {
                    $url = str_replace('/cnd-admin', '', Url::base(true)) . '/cnd-static/public/media/contents/' . date('Y-m') . '/' . $filename;
                    $cover = Json::encode([
                        'id' => $filename,
                        'title' => $filename,
                        'thumbnail' => $url,
                        'extension' => $extension,
                        'icon' => $url,
                        'url' => $url,
                        'provider' => 'local',
                        'type' => "image",
                        'size' => Yii::$app->helper->sizeFormat(filesize($path)),
                    ]);
                    $model->gallery = [$cover];
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

    public function actionManage()
    {
        $response = Yii::$app->response;
        $this->layout = '@backend/views/layout/dialog.php';
        $ret = $this->manager->manage();
        if ($ret instanceOf $response) {
            echo "<script>window.addEventListener('load', function() {parent.postMessage( {'task': 'closeFancyBox'});});</script>";
            exit(0);
        }
        return $ret;
    }

    public function actionCreate()
    {
        $request = Yii::$app->request;
        $response = Yii::$app->response;
        if ($request->isPost && $request->isAjax) {
            $response->format = Response::FORMAT_JSON;
            $response = [];
            $response['done'] = false;

            $title = $request->post('title');
            $type = $request->post('type');
            $directory = $request->post('directory');
            $classification = $request->post('classification');
            $hasUrl = $request->post('hasUrl');
            $url = $request->post('url');

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $targetId = null;
                $status = Content::STATUS_PUBLISH;
                if ($type == 'file') {
                    $target = new File();
                    $target->title = $title;
                    $target->status = File::STATUS_ACTIVE;
                    if (!$target->save()) {
                        throw new Exception("File not created");
                    } else {
                        $targetId = $target->id;
                    }
                } else if ($type == 'form') {
                    $status = Content::STATUS_PENDING;
                    $target = new Form();
                    $target->title = $title;
                    $target->name = $target->createSlug($title);
                    $target->status = Form::STATUS_PENDING;
                    if (!$target->save()) {
                        throw new Exception("Form not created");
                    } else {
                        $targetId = $target->id;
                    }
                }
                $model = new Content();
                $model->status = $status;
                if ($targetId) {
                    $model->section = $type . '-' . $targetId;
                } else if ($hasUrl && in_array($type, ['url', 'rss']) && $url) {
                    $model->section = $type . '-0';
                    $model->external_url = [
                        'embeded' => 0,
                        'url' => $url,
                    ];
                }
                $model->category_id = $directory;
                $model->categories = $classification;
                if ($model->save()) {
                    $lang = new Content();
                    $lang->title = $title;
                    $lang->language = "en";
                    $lang->original_id = $model->id;
                    if ($lang->save()) {
                        $response['model'] = Content::findOne($model->id);
                        $response['done'] = true;
                    } else {
                        throw new Exception("Content not created");
                    }
                } else {
                    throw new Exception("Content not created");
                }
                $transaction->commit();
            } catch (\Throwable $t) {
                $transaction->rollBack();
            } catch (\Exception $e) {
                $transaction->rollBack();
            }

            return $response;
        }
        return $this->redirect(['index']);
    }

    public function actionRenameTitle()
    {
        $request = Yii::$app->request;
        $response = Yii::$app->response;
        if ($request->isPost && $request->isAjax) {
            $response->format = Response::FORMAT_JSON;
            $response = [];
            $response['done'] = false;

            $id = $request->post('id');
            $title = $request->post('title');
            $type = $request->post('type');

            $lang = Content::find()->where(['original_id' => $id, 'language' => 'en'])->one();
            if ($lang) {
                $lang->title = $title;
                if ($lang->save()) {
                    if (in_array($type, ['file', 'form'])) {
                        list($targetType, $targetId) = explode('-', $lang->original->section);
                        if ($type == 'file' && $targetId && $targetType == $type) {
                            $target = File::findOne($targetId);
                            $target->title = $title;
                            $target->save();
                        } else if ($type == 'form' && $targetId && $targetType == $type) {
                            $target = Form::findOne($targetId);
                            $target->title = $title;
                            $target->save();
                        }
                    }
                    $response['done'] = true;
                }
            }

            return $response;
        }
        return $this->redirect(['index']);
    }

    public function actionDeleteContent()
    {
        $request = Yii::$app->request;
        $response = Yii::$app->response;
        if ($request->isPost && $request->isAjax) {
            $response->format = Response::FORMAT_JSON;
            $response = [];
            $response['done'] = false;

            $id = $request->post('id');

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model = Content::findOne($id);
                if ($model) {
                    list($targetType, $targetId) = explode('-', $model->section);
                    if ($targetType == 'file') {
                        $target = File::findOne($targetId);
                        if ($target) {
                            if (!$target->delete()) {
                                throw new Exception("File not deleted");
                            }
                        }
                    } else if ($targetType == 'form') {
                        $target = Form::findOne($targetId);
                        if ($target) {
                            if (!$target->delete()) {
                                throw new Exception("Form not deleted");
                            }
                        }
                    }
                    if (!$model->delete()) {
                        throw new Exception("Content not deleted");
                    } else {
                        $response['done'] = true;
                    }
                }
                $transaction->commit();
            } catch (\Throwable $t) {
                $transaction->rollBack();
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
            return $response;
        }
        return $this->redirect(['index']);
    }
}