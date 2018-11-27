<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11/26/2018
 * Time: 11:25 AM
 */

namespace restful\controllers;

use common\models\DynamicForm;
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
                $relations = ArrayHelper::map($bi->schema->tableSchemas,'name',function($tableSchema){
                    /**
                     * @var $tableSchema \yii\db\TableSchema
                     */
                    $rel = [];
                    $fks = $tableSchema->foreignKeys;
                    if(!empty($fks) && is_array($fks)){
                        foreach($fks as $relation){
                            $keys = array_keys($relation);
                            if(isset($keys[1])) {
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
                return $data;

                $fieldRules = $model->tablesFields();

                foreach ($data as $tableName => $rows) {
                    if (in_array($tableName, $tables) && !empty($rows) && is_array($rows)) {
                        // initialize the model by table name value
                        $models[$tableName] = [
                            'class' => DynamicForm::generateModel($tableName, isset($fieldRules[$tableName])?$fieldRules[$tableName]:[]),
                            'model' => null,
                        ];
                        // find the model by id
                        if (array_key_exists('id', $rows) && $rows['id']) {
                            $models[$tableName]['model'] = ($models[$tableName]['class'])::findOne($rows['id']);
                        }
                        // create new model if not found
                        if ($models[$tableName]['model']) {
                            $models[$tableName]['model'] = new ($models[$tableName]['class'])();
                        }
                        // update model attributes values
                        foreach ($rows as $name => $value) {
                            $models[$tableName]['model']->setAttribute($name, $value);
                        }
                        // save the model
                        if($models[$tableName]['model']->save()) {
                            $result[] = $tableName.' has been '.($models[$tableName]['model']->isNewRecord?'inserted':'updated').' successfully.';
                        }else{
                            $this->error('invalid '.$tableName.' data', $models[$tableName]['model']->getErrors());
                        }
                    }
                }
                // add relation parent id
                foreach ($data as $tableName => $rows) {
                    if($models[$tableName]['model']->isNewRecord) {
                        if (isset($relations[$tableName]) && !empty($relations[$tableName]) && is_array($relations[$tableName])) {
                            foreach ($relations[$tableName] as $parentTable => $relAttr) {
                                $models[$tableName]['model']->$relAttr = $models[$parentTable]['model']->id;
                            }
                            $models[$tableName]['model']->save(false);
                        }
                    }
                }
            }
            return ['result' => $result];
        } else {
            $this->error('Form not found');
        }
    }
}