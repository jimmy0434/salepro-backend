<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 12/20/2018
 * Time: 8:41 AM
 */

namespace backend\controllers;

use Yii;
use cnd\core\components\SController;

class ContentController extends SController
{
    public function actionIndex(){
        return $this->render("index");
    }
}