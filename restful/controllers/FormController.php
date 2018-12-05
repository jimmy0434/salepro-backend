<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11/26/2018
 * Time: 11:25 AM
 */

namespace restful\controllers;

use cnd\admin\models\activerecords\Log;
use cnd\grid\DataLocator;
use common\models\DynamicForm;
use http\Exception\InvalidArgumentException;
use Yii;
use cnd\core\api\SController;
use common\models\Form;
use yii\helpers\ArrayHelper;

class FormController extends SController
{
    public function actionOne($id)
    {
        $model = Form::findOne($id);
        if ($model) {
            Log::trace("Request form meta data #".$id);
            return ['form' => $model];
        } else {
            Log::trace("Requested form meta data #".$id." not found");
            $this->error('Form not found');
        }
    }

    public function actionSave($id){
        $model = Form::findOne($id);
        $result = [];
        if ($model) {
            $data = Yii::$app->request->post('data');
            if(!empty($data) && is_array($data)){
                $bi = Yii::$app->bi;
                $transaction = $bi->beginTransaction();
                try {
                    foreach($data as $tableName => $records){
                        $this->saveFormTable($model, $tableName, $records, $result);
                    }
                    Log::trace("Save data of form #".$id);
                    $transaction->commit();
                } catch (\Exception $e) {
                    Log::trace("Save data of form #".$id." Exception ".$e->getMessage());
                    $transaction->rollBack();
                } catch (\Throwable $t) {
                    Log::trace("Save data of form #".$id." Exception ".$t->getMessage());
                    $transaction->rollBack();
                }
                return ['result' => $result];
            }
        } else {
            Log::trace("Save data of form #".$id.", Form not found");
            $this->error('Form not found');
        }
    }

    private static $models = [];
    private function saveFormTable($model, $tableName, $records, &$result, $parentId = null){
        $bi = Yii::$app->bi;
        $tables = $bi->schema->tableNames;
        $fieldRules = $model->tablesFields();
        if (in_array($tableName, $tables) && !empty($records) && is_array($records)) {
            // initialize the model by table name value
            if (!isset(static::$models[$tableName])) {
                static::$models[$tableName] = DynamicForm::generateModel($tableName, isset($fieldRules[$tableName]) ? $fieldRules[$tableName] : []);
            }
            $cls = static::$models[$tableName];
            foreach ($records as $i => $row) {
                $modelForm = null;
                // find the model by id
                if (array_key_exists('id', $row) && $row['id']) {
                    $modelForm = $cls::findOne($row['id']);
                }
                // create new model if not found
                if (!$modelForm) {
                    $modelForm = new $cls();
                }
                $children = [];
                // update model attributes values
                foreach ($row as $name => $value) {
                    if(is_array($value) && !empty($value) && in_array($name, $tables)){
                        // save children callback
                        $children[] = function($parentId) use($model, $name, $value, &$result){
                            $this->saveFormTable($model, $name, $value, $result, $parentId);
                        };
                    }else if ($modelForm->hasAttribute($name)) {
                        $modelForm->setAttribute($name, $value);
                    }
                }
                $modelForm->user_id = Yii::$app->user->identity->id;
                // add relation parent id
                if($modelForm->hasAttribute('parent_relation_id') && $parentId > 0){
                    $modelForm->parent_relation_id = $parentId;
                }
                // save the model
                $isNewRecord = $modelForm->isNewRecord;
                if ($modelForm->save()) {
                    $result[] = $tableName . ' has been ' . ($isNewRecord ? 'created' : 'updated') . ' successfully.';
                    if(!empty($children) && is_array($children)){
                        foreach($children as $callback){
                            if(is_callable($callback)){
                                $callback($modelForm->id);
                            }
                        }
                    }
                } else {
                    $result = [];
                    $msg = 'Invalid ' . $tableName . ' data';
                    $this->error($msg, $modelForm->getErrors());
                    throw new InvalidArgumentException($msg, 404);
                }
            }
        }
    }

    public function actionCrud()
    {
        $id = Yii::$app->request->get('id');
        $page = Yii::$app->request->get('page',1);
        $pageSize = Yii::$app->request->get('pageSize',25);
        $search = Yii::$app->request->get('search',null);
        $order = Yii::$app->request->get('order',null);
        if(!$id){
            $this->error("Invalid Request, id are required");
            return null;
        }
        /**
         * @var $dataLocator DataLocator
         */
        $model = Form::findOne($id);
        if ($model) {
            $crud = $model->crudData($page,$pageSize,$search,$order);
            Log::trace("Request Form Crud [ID:".($id?$id:"--").",Search:".($search?$search:"--").",Page:".$page.",Page Size:".$pageSize.",Order:".($order?$order:"--").",Result Count:".intval($crud['count'])."]");
            return $crud;
        } else {
            Log::trace("Request Form Crud #".($id?$id:"--").", Form not found");
            $this->error('Form not found');
        }
    }
}