<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 12/17/2018
 * Time: 9:23 AM
 */

namespace backend\components\biSync;

use backend\components\BiSync;

class ContentImage extends BiSync
{
    public function getTargetTable(){
        return "content_image";
    }

    public function run(){
        $this
            ->attr("content_id", $this->model->content_id)
            ->attr("image", $this->model->image)
        ;
    }
}