<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11/30/2018
 * Time: 9:33 AM
 */

namespace backend\components\biSync;


use backend\components\BiSync;

class Salesman extends BiSync
{
    public function getTargetTable(){
        return "user";
    }

    public function run(){
        $this
            ->attr("name", $this->model->name)
            ->attr("status", strtolower($this->model->user->status_label))
            ->attr("type", strtolower($this->model->user->type_label))
        ;
    }
}