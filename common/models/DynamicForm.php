<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11/26/2018
 * Time: 12:16 PM
 */

namespace common\models;

use Yii;
use cnd\core\components\ActiveRecord;
use yii\helpers\Inflector;

class DynamicForm extends ActiveRecord
{
    public static function getDb()
    {
        return Yii::$app->bi;
    }


    private static $classesGenerated = [];
    public static function generateModel($tableName, $fields = []){
        $className = Inflector::id2camel($tableName, '_');
        $classNameSpace = '\common\models\dynamic\\'.$className;
        if(!isset(static::$classesGenerated[$classNameSpace])) {
            $rules = '' . PHP_EOL;
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

            $php = <<< PHP
namespace common\models\dynamic;

class {$className} extends \common\models\DynamicForm{

    public \$parentIndex = null;

    public static function tableName()
    {
        return '{$tableName}';
    }
    public static function generateModel(\$tableName, \$fields = []){
        throw new \Exception("This method is allowed only on parent generator model: `DynamicForm`");
    }
    
    public function rules(){
        \$rules = parent::rules();
        \$rules[] = ["parentIndex","safe"];
        {$rules}
        return \$rules;
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