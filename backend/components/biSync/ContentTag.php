<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 12/14/2018
 * Time: 4:43 PM
 */

namespace backend\components\biSync;

use backend\components\BiSync;

class ContentTag extends BiSync
{
    public function getTargetTable(){
        return "content_tag";
    }

    public function run(){
        $this
            ->attr("content_id", $this->model->content_id)
            ->attr("tag_id", $this->model->tag_id)
        ;
    }
}