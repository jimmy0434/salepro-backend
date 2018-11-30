<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11/30/2018
 * Time: 8:34 AM
 */

namespace backend\components\biSync;


use backend\components\BiSync;

/**
 * Class Admin
 * @package backend\components\biSync
 * @property \cnd\admin\models\activerecords\Admin $model
 */
class Admin extends BiSync
{
    public function getTargetTable(){
        return "user";
    }

    public function run(){
        $this
            ->attr("name", $this->model->userName)
            ->attr("status", strtolower($this->model->user->status_label))
            ->attr("type", strtolower($this->model->user->type_label))
            ->attr("role_id", strtolower($this->model->user->role_id))
        ;
    }
}