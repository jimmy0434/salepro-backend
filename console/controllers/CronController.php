<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 12/4/2018
 * Time: 1:21 PM
 */

namespace console\controllers;

use yii\console\Controller;
use yii\console\widgets\Table;

class CronController extends Controller
{
    public function actionLogTransfer(){
        echo Table::widget([
            'headers' => ['test1', 'test2', 'test3'],
            'rows' => [
                ['col1', 'col2', 'col3'],
                ['col1', 'col2', ['col3-0', 'col3-1', 'col3-2']],
            ],
        ]);
    }
}