<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11/26/2018
 * Time: 11:25 AM
 */

namespace restful\controllers;

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
            return ['form' => $model];
        } else {
            $this->error('Form not found');
        }
    }

    public function actionSave($id)
    {
        $model = Form::findOne($id);
        $result = [];
        if ($model) {
            $bi = Yii::$app->bi;
            $data = Yii::$app->request->post('data');
            if (!empty($data) && is_array($data)) {
                $tables = $bi->schema->tableNames;
                $models = [];

                /**
                 * get table relations
                 * @example
                 * Array
                 * (
                 *     [form1] => Array
                 *         (
                 *         )
                 *
                 *     [middle_table] => Array
                 *         (
                 *             [form1] => form1_id
                 *         )
                 *
                 *     [node_c] => Array
                 *         (
                 *             [middle_table] => middle_table_id
                 *         )
                 *
                 * )
                 */
                $relations = ArrayHelper::map($bi->schema->tableSchemas, 'name', function ($tableSchema) {
                    /**
                     * @var $tableSchema \yii\db\TableSchema
                     */
                    $rel = [];
                    $fks = $tableSchema->foreignKeys;
                    if (!empty($fks) && is_array($fks)) {
                        foreach ($fks as $relation) {
                            $keys = array_keys($relation);
                            if (isset($keys[1])) {
                                $name = $relation[0];
                                $k = $keys[1];
                                $rel[$name] = $k;
                            }
                        }
                    }
                    return $rel;
                });

                // fix data tables order
                $data = $model->sortFormData($data, $relations);

                $fieldRules = $model->tablesFields();
                $transaction = $bi->beginTransaction();
                try {
                    foreach ($data as $tableName => $rows) {
                        if (in_array($tableName, $tables) && !empty($rows) && is_array($rows)) {
                            foreach ($rows as $i => $row) {
                                // initialize the model by table name value
                                if (!isset($models[$tableName])) {
                                    $models[$tableName] = [];
                                }
                                $models[$tableName][$i] = [
                                    'class' => DynamicForm::generateModel($tableName, isset($fieldRules[$tableName]) ? $fieldRules[$tableName] : []),
                                    'model' => null,
                                ];
                                // find the model by id
                                if (array_key_exists('id', $row) && $row['id']) {
                                    $models[$tableName][$i]['model'] = ($models[$tableName]['class'])::findOne($row['id']);
                                }
                                // create new model if not found
                                if (!$models[$tableName][$i]['model']) {
                                    $models[$tableName][$i]['model'] = new $models[$tableName][$i]['class']();
                                }
                                // update model attributes values
                                foreach ($row as $name => $value) {
                                    if ($models[$tableName][$i]['model']->hasAttribute($name)) {
                                        $models[$tableName][$i]['model']->setAttribute($name, $value);
                                    }
                                }
                                if (!isset($row['parentIndex']) && isset($relations[$tableName]) && count($relations[$tableName]) > 0) {
                                    $result = [];
                                    $msg = 'Require parentIndex attribute for table ' . $tableName;
                                    $this->error($msg);
                                    throw new InvalidArgumentException($msg, 404);
                                }
                                // add relation parent id
                                if (array_key_exists('parentIndex', $row) && $row['parentIndex'] >= 0) {
                                    if (isset($relations[$tableName]) && !empty($relations[$tableName]) && is_array($relations[$tableName])) {
                                        reset($relations[$tableName]);
                                        $parentTable = key($relations[$tableName]);
                                        $relAttr = $relations[$tableName][$parentTable];
                                        $parentIndex = $row['parentIndex'];
                                        $models[$tableName][$i]['model']->$relAttr = $models[$parentTable][$parentIndex]['model']->id;
                                    }
                                }
                                // save the model
                                $isNewRecord = $models[$tableName][$i]['model']->isNewRecord;
                                if ($models[$tableName][$i]['model']->save()) {
                                    $result[] = $tableName . ' has been ' . ($isNewRecord ? 'created' : 'updated') . ' successfully.';
                                } else {
                                    $result = [];
                                    $msg = 'Invalid ' . $tableName . ' data';
                                    $this->error($msg, $models[$tableName][$i]['model']->getErrors());
                                    throw new InvalidArgumentException($msg, 404);
                                }
                            }
                        }
                    }
                    $transaction->commit();
                } catch (\Exception $e) {
                    $transaction->rollBack();
                } catch (\Throwable $t) {
                    $transaction->rollBack();
                }
            }
            return ['result' => $result];
        } else {
            $this->error('Form not found');
        }
    }

    public function actionCrud()
    {
        $tableName = Yii::$app->request->get('tableName');
        $id = Yii::$app->request->get('id');
        $page = Yii::$app->request->get('page',1);
        $pageSize = Yii::$app->request->get('pageSize',25);
        $parentId = Yii::$app->request->get('parentId',null);
        $search = Yii::$app->request->get('search',null);
        $order = Yii::$app->request->get('order',null);
        if(!$tableName || !$id){
            $this->error("Invalid Request, id and tableName are required");
            return null;
        }
        /**
         * @var $dataLocator DataLocator
         */
        $model = Form::findOne($id);
        if ($model) {
            return $model->crudData($tableName,$page,$pageSize,$parentId,$search,$order);
        } else {
            $this->error('Form not found');
        }
    }
}