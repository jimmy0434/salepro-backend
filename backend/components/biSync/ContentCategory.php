<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 12/14/2018
 * Time: 4:16 PM
 */

namespace backend\components\biSync;

use backend\components\BiSync;

class ContentCategory extends BiSync
{

    public function getTargetTable(){
        return "content_category";
    }

    public function run(){
        $this
            ->attr("content_id", $this->model->content_id)
            ->attr("category_id", $this->model->category_id)
            ->attr("is_primary", $this->model->is_primary)
        ;
    }
}