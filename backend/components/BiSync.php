<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11/30/2018
 * Time: 8:35 AM
 */

namespace backend\components;

use Yii;
use yii\base\Component;
use yii\base\Exception;
use yii\db\Query;

class BiSync extends Component
{
    public $model;
    public $action;

    private $_attrs = [];

    public function getTargetTable()
    {
        throw new Exception("method " . static::className() . "::getTargetTable() should be implemented");
    }

    public function run()
    {
        throw new Exception("method " . static::className() . "::run() should be implemented");

        
    }

    public function execute()
    {
        if ($this->action == "delete") {
            $this->delete();
        } else {
            $this->update();
        }
    }

    public function attr($name, $value)
    {
        $this->_attrs[$name] = $value;
        return $this;
    }

    public function getAttrs()
    {
        return $this->_attrs;
    }

    public function delete()
    {
        return $this->deleteAll('id', $this->model->id);
    }

    public function deleteAll($attribute, $value)
    {
        return Yii::$app->bi->createCommand()->delete($this->getTargetTable(), [$attribute => $value])->execute();
    }

    public function update()
    {
        $query = new Query();
        $row = $query->from($this->getTargetTable())->where(['id' => $this->model->id])->one(Yii::$app->bi);
        $attrs = $this->getAttrs();
        $attrs['updated_at'] = time();
        if ($row) {
            Yii::$app->bi->createCommand()->update($this->getTargetTable(), $attrs, ['id' => $this->model->id])->execute();
        } else {
            $attrs['id'] = $this->model->id;
            $attrs['created_at'] = time();
            Yii::$app->bi->createCommand()->insert($this->getTargetTable(), $attrs)->execute();
        }
    }
}