<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 12/14/2018
 * Time: 3:32 PM
 */

namespace backend\components\biSync;


use backend\components\BiSync;

class Category extends BiSync
{
    public function getTargetTable(){
        return "category";
    }

    public function run(){
        $this
            ->attr("name", $this->model->name)
            ->attr("status", strtolower($this->model->status_label))
            ->attr("parent_id", $this->model->parent_id)
        ;
    }
}