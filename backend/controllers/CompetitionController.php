<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/6/2019
 * Time: 12:24 PM
 */

namespace backend\controllers;


use cnd\core\components\SController;

class CompetitionController extends SController
{
    public function actionIndex(){
        return $this->render('index');
    }
}
