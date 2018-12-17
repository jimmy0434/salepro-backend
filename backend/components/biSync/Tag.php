<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 12/14/2018
 * Time: 3:52 PM
 */

namespace backend\components\biSync;

use backend\components\BiSync;

class Tag extends BiSync
{
    public function getTargetTable(){
        return "tag";
    }

    public function run(){
        $this
            ->attr("name", $this->model->name)
        ;
    }
}