<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 12/14/2018
 * Time: 4:09 PM
 */

namespace backend\components\biSync;

use Yii;
use backend\components\BiSync;
use yii\helpers\Json;

class Content extends BiSync
{
    public function getTargetTable()
    {
        return "content";
    }

    public function run()
    {
        $this
            ->attr("title", $this->model->title)
            ->attr("excerpt", $this->model->excerpt)
            ->attr("text", $this->model->text)
            ->attr("status", strtolower($this->model->status_label))
            ->attr("position", $this->model->position)
            ->attr("view_count", $this->model->view);
    }

    public function execute()
    {
        parent::execute();
        if ($this->action == "edit") {
            $this->executeRelations("delete");
            $this->action = "add";
        }
        $this->executeRelations($this->action);
    }

    public function executeRelations($action)
    {
        $this->executeCategoryRelation($this->model->category_id, true, $action);
        $categories = is_string($this->model->categories) ? explode(',', $this->model->categories) : $this->model->categories;
        if (!empty($categories) && is_array($categories)) {
            foreach ($categories as $categoryId) {
                if($categoryId) {
                    $this->executeCategoryRelation($categoryId, false, $action);
                }
            }
        }

        $tags = is_string($this->model->tags) ? explode(',', $this->model->tags) : $this->model->tags;
        if (!empty($tags) && is_array($tags)) {
            foreach ($tags as $tagId) {
                if($tagId) {
                    $this->executeTagRelation($tagId, $action);
                }
            }
        }

        $attrs = Yii::$app->helper->isJson($this->model->extra)?Json::decode($this->model->extra):$this->model->extra;
        if(!empty($attrs) && is_array($attrs) && isset($attrs['Attribute']) && isset($attrs['Value'])){
            foreach($attrs['Attribute'] as $i => $name){
                if(isset($attrs['Value'][$i])){
                    $this->executeAttrRelation($name, $attrs['Value'][$i], $action);
                }
            }
        }

        $images = Yii::$app->helper->isJson($this->model->gallery)?Json::decode($this->model->gallery):$this->model->gallery;
        if(!empty($images) && is_array($images)){
            foreach($images as $i => $image){
                $image = Yii::$app->helper->isJson($image)?Json::decode($image):$image;
                if(isset($image['url'])){
                    $url = Yii::$app->helper->hostName . $image['url'];
                    $this->executeImageRelation($url, $action);
                }
            }
        }
    }

    public function executeCategoryRelation($categoryId, $isPrimary, $action)
    {
        $model = (object)array(
            "id" => null,
            "content_id" => $this->model->id,
            "category_id" => $categoryId,
            "is_primary" => $isPrimary,
        );
        $obj = \Yii::createObject([
            "class" => ContentCategory::className(),
            "model" => $model,
            "action" => $action,
        ]);
        $obj->run();
        if ($action == 'delete') {
            $obj->deleteAll("content_id", $this->model->id);
        }else {
            $obj->execute();
        }
    }

    public function executeTagRelation($tagId, $action){
        $model = (object)array(
            "id" => null,
            "content_id" => $this->model->id,
            "tag_id" => $tagId,
        );
        $obj = \Yii::createObject([
            "class" => ContentTag::className(),
            "model" => $model,
            "action" => $action,
        ]);
        $obj->run();
        if ($action == 'delete') {
            $obj->deleteAll("content_id", $this->model->id);
        }else {
            $obj->execute();
        }
    }

    public function executeAttrRelation($name, $value, $action){
        $model = (object)array(
            "id" => null,
            "content_id" => $this->model->id,
            "name" => $name,
            "value" => $value,
        );
        $obj = \Yii::createObject([
            "class" => ContentAttribute::className(),
            "model" => $model,
            "action" => $action,
        ]);
        $obj->run();
        if ($action == 'delete') {
            $obj->deleteAll("content_id", $this->model->id);
        }else {
            $obj->execute();
        }
    }

    public function executeImageRelation($image, $action){
        $model = (object)array(
            "id" => null,
            "content_id" => $this->model->id,
            "image" => $image,
        );
        $obj = \Yii::createObject([
            "class" => ContentImage::className(),
            "model" => $model,
            "action" => $action,
        ]);
        $obj->run();
        if ($action == 'delete') {
            $obj->deleteAll("content_id", $this->model->id);
        }else {
            $obj->execute();
        }
    }
}