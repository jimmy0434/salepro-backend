<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 3/14/2019
 * Time: 12:48 PM
 */

namespace backend\widgets;

use common\models\LogStore;
use common\models\User;
use Yii;
use yii\base\Widget;

class Log extends Widget
{
    public $userId = null;

    public function run()
    {
        $query = LogStore::find();
        if (Yii::$app->user->identity->type != User::TYPE_ROOT) {
            $query->andWhere(['level' => 'Trace']);
        }
        $query->andWhere(['user_id' => $this->userId]);
        $query->limit(100)->offset(0)->orderBy('id DESC');
        $list = $query->all();

        return $this->render('log', ['list' => $list]);
    }
}
