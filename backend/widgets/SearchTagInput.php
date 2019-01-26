<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 1/26/2019
 * Time: 10:17 AM
 */

namespace backend\widgets;


use yii\base\Widget;

class SearchTagInput extends Widget
{
    public $model;
    public $form;

    public function run(){
        return $this->render('search-tag-input');
    }
}