<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 1/27/2019
 * Time: 11:20 AM
 */

namespace backend\widgets;


use yii\base\Widget;

class AutoCompleteInput extends Widget
{
    public $model;
    public $form;
    public $property;
    public $findUrl;
    public $addUrl;
    public $title = null;
    public $data = [];

    public function run(){
        return $this->render('auto-complete-input');
    }
}