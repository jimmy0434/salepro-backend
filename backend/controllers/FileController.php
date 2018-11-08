<?php
/**
 * Created by PhpStorm.
 * User: JawdatSobh
 * Date: 08/11/2018
 * Time: 16:43
 */

namespace backend\controllers;

use common\models\File;
use Yii;
use cnd\core\components\SController;

class FileController extends SController
{
    public function actionIndex(){
        $dataLocator = \cnd\grid\DataLocator::create(File::className(), [
            'orderBy' => 'updated_at DESC, created_at DESC, id DESC',
        ]);
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('index', ['dataLocator' => $dataLocator]);
        }
        return $this->render('index', ['dataLocator' => $dataLocator]);
    }

    public function actionManageMetaData(){

    }

    public function actionManageFile(){

    }

    public function actionDelete(){

    }
}