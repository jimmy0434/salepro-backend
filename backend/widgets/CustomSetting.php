<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/25/2019
 * Time: 1:44 PM
 */

namespace backend\widgets;

use Yii;
use cnd\admin\models\activerecords\Setting;
use yii\base\Widget;

class CustomSetting extends Widget
{

    public $title;
    public $name;
    public $input = null;

    private $_model = null;

    public function run()
    {
        if(Yii::$app->permission->can('/admin/setting/update')) {
            $this->_model = Setting::find()->where(['name' => $this->name])->one();
            return $this->render('custom-setting');
        }
        return null;
    }

    public function getModel()
    {
        if(!$this->_model){
            $this->_model = new Setting();
            $this->_model->name = $this->name;
            $this->_model->value = "";
            $this->_model->type = Setting::TYPE_TEXT;
            $this->_model->options = '';
            $this->_model->save();
        }
        return $this->_model;
    }

}
