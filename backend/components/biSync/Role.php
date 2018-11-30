<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11/30/2018
 * Time: 9:05 AM
 */

namespace backend\components\biSync;


use backend\components\BiSync;

class Role extends BiSync
{
    public function getTargetTable(){
        return "role";
    }

    public function run(){
        $this
            ->attr("name", $this->model->name)
            ->attr("level", strtolower($this->model->level_label))
        ;
    }
}