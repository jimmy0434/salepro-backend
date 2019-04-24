<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11/26/2018
 * Time: 12:16 PM
 */

namespace common\models;

use Yii;
use yii\helpers\Inflector;

class DynamicForm extends \common\components\ActiveRecord
{
    public static function getDb()
    {
        return Yii::$app->bi;
    }


    private static $classesGenerated = [];

    public static function generateModel($tableName, $fields = [], $relations = [])
    {
        $className = Inflector::id2camel($tableName, '_');
        $classNameSpace = '\common\models\dynamic\\' . $className;
        if (!isset(static::$classesGenerated[$classNameSpace])) {
            $rules = '' . PHP_EOL;
            $rel = '' . PHP_EOL;
            $toArr = '' . PHP_EOL;
            if (!empty($fields) && is_array($fields)) {
                foreach ($fields as $name => $rv) {
                    if ($rv['required']) {
                        $rules .= <<< PHP
        \$rules[] = ["{$name}","required"];
PHP;
                        $rules .= PHP_EOL;
                    }
                    if ($rv['validation']) {
                        $validation = $rv['validation'];
                        $rules .= <<< PHP
        \$rules[] = ["{$name}","match","pattern" => "/{$validation}/i"];
PHP;
                        $rules .= PHP_EOL;
                    }
                }
            }
            if(!empty($relations) && is_array($relations)){
                foreach($relations as $relationName){
                    $relationFunction = 'get'.Inflector::id2camel($relationName, '_');
                    $relationClassName = Inflector::id2camel($relationName, '_');
                    $relationClassNameSpace = '\common\models\dynamic\\' . $relationClassName;
                    $rel .= <<< PHP
    public function {$relationFunction}(){
        return \$this->hasMany({$relationClassNameSpace}::className(),["parent_relation_id"=>"id"]);
    }
PHP;
                    $rel .= PHP_EOL.PHP_EOL;
                    $toArr .= <<< PHP
        \$list['{$relationName}'] = \$this->{$relationFunction}()->all();
PHP;
                    $toArr .= PHP_EOL;
                }
            }

            $php = <<< PHP
namespace common\models\dynamic;

class {$className} extends \common\models\DynamicForm{

    public static function tableName()
    {
        return '{$tableName}';
    }
    public static function generateModel(\$tableName, \$fields = [], \$relations = []){
        throw new \Exception("This method is allowed only on parent generator model: `DynamicForm`");
    }
    
    public function rules(){
        \$rules = parent::rules();
        {$rules}
        return \$rules;
    }
    
    {$rel}
    
    public function toArray(array \$fields = [], array \$expand = [], \$recursive = true)
    {
        \$list = parent::toArray(\$fields, \$expand, \$recursive);
        {$toArr}
        if(\$this->hasProperty("parent_relation_id")){
            unset(\$list["parent_relation_id"]);
        }
        \$list["created_at"] = date("Y-m-d H:i:s", \$list["created_at"]);
        \$list["updated_at"] = date("Y-m-d H:i:s", \$list["updated_at"]);
        return \$list;
    }
}
PHP;
            Yii::trace($php, 'Dynamic Model Form');
            eval($php);
            static::$classesGenerated[$classNameSpace] = $php;
        }
        $r = new \ReflectionClass($classNameSpace);
        return $r->getName();
    }
}
