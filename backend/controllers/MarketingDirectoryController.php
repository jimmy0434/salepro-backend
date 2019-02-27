<?php
/**
 * Created by PhpStorm.
 * Project: masterpak
 * Company: Codendot <https://codendot.com>
 * User: Jawdat Sobh <jawdat@codendot.com>
 * Date: 2/27/2019
 * Time: 4:07 PM
 */

namespace backend\controllers;

use Yii;
use cnd\admin\models\activerecords\Setting;
use cnd\core\components\SController;
use common\models\File;

class MarketingDirectoryController extends SController
{
    public function actionIndex()
    {
        $id = Setting::get('marketing.directory.file.id', null);
        $model = File::findOne($id);
        if (!$model) {
            $model = new File();
        }
        if ($model->load(\Yii::$app->request->post()) && $model->id) {
            Setting::set('marketing.directory.file.id', $model->id, true);
            return $this->refresh();
        }
        return $this->render('index', ['model' => $model]);
    }
}
